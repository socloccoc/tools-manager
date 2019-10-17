<?php


namespace Informatics\Order\Controllers;

use App\Http\Controllers\Controller;
use Informatics\Base\Models\DataAddress;
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

}
