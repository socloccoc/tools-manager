<?php
namespace Informatics\Dashboard\Controllers;

use App\Http\Controllers\Controller;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('dashboard::index.index');
    }
}