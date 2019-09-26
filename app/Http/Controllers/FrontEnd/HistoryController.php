<?php


namespace App\Http\Controllers\FrontEnd;


use Illuminate\Http\Request;
use Informatics\Base\Models\PurchasedAccount;
use Informatics\Category\Models\Category;
use Sentinel;

class HistoryController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function purchasedAccount(Request $request)
    {
        $user = Sentinel::getUser();
        $categories = Category::all();
        $inputData = $request->all();
        $conditions = $this->conditionHandle($request);
        array_push($conditions, ['user_id', '=', $user->id]);
        $query = app(PurchasedAccount::class)->with(['category'])->newQuery();
        $query = $query->where($conditions);
        $query = $query->orderBy('date', 'DESC');
        $accounts = $query->select('db_purchased_accounts.*')->get();
        return view('frontend.history.purchased-account', compact('accounts', 'categories', 'inputData'));
    }

    public function conditionHandle($request)
    {
        $conditions = [];
        if ($request->exists('code') && !empty($request->code)) {
            array_push($conditions, ['account', 'like', "%{$request->code}%"]);
        }
        if ($request->exists('category_id') && !empty($request->category_id)) {
            array_push($conditions, ['cat_id', '=', $request->category_id]);
        }
        if ($request->exists('start_date') && !empty($request->start_date)) {
            array_push($conditions, ['date', '>=', $request->start_date . ' 00:00:00']);
        }
        if ($request->exists('end_date') && !empty($request->end_date)) {
            array_push($conditions, ['date', '<=', $request->end_date . ' 23:59:00']);
        }

        if ($request->exists('price_range') && $request->price_range != '') {
            $maxPrice = 0;
            $minPrice = 0;
            switch ($request->price_range) {
                case 0:
                    $maxPrice = 50000;
                    break;
                case 1:
                    $maxPrice = 200000;
                    $minPrice = 50000;
                    break;
                case 2:
                    $maxPrice = 500000;
                    $minPrice = 200000;
                    break;
                case 3:
                    $maxPrice = 1000000;
                    $minPrice = 500000;
                    break;
                case 4:
                    $minPrice = 1000000;
                    break;
                case 5:
                    $minPrice = 3000000;
                    break;
                case 6:
                    $minPrice = 5000000;
                    break;
                default:
                    $maxPrice = 0;
                    $minPrice = 0;
                    break;
            }
            if ($minPrice != 0) {
                array_push($conditions, ['price', '>=', $minPrice]);
            }
            if ($maxPrice != 0) {
                array_push($conditions, ['price', '<=', $maxPrice]);
            }
        }
        return $conditions;
    }

}
