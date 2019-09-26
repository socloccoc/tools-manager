<?php


namespace App\Http\Controllers\FrontEnd;


use Illuminate\Http\Request;
use Informatics\Base\Models\ChargeCardHistory;
use Informatics\Base\Models\PurchasedAccount;
use Informatics\Category\Models\Category;
use Sentinel;

class ChargeCardHistoryController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $user = Sentinel::getUser();
        $inputData = $request->all();
        $conditions = $this->conditionHandle($request);
        array_push($conditions, ['user_id', '=', $user->id]);
        $query = app(ChargeCardHistory::class)->newQuery();
        $query = $query->where($conditions)
            ->where(function ($query) use ($request) {
                if (isset($request->find) && !empty($request->find)) {
                    $query->where('pin', '=', $request->find)->orWhere('serial', '=', $request->find);
                }
                if (isset($request->status) && $request->status != '') {
                    if ($request->status == 3) {
                        $query->where('fix_amount', '=', 1);
                    } else {
                        $query->where('status', '=', $request->status);
                    }
                }

            });
        $query = $query->orderBy('charge_time', 'DESC');
        $chargeCardHistory = $query->select('db_charge_card_histories.*')->get();
        return view('frontend.history.charge-card', compact('chargeCardHistory', 'inputData'));
    }

    public function conditionHandle($request)
    {
        $conditions = [];
        if ($request->exists('start_date') && !empty($request->start_date)) {
            array_push($conditions, ['created_at', '>=', $request->start_date . ' 00:00:00']);
        }
        if ($request->exists('end_date') && !empty($request->end_date)) {
            array_push($conditions, ['created_at', '<=', $request->end_date . ' 23:59:00']);
        }
        return $conditions;
    }

}
