<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Informatics\Base\Models\Order;
use Informatics\Key\Models\Key;
use Informatics\Tool\Models\Tool;
use Informatics\Users\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use File;

class OrderApiController extends BaseApiController
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'licence_key'    => 'required|max:9',
                'product_name'   => 'required|max:100',
                'shop_name'      => 'required|max:100',
                'product_number' => 'required|min:0',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), Response::HTTP_BAD_REQUEST);
            }

            $key = Key::where('licence_key', $request->licence_key)->first();
            if (!$key) {
                return $this->sendError('Licence not found !', Response::HTTP_BAD_REQUEST);
            }

            $user = User::where('id', $key['user_id'])->first();

            $order = [
                'licence_key'    => $request->licence_key,
                'product_name'   => $request->product_name,
                'shop_name'      => $request->shop_name,
                'product_number' => $request->product_number,
            ];
            $order['buyer_name'] = $user['name'];

            $order = Order::create($order);
            if ($order) {
                return $this->sendResponse(true, Response::HTTP_OK);
            }

            return $this->sendError('Order thất bại !', Response::HTTP_BAD_REQUEST);
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function checkOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'licence_key' => 'required|max:9',
                'buyer_name'  => 'required|max:100',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), Response::HTTP_BAD_REQUEST);
            }
            $order = Order::where('licence_key', $request->licence_key)->where('buyer_name', $request->buyer_name)->first();
            if ($order) {
                return $this->sendResponse(true, Response::HTTP_OK);
            }

            return $this->sendError('Không tìm thấy order !', Response::HTTP_BAD_REQUEST);
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}