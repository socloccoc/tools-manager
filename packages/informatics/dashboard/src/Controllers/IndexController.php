<?php

namespace Informatics\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use Permission;
use App as App;

class IndexController extends Controller
{
    public function index()
    {
        return abort(405);
    }
}