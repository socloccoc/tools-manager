<?php


namespace Informatics\Key\Controllers;

use App\Http\Controllers\Controller;
use Informatics\Key\Models\Key;
use Request;

class AjaxController extends Controller
{

    public function getKeyInfo(Request $request)
    {
        if (Request::ajax()) {
            $keyId = Request::get('keyId');
            return Key::where('id', $keyId)->first();
        }
    }


}
