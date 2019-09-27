<?php

namespace Informatics\Users\Controllers;

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
    /**
     *  Display a listing of user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Toinn
     */
    public function index(Request $request)
    {
        $status = isset($request->status) ? $request->status : -1;
        $userLoginId = BasicHelper::getUserDetails()->id;

        $query = app(Key::class)->newQuery()->with(['tool', 'user']);
        $query = $query->where(function ($query) use ($status, $userLoginId) {
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
            $query->where('user_id', '=', $userLoginId);
        });
        $keys = $query->select('keys.*')->get();
        return view('users::index.index', compact('keys', 'status'));
    }

}
