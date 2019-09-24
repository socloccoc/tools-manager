<?php

namespace Informatics\Agency\Controllers;

use App\Helpers\BasicHelper;
use App\Helpers\KeyHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Informatics\Agency\Requests\UserCreateRequest;
use Informatics\Agency\Requests\UserUpdateRequest;
use Informatics\Base\Models\AddPointHistory;
use Informatics\Base\Models\UserApp;
use Informatics\Tool\Models\Tool;
use Informatics\Users\Repositories\Db\DbUsersRepository as UserRepo;
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
        $apps = KeyHelper::apps()['data'];
        return view('agency::create.create', compact('apps'));
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
            $apps = KeyHelper::apps()['data'];
            if (count($apps) > 0) {
                $appData = [];
                $pointHistoryData = [];
                foreach ($apps as $app) {
                    $key = $request['app_' . $app['id']];
                    $point = $request['point_' . $app['id']];
                    $appData[] = ['user_id' => $user['id'], 'app_id' => $app['id'], 'key' => $key, 'total_point' => $point, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                    $pointHistoryData[] = ['sender_id' => $agencyId, 'receiver_id' => $user['id'], 'app_id' => $app['id'], 'key' => $key, 'point' => $point, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
                    if ($key == '') continue;
                    // validate key
                    $keyValidate = KeyHelper::validateKey($key, $app['id']);
                    if ($keyValidate['success'] == false) {
                        return Redirect::back()->withErrors([$keyValidate['message']]);
                    }
                }
                UserApp::insert($appData);
            }

            // app point for key
            foreach ($pointHistoryData as $point) {
                KeyHelper::addPointforKey($point['key'], $point['point']);
            }

            //Insert point history
            AddPointHistory::insert($pointHistoryData);

            DB::commit();
            return redirect('manager/user')->with('message', 'Thêm người dùng thành công !');
        } catch (\Exception $ex) {
            DB::rollBack();
            return Redirect::back()->withErrors([$ex->getMessage()]);
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
