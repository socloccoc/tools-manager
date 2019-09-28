<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Informatics\Affiliate\Models\Affiliate;
use Informatics\Key\Models\Key;
use Informatics\Tool\Models\Tool;
use Informatics\Users\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use File;

class KeyApiController extends BaseApiController
{
    public function checkKey(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key'           => 'required|max:9',
            'serial_number' => 'required',
            'app_name'      => 'required',
        ], [
            'key.required'           => 'Key không được để trống',
            'key.max'                => 'Key không được quá 9 ký tự',
            'serial_number.required' => 'Serial Number không được để trống',
            'app_name.required'      => 'App Name không được để trống',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), Response::HTTP_BAD_REQUEST);
        }

        $key = $request->key;

        $keyExist = Key::where('licence_key', $key)->first();

        if (!$keyExist) {
            return $this->sendError('Key không hợp lệ !', Response::HTTP_BAD_REQUEST);
        }

        // check app_name
        $toolName = $request->app_name;
        $tool = Tool::where('name', $toolName)->first();
        if (!$tool) {
            return $this->sendError('App không tồn tại !', Response::HTTP_NOT_FOUND);
        }

        $toolId = $tool->id;

        if ($keyExist->serial_number == '') {
            if ($keyExist->expire_date == '') {
                $data = [
                    'serial_number' => $request->serial_number,
                    'expire_date'   => Carbon::now()->addMonths($keyExist->expire_time)->format('y-m-d H:i:s')
                ];
            } else {
                $data = [
                    'serial_number' => $request->serial_number
                ];
            }
            try {
                $updateKey = Key::where('id', $keyExist->id)->where('tool_id', $toolId)->limit(1)->update($data);
                if ($updateKey) {
                    return $this->sendResponse(true, Response::HTTP_OK);
                }
                return $this->sendError('Key hoặc App Không hợp lệ !', Response::HTTP_BAD_REQUEST);
            } catch (\Exception $ex) {
                return $this->sendError($ex->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        } else {
            $keyRegisted = Key::where('licence_key', $key)->where('serial_number', $request->serial_number)->where('tool_id', $toolId)->first();
            if ($keyRegisted) {
                $curentTime = Carbon::now()->format('Y-m-d H:i:s');
                if ($curentTime > $keyRegisted->expire_date) {
                    return $this->sendError('Key đã hết hạn !', Response::HTTP_BAD_REQUEST);
                }
                return $this->sendResponse(true, Response::HTTP_OK);
            }
            return $this->sendError('Key hoặc serial_number hoặc App không hợp lệ !', Response::HTTP_BAD_REQUEST);
        }

    }

    public function getPointOrder($key)
    {
        $keyExpired = $this->checkKeyExpired($key);
        if($keyExpired){
            return $this->sendError('Key đã hết hạn !', Response::HTTP_BAD_REQUEST);
        }
        $key = Key::where('licence_key', $key)->first();
        if ($key) {
            return response()->json(['point' => $key->point_order], Response::HTTP_OK);
        }
        return $this->sendError('Key không hợp lệ !', Response::HTTP_BAD_REQUEST);
    }

    public function getPointRegister($key)
    {
        $keyExpired = $this->checkKeyExpired($key);
        if($keyExpired){
            return $this->sendError('Key đã hết hạn !', Response::HTTP_BAD_REQUEST);
        }
        $key = Key::where('licence_key', $key)->first();
        if ($key) {
            return response()->json(['point' => $key->point_register], Response::HTTP_OK);
        }
        return $this->sendError('Key không hợp lệ !', Response::HTTP_BAD_REQUEST);
    }

    public function updatePointOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|max:9',
        ], [
            'key.required' => 'Key không được để trống',
            'key.max'      => 'Key không được quá 9 ký tự',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), Response::HTTP_BAD_REQUEST);
        }

        $key = $request->key;

        $keyExist = Key::where('licence_key', $key)->first();

        if (!$keyExist) {
            return $this->sendError('Key không hợp lệ !', Response::HTTP_BAD_REQUEST);
        }

        try {
            $newPoint = $keyExist->point_order > 0 ? $keyExist->point_order - 1 : 0;
            $updatePoint = Key::where('id', $keyExist->id)->limit(1)->update(['point_order' => $newPoint]);
            if ($updatePoint) {
                return $this->sendResponse(true, Response::HTTP_OK);
            }
            return $this->sendError('Key Không hợp lệ !', Response::HTTP_BAD_REQUEST);
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

    public function updatePointRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|max:9',
        ], [
            'key.required' => 'Key không được để trống',
            'key.max'      => 'Key không được quá 9 ký tự',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), Response::HTTP_BAD_REQUEST);
        }

        $key = $request->key;

        $keyExist = Key::where('licence_key', $key)->first();

        if (!$keyExist) {
            return $this->sendError('Key không hợp lệ !', Response::HTTP_BAD_REQUEST);
        }

        try {
            $newPoint = $keyExist->point_register > 0 ? $keyExist->point_register - 1 : 0;
            $updatePoint = Key::where('id', $keyExist->id)->limit(1)->update(['point_register' => $newPoint]);
            if ($updatePoint) {
                return $this->sendResponse(true, Response::HTTP_OK);
            }
            return $this->sendError('Key Không hợp lệ !', Response::HTTP_BAD_REQUEST);
        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }

    public function checkUser($key){
        $keyExpired = $this->checkKeyExpired($key);
        if($keyExpired){
            return $this->sendError('Key đã hết hạn !', Response::HTTP_BAD_REQUEST);
        }
        $key = Key::where('licence_key', $key)->first();
        if ($key) {
            $user = User::where('id', $key->user_id)->first();
            if(!$user){
                return $this->sendError('Người dùng không tồn tại !', Response::HTTP_BAD_REQUEST);
            }
            if($user->type == 1){
                return $this->sendResponse($user);
            }else{
                $linkAffiliate = Affiliate::all()->random(1)->first();
                return response()->json(['success' => false, 'link' => $linkAffiliate['url']], Response::HTTP_OK);
            }
        }
        return $this->sendError('Key không hợp lệ !', Response::HTTP_BAD_REQUEST);
    }

    protected function checkKeyExist($key, $registered = false)
    {
        $key = AppDetail::where('key', $key)
            ->where(function ($query) use ($registered) {
                if ($registered) {
                    $query->where('serial_number', '!=', '');
                }
            })
            ->first();
        if ($key) {
            return true;
        }
        return false;
    }

    /**
     * check key expired
     * @param $key
     * @return bool
     */
    public function checkKeyExpired($key)
    {
        try {
            $app = Key::where('licence_key', $key)->where('expire_date', '<', Carbon::now()->format('Y-m-d H:i:s'))->first();
            if ($app) {
                return true;
            }
            return false;
        } catch (\Exception $ex) {
            return false;
        }
    }

}