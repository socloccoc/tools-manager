<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use View;
use Sentinel;
use Helper;

class BaseController extends Controller
{

    //Setting Default Values
    public function __construct()
    {
        $this->setUpDefault();
    }

    public function setUpDefault()
    {
        if (Sentinel::check()) {
            $currentUser = Helper::getUserDetails();
            View::share('currentUser', $currentUser);
        }
    }

}