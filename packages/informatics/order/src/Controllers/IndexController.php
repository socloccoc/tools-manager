<?php

namespace Informatics\Order\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Informatics\Order\Models\Order;
use Input;
use Helper;
use Permission;
use Log;
use Redirect;

class IndexController extends Controller
{

    /**
     *  Display a listing of order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Toinn
     */
    public function index()
    {
        $query = app(Order::class)->newQuery();
        $orders = $query->get();
        return view('order::index.index', compact('orders'));
    }

}
