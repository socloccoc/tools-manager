<?php


namespace App\Http\Controllers\FrontEnd;


use App\Helpers\BasicHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Informatics\Account\Models\Account;
use Informatics\Base\Models\PurchasedAccount;
use Informatics\Users\Models\User;
use Validator;
use Sentinel;
use Log;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function profile()
    {
        $user = BasicHelper::getUserDetails();
        return view('frontend.profile.index', compact('user'));
    }

    public function changePassword()
    {
        return view('frontend.change_password.index');
    }

    public function changePasswordComplete(Request $request)
    {
        $this->validate($request, [
            'old_password'          => 'required',
            'password'              => 'required|same:password',
            'password_confirmation' => 'required|same:password',
        ], []);

        $hasher = Sentinel::getHasher();

        $oldPassword = $request->old_password;
        $password = $request->password;

        $user = Sentinel::getUser();

        if (!$hasher->check($oldPassword, $user->password)) {
            return redirect('user/change-password')->with('message', 'Đổi password thất bại');
        }

        Sentinel::update($user, array('password' => $password));

        return redirect('user/change-password')->with('message', 'Đổi password thành công');
    }

    public function buyacc(Request $request)
    {
        $data = $request->only('account_code');
        $user = Sentinel::getUser();
        $account = Account::findByCode($data['account_code']);

        if (!$account || $account->sale_status != 0) {
            return redirect('tran/acc')->with('error_message', 'Tài khoản không tồn tại !');
        }

        if ($user['amount'] < $account->price_atm) {
            return redirect('tran/acc')->with('error_message', 'Bạn không đủ tiền !');
        }

        $remainingAmount = $user['amount'] - $account->price_atm;
        try {
            DB::beginTransaction();
            $udpateUser = User::where('id', $user['id'])->update(['amount' => $remainingAmount]);
            if ($udpateUser) {
                $updateAccount = Account::where('id', $account->id)->update(['sale_status' => config('constants.SALE_STATUS.SOLD')]);
            }
            if ($udpateUser && $updateAccount) {
                // insert history
                $history = [
                    'user_id' => $user['id'],
                    'date'    => Carbon::now()->format('Y-m-d H:i:s'),
                    'cat_id'  => $account->cat_id,
                    'account' => $account->code,
                    'price'   => $account->price_atm,
                ];
                if (PurchasedAccount::create($history)) {
                    DB::commit();
                    Log::info('User has purchased an account', array('ItemID' => $user->id, 'Module' => 'Users'));
                    return redirect('tran/acc')->with('message', 'Bạn đã mua tài khoản thành công!');
                } else {
                    DB::rollBack();
                    return redirect('tran/acc')->with('error_message', 'Mua tài khoản thất bại');
                }
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect('tran/acc')->with('error_message', $ex->getMessage());
        }
    }
}
