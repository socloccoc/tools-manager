<?php

namespace Informatics\Agency\Controllers;

use App\Helpers\BasicHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Informatics\Agency\Requests\UserCreateRequest;
use Informatics\Agency\Requests\UserUpdateRequest;
use Informatics\Base\Models\AddPointHistory;
use Informatics\Base\Models\UserTool;
use Informatics\Tool\Models\Tool;
use Informatics\Users\Repositories\Db\DbUsersRepository as UserRepo;
use Mockery\Exception;
use Sentinel;
use Illuminate\Http\Request;
use Input;
use Helper;
use Permission;
use Informatics\Agency\Repository\Db\DbAdminRepository as AdminRepo;
use Log;
use Redirect;

class IndexController extends Controller
{

    /**
     *  Display a listing of Admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Toinn
     */
    public function index()
    {
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

        return view('agency::index.index', compact('admins', 'columns', 'pagination', 'filters'));

    }

    public function getSortableColumn()
    {
        $columns = array(
            'users.name'       => 'Name',
            'users.email'      => 'Email',
            'roleName.name'    => 'Role',
            'users.point'      => 'Point',
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
        $tools = Tool::all();
        return view('agency::create.create', compact('tools'));
    }

    /**
     * Function to add a new account into the system
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserCreateRequest $request)
    {
        try {
            $newUser = $request->only('username', 'email', 'password', 'name');
            DB::beginTransaction();
            $agencyId = BasicHelper::getUserDetails()->id;
            $newUser['parent_id'] = $agencyId;
            $data = $request->all();
            $userRepo = new UserRepo();
            //Creating new user
            $user = $userRepo->insert($newUser);
            $data['role'] = config('constants.roles.user');

            //Setting user Role
            $role = Sentinel::findRoleById($data['role']);
            $role->users()->attach($user);

            //Insert tool
            $tools = Tool::all();
            if (count($tools) > 0) {
                $toolData = [];
                $pointHistoryData = [];
                foreach ($tools as $tool) {
                    $toolData[] = ['user_id' => $user['id'], 'tool_id' => $tool['id'], 'key' => $request['tool_' . $tool['id']], 'total_point' => $request['point_' . $tool['id']], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                    $pointHistoryData[] = ['sender_id' => $agencyId, 'receiver_id' => $user['id'], 'tool_id' => $tool['id'], 'key' => $request['tool_' . $tool['id']], 'point' => $request['point_' . $tool['id']], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                }
                UserTool::insert($toolData);
            }

            //Insert point history
            AddPointHistory::insert($pointHistoryData);

            DB::commit();
            return redirect('manager/user')->with('message', 'Thêm người dùng thành công !');
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect('manager/user')->with('error_message', 'Either User Not Found or Editing in a wrong role.');
        }
    }

    public function edit($id)
    {
        $currentID = Sentinel::getUser()->id;
        if (Permission::checkRole($currentID, 'agency')) {
            if ($currentID != $id && Permission::isUser()) {
                abort(405);
            } else {
                $tools = Tool::all();
//                $userTool = UserTool::join('tools')
                $userRepo = new UserRepo();
                $user = $userRepo->getUserDetailById($id);
                return view('agency::create.create', compact('user', 'tools'));
            }
        } else {
            return redirect('manager/user')->with('error_message', 'Either User Not Found or Editing in a wrong role.');
        }
    }

    public function update(UserUpdateRequest $request, $userId)
    {
        $userRepo = new UserRepo();
        $userDetail = $userRepo->getUserDetailById($userId);

        if ($userDetail->email != $request->get('email')) {
            $userData['email'] = $request->get('email');
        }

        $userData['name'] = $request->get('name');
        $userData['username'] = $request->get('username');
        $userRepo->update($userData, $userId);

        return Redirect::back()->withMessage('Cập nhật thông tin người dùng thành công');

    }

}
