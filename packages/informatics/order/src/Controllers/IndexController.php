<?php

namespace Informatics\Order\Controllers;

use App\Helpers\BasicHelper;
use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Informatics\Base\Models\OrderWeb;
use Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Informatics\Base\Models\DataAddress;
use Informatics\Order\Models\Order;
use Informatics\Order\Requests\OrderCreateRequest;
use Input;
use Helper;
use Permission;
use Log;
use Redirect;
use Excel;
use App\Exports\KeyExport;
use App\Imports\DataAddressImport;
use Validator;

class IndexController extends Controller
{

    /**
     *  Display a listing of order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Toinn
     */
    public function index()
    {
        $query = app(Order::class)->with('user')->newQuery();
        $userId = BasicHelper::getUserDetails()->id;
        if (!PermissionHelper::isSuperAdmin()) {
            $query = $query->where('user_id', $userId);
        }
        $orders = $query->get();
        return view('order::index.index', compact('orders'));
    }

    public function orderWeb(){
        $query = app(OrderWeb::class)->with('user')->newQuery();
        $userId = BasicHelper::getUserDetails()->id;
        if (!PermissionHelper::isSuperAdmin()) {
            $query = $query->where('user_id', $userId);
        }
        $orders = $query->get();
        return view('order::index.order-web', compact('orders'));
    }

    /**
     * Show form to add order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $province = DataAddress::groupBy('province')->select('province', 'id')->get();
        return view('order::create.create', compact('province'));
    }

    /**
     * Function to add a new order into the system
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $userCreate = BasicHelper::getUserDetails();
            $orders = $request->all();

            $dataExport = [];
            for ($i = 0; $i < count($orders['full_name']); $i++) {
                $order['user_id'] = $userCreate->id;
                $order['full_name'] = $orders['full_name'][$i];
                $order['phone'] = $orders['phone'][$i];
                $order['province'] = $orders['province'][$i];
                $order['district'] = $orders['district'][$i];
                $order['village'] = $orders['village'][$i];
                $order['street'] = $orders['street'][$i];
                $order['store_name'] = $orders['store_name'][$i];
                $order['product_name'] = $orders['product_name'][$i];
                $order['product_link'] = $orders['product_link'][$i];
                $order['quantity'] = $orders['quantity'][$i];
                $order['option_1'] = $orders['option_1'][$i];
                $order['option_2'] = $orders['option_2'][$i];
                $order['promo_code'] = $orders['promo_code'][$i];
                $order['transport'] = $orders['transport'][$i];
                $validator = Validator::make($order, [
                    'user_id'    => 'required',
                    'full_name'    => 'required|max:191',
                    'phone'        => 'required|max:20',
                    'province'     => 'required|max:191',
                    'district'     => 'required|max:191',
                    'village'      => 'required|max:191',
                    'street'       => 'required|max:191',
                    'store_name'   => 'required|max:191',
                    'product_name' => 'required|max:191',
                    'product_link' => 'max:191',
                    'quantity'     => 'required|integer',
                    'option_1'     => 'required|max:191',
                    'option_2'     => 'required|max:191',
                    'promo_code'   => 'max:191',
                    'transport'    => 'required|max:191',
                ], []);

                if ($validator->fails()) {
                    return redirect('manager/order/create')->with('error_message', $validator->errors()->first());
                }
                $dataExport[] = $order;
            }

            OrderWeb::insert($dataExport);

            // export excel
            $header = $this->getHeader();

            $dataExcel = [];
            foreach ($dataExport as $index => $item){
                unset($item['user_id']);
                $dataExcel[] = $item;
            }

            $dataExcel = new KeyExport([$dataExcel], $header);

            $excel = Excel::download($dataExcel, "data_order_" . Carbon::now()->format('Y-m-d-his') . ".xlsx");
            DB::commit();
            return $excel;
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect('manager/order/create')->with('error_message', $ex->getMessage());
        }
    }

    private function getHeader()
    {
        return $header = [
            'HỌ VÀ TÊN',
            'SĐT',
            'Tỉnh',
            'Huyện',
            'Xã',
            'Đường',
            'Tên Store',
            'Tên Sản Phẩm',
            'Đơn Hàng/Link sp',
            'Số Lượng',
            'Lựa Chọn 1',
            'Lựa Chọn 2',
            'Promo code',
            'Vận Chuyển'
        ];
    }

}
