<?php

namespace Informatics\Admin\Controllers;

use App\Http\Controllers\Controller;
use Informatics\Admin\Requests\SystemAdminCreateRequest;
use Informatics\Admin\Requests\ToolCreateRequest;
use Informatics\Admin\Requests\SystemAdminUpdateRequest;
use Informatics\Users\Repositories\Db\DbUsersRepository as UserRepo;
use Sentinel;
use Illuminate\Http\Request;
use Input;
use Helper;
use Permission;
use Informatics\Admin\Repository\Db\DbAdminRepository as AdminRepo;
use Log;
use Redirect;

class IndexController extends Controller
{
    const ADD_ACCOUNT_SUCCESS_MSG = 'Thêm tài khoản thành công !';
    /**
     *  Display a listing of Admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Toinn
     */
    public function index()
    {
        $roles = $this->getUserRoles();
        $keyword = Input::get('keyword');

        // array to show selected values for search conditions
        $filters = array(
            'Keyword' => trim($keyword),
        );

        $sortInfo = array();
        if (Input::has('sort') && Input::has('dir')) {
            $sortInfo['column'] = Input::get('sort');
            $sortInfo['order'] = Input::get('dir');
        }

        $adminRepo = new AdminRepo();

        $query = $adminRepo->getUserList($filters, $sortInfo);
        $pagination = $query->paginate('15')->render();
        $admins = $query->get();
        //Getting list of sortable columns
        $columns = $this->getSortableColumn();

        return view('admin::index.index', compact('admins', 'columns', 'pagination', 'filters', 'roles'));

    }

    /**
     * This function used to get the list of users available in drop Down.
     *
     * @param void
     * @return array $roles
     * @author Toinn
     */
    public function getUserRoles()
    {

        $roles = array();

        if (Permission::isSuperAdmin()) {
            $roles = [
                '1' => 'Super Admin',
                '2' => 'System Admin',
            ];
        } elseif (Permission::isSystemAdmin()) {
            $roles = [
                '2' => 'System Admin',
            ];
        }

        return $roles;
    }

    public function getSortableColumn()
    {
        $columns = array(
            'users.name' => 'Name',
            'users.email' => 'Email',
            'roleName.name' => 'Role',
            'users.point' => 'Point',
            'users.last_login' => 'Last Login',
        );
        return Helper::getSortableColumnOnArray($columns);
    }

    /**
     * Show form to add account
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = $this->getUserRoles();
        return view('admin::create.create', compact('roles'));
    }

     /**
     * Function to add a new account into the system
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(SystemAdminCreateRequest $request)
    {
        //Form Data
        $newUser = $request->only('username', 'email', 'password', 'name');
        $data = $request->all();
        $userRepo = new UserRepo();
        //Creating new user
        $user = $userRepo->insert($newUser);
        $data['role'] = config('constants.roles.agency');;

        //Setting user Role
        $role = Sentinel::findRoleById($data['role']);
       
        $role->users()->attach($user);

        return Redirect::route('admin.index')
            ->withMessage('Bạn đã thêm thành công một cộng tác viên !');
    }

    public function edit($id)
    {
        $currentID = Sentinel::getUser()->id;
        if (Permission::checkRole($currentID, 'super-admin')) {
            if ($currentID != $id && Permission::isAgency()) {
                abort(405);
            }else{
                $userRepo = new UserRepo();
                $agency = $userRepo->getUserDetailById($id);
                if (Permission::isSuperAdmin() || $currentID == $id && Permission::checkRole($id, 'super-admin')) {
                    return view('admin::create.create', compact( 'agency'));
                }else{
                    abort(404);
                }
            }
        }else{
            return redirect('manager/admin')
            ->with('error_message', 'Either User Not Found or Editing in a wrong role.');
        }
    }

    public function update(SystemAdminUpdateRequest $request,  $userId)
    {
        $userRepo = new UserRepo();
        $userDetail = $userRepo->getUserDetailById($userId);
        
        if ($userDetail->email != $request->get('email')) {
            $userData['email'] = $request->get('email');
        }

        $userData['name'] = $request->get('name');
        $userData['username'] = $request->get('username');
        $userRepo->update($userData, $userId);

        return Redirect::back()
        ->withMessage('Cập nhật thông tin công tác viên thành công');

    }

}
