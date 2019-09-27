<?php

namespace Informatics\Key\Controllers;

use App\Helpers\BasicHelper;
use App\Exports\KeyExport;
use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Informatics\Base\Models\Fee;
use Informatics\Key\Models\Key;
use Informatics\Key\Requests\KeyCreateRequest;
use Informatics\Key\Requests\KeyUpdateRequest;
use Informatics\Tool\Models\Tool;
use Informatics\Key\Repository\Db\DbAdminRepository as AdminRepo;
use Sentinel;
use Illuminate\Http\Request;
use Input;
use Helper;
use Permission;
use Log;
use Redirect;
use Excel;

class IndexController extends Controller
{
    const ADD_ACCOUNT_SUCCESS_MSG = 'Thêm tài khoản thành công !';

    /**
     *  Display a listing of Admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Toinn
     */
    public function index(Request $request)
    {
        $status = isset($request->status) ? $request->status : -1;
        $userId = isset($request->user_id) ? $request->user_id : '';
        $userLoginId = BasicHelper::getUserDetails()->id;
        $users = [];
        if (PermissionHelper::isSuperAdmin()) {
            $users = User::where('id', '!=', $userLoginId)->get();
        }
        if (PermissionHelper::isAgency()) {
            $users = User::where('id', '!=', $userLoginId)->where('parent_id', $userLoginId)->get();
        }

        $query = app(Key::class)->newQuery()->with(['tool', 'user']);
        if (PermissionHelper::isAgency()) {
            $query = $query->join('users', function ($join) use ($userLoginId) {
                $join->on('keys.user_id', '=', 'users.id')->where('users.parent_id', '=', $userLoginId);
            });
        }
        $query = $query->where(function ($query) use ($status, $userId) {
            if($status != -1) {
                if ($status == 1) {
                    $query->where('expire_date', '!=', null);
                } elseif ($status == 2) {
                    $query->where('expire_date', '>=', Carbon::now()->format('Y-m-d H:i:s'));
                } elseif ($status == 3) {
                    $query->where('expire_date', '<', Carbon::now()->format('Y-m-d H:i:s'));
                } else {
                    $query->where('expire_date', '=', null);
                }
            }
            if ($userId != '') {
                $query->where('user_id', '=', $userId);
            }
        });
        $keys = $query->select('keys.*')->get();
        return view('key::index.index', compact('keys', 'users', 'userId', 'status'));
    }

    public function updateKey(Request $request)
    {
        $this->validate($request, [
            'modal_key_id'   => 'required|integer|min:0',
            'point_order'    => 'required|integer|min:0',
            'point_register' => 'required|integer|min:0',
        ], []);
        try {
            $data = [
                'expire_date'    => $request->expire_date,
                'serial_number'  => $request->serial_number,
                'point_order'    => $request->point_order,
                'point_register' => $request->point_register,
            ];
            $key = Key::where('id', $request->modal_key_id)->limit(1)->update($data);
            if ($key) {
                return redirect('manager/key')->with('message', 'Cập nhật thành công !');
            } else {
                return redirect('manager/key')->with('error_message', 'Cập nhật thất bại !');
            }
        } catch (\Exception $ex) {
            return redirect('manager/key')->with('error_message', $ex->getMessage());
        }
    }

    /**
     * Show form to add tool
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $tools = Tool::all();
        $adminRepo = new AdminRepo();
        $users = $adminRepo->getUserList(null, null)->get();
        return view('key::create.create', compact('tools', 'users'));
    }

    /**
     * Function to add a new tool into the system
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(KeyCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $tool = Tool::where('id', $request->tool_id)->first();
            if (!$tool) {
                return redirect('key/create')->with('error_message', 'App not found !');
            }
            $userCreate = BasicHelper::getUserDetails();
            $user = Sentinel::findById($request->user_id);
            $keys = [];
            $fees = [];
            for ($i = 0; $i < $request->number; $i++) {
                $licenceKey = $this->random_strings(9);
                $keys[] = [
                    'tool_id'        => $request->tool_id,
                    'user_id'        => $request->user_id,
                    'licence_key'    => $licenceKey,
                    'point_order'    => isset($request->point_order) ? $request->point_order : 0,
                    'point_register' => isset($tool->max_point) ? $tool->max_point : 0,
                    'user_create_id' => isset($userCreate->id) ? $userCreate->id : 0,
                    'expire_time'    => $request->expire_time,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now()
                ];
                $fees[] = [
                    'tool_id'     => $request->tool_id,
                    'user_id'     => $userCreate->id,
                    'licence_key' => $licenceKey,
                    'value'       => $tool->fee * $request->expire_time,
                    'action'      => config('constants.key_action.create_licence'),
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ];
                if ($request->point_order > 0) {
                    $fees[] = [
                        'tool_id'     => $request->tool_id,
                        'user_id'     => $userCreate->id,
                        'licence_key' => $licenceKey,
                        'value'       => $request->point_order * 2000,
                        'action'      => config('constants.key_action.add_point'),
                        'created_at'  => Carbon::now(),
                        'updated_at'  => Carbon::now()
                    ];
                }
            }

            // insert to keys table
            $key = Key::insert($keys);
            if (!$key) {
                DB::rollBack();
                return redirect('key/create')->with('error_message', 'Key generate error !');
            }

            // insert to fee table
            $fee = Fee::insert($fees);
            if (!$fee) {
                DB::rollBack();
                return redirect('key/create')->with('error_message', 'Key generate error !');
            }

            $toolName = $tool->name;
            for ($i = 0; $i < count($keys); $i++) {
                $keys[$i]['app_id'] = $toolName;
            }
            $userCreateName = $userCreate->full_name;
            for ($i = 0; $i < count($keys); $i++) {
                $keys[$i]['user_create_id'] = $userCreateName;
            }

            $userName = $user->name;
            for ($i = 0; $i < count($keys); $i++) {
                $keys[$i]['user_id'] = $userName;
            }

            // export excel
            $header = $this->getHeader();
            $dataExcel = new KeyExport([$keys], $header);

            $excel = Excel::download($dataExcel, "key-gen-( user create: $userCreateName )-( user : $userName ) " . Carbon::now()->format('Y-m-d-his') . ".xlsx");
            DB::commit();
            return $excel;
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect('manager/key')->with('error_message', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        $currentID = Sentinel::getUser()->id;
        if (Permission::checkRole($currentID, 'super-admin')) {
            $tool = Tool::where('id', $id)->first();
            return view('tool::create.create', compact('tool'));
        } else {
            return redirect('manager/tool')
                ->with('error_message', 'Either User Not Found or Editing in a wrong role.');
        }
    }

    public function adjournKey(Request $request)
    {
        $this->validate($request, [
            'modal_key_adjourn_id' => 'required|integer|min:0',
            'point_order'          => 'integer|min:0',
            'number_of_months'     => 'integer|min:0',
        ], []);
        $pointOrder = isset($request->point_order) ? $request->point_order : 0;
        $numberOfMonths = isset($request->number_of_months) ? $request->number_of_months : 0;
        $userLoginId = BasicHelper::getUserDetails()->id;
        try {
            DB::beginTransaction();
            $key = Key::where('id', $request->modal_key_adjourn_id)->first();
            if (!$key) {
                return Redirect::back()->withErrors(['Key không tồn tại !']);
            }
            $expireDate = $key['expire_date'];
            $newKey['point_order'] = $pointOrder + $key['point_order'];
            $newKey['expire_time'] = $numberOfMonths + $key['expire_time'];
            if ($expireDate != '' && $numberOfMonths > 0) {
                if ($expireDate > Carbon::now()) {
                    $newKey['expire_date'] = Carbon::now()->addMonth($numberOfMonths);
                } else {
                    $newKey['expire_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $key['expire_date'])->addMonth($numberOfMonths);
                }
            }
            $keyUpdate = Key::where('id', $request->modal_key_adjourn_id)->limit(1)->update($newKey);
            if (!$keyUpdate) {
                return Redirect::back()->withErrors(['Gia hạn thất bại']);
            }
            $tool = Tool::where('id', $key['tool_id'])->first();

            $fees = [];
            if($numberOfMonths > 0){
                $fees[] = ['user_id' => $userLoginId, 'tool_id' => $key['tool_id'], 'licence_key' => $key['licence_key'], 'value' => $numberOfMonths * $tool['fee'], 'action' => config('constants.key_action.adjourn'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
            }
            if($pointOrder > 0){
                $fees[] = ['user_id' => $userLoginId, 'tool_id' => $key['tool_id'], 'licence_key' => $key['licence_key'], 'value' => $pointOrder * 2000, 'action' => config('constants.key_action.add_point'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
            }
            Fee::insert($fees);
            DB::commit();
            return Redirect::back()->withMessage('Gia hạn thành công !');
        } catch (\Exception $ex) {
            DB::rollBack();
            Redirect::back()->withErrors(['Gia hạn thất bại']);
        }
    }

    /**
     * delete a key ( update expire_date to current datetime )
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteKey($id)
    {
        try {
            $key = Key::where('id', $id)->limit(1)->update(['expire_date' => Carbon::now()->subHour()->format('Y-m-d H:i:s')]);
            if ($key) {
                return Redirect::back()->withMessage('Xóa key thành công');
            }
            return Redirect::back()->withErrors(['Xóa key thất bại']);
        } catch (\Exception $ex) {
            return Redirect::back()->withErrors([$ex->getMessage()]);
        }
    }

    /**
     * changeSirial ( exchange machine, remove serial_number )
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeSirial($id)
    {
        try {
            $key = Key::where('id', $id)->limit(1)->update(['serial_number' => '']);
            if ($key) {
                return Redirect::back()->withMessage('Đã xóa thông tin máy !');
            }
            return Redirect::back()->withErrors(['Thay đổi máy thất bại']);
        } catch (\Exception $ex) {
            return Redirect::back()->withErrors([$ex->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $tool = Tool::where('id', $id)->delete();
            if ($tool) {
                return Redirect::back()->withMessage('Xóa tool thành công');
            }
        } catch (\Exception $ex) {
            return redirect('manager/tool')->with('error_message', $ex->getMessage());
        }
    }

    private function getHeader()
    {
        return $header = [
            'App',
            'User',
            'Licence_key',
            'Point_order',
            'Point_register',
            'User_create',
            'Expire_time',
            'created_at',
            'updated_at'
        ];
    }

    private function random_strings($length_of_string)
    {
        return substr(bin2hex(random_bytes($length_of_string)),
            0, $length_of_string);
    }

}
