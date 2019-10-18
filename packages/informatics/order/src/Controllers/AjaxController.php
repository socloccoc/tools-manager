<?php


namespace Informatics\Order\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Informatics\Base\Models\DataAddress;
use Informatics\Base\Models\OrderWeb;
use Informatics\Order\Models\Order;
use Request;

class AjaxController extends Controller
{

    public function getDistrictByProvince()
    {
        if (Request::ajax()) {
            $province = Request::get('province');
            $district = DataAddress::where('province', $province)
                ->groupBy('district')
                ->select('district')
                ->get();
            return $district;
        }
    }

    public function getVillageByDistrict()
    {
        if (Request::ajax()) {
            $province = Request::get('province');
            $district = Request::get('district');
            $village = DataAddress::where('district', $district)
                ->where('province', $province)
                ->groupBy('village')
                ->select('village')
                ->get();
            return $village;
        }
    }

    public function getSessionByDate(){
        if (Request::ajax()) {
            $date = Request::get('date');
            $session = OrderWeb::where(DB::raw('SUBSTRING(order_webs.created_at, 1, 10)'), $date)
                ->select(DB::raw('SUBSTRING(order_webs.created_at, 12, 22) as session'))
                ->groupBy('session')
                ->get();
            return $session;
        }
    }

}
