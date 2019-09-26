<?php

namespace Informatics\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use Permission;
use App as App;

class IndexController extends Controller
{
    public function index()
    {
        if (Permission::isSuperAdmin() || Permission::isSystemAdmin()) {
            return $superAdmin = App::make('Informatics\Dashboard\Controllers\SuperAdminController')->index();
        } elseif (Permission::isUser()) {
            return $registeredUser = App::make('Informatics\Dashboard\Controllers\RegisteredUsersController')->index();
        }
    }
}