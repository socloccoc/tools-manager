<?php


namespace App\Http\Controllers\FrontEnd;


use App\Helpers\BasicHelper;
use Informatics\Account\Models\Account;
use Request;
use Informatics\Base\Models\PurchasedAccount;
use Informatics\Category\Models\Category;
use Sentinel;

class AjaxController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAccountInfo(Request $request)
    {
        if (Request::ajax()) {
            $accountCode = Request::get('account');
            $user = BasicHelper::getUserDetails();
            $userId = $user->id;
            $account = PurchasedAccount::join('db_account', 'db_account.code', '=', 'db_purchased_accounts.account')
                ->where('db_purchased_accounts.user_id', $userId)
                ->where('db_purchased_accounts.account', $accountCode)
                ->select('db_account.*')
                ->first();

            if ($account) {
                $account->password = BasicHelper::safeDecrypt($account->password);
                return $account;
            }
            return null;
        }
    }


}
