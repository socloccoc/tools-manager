<?php

namespace Informatics\Dashboard\Controllers;

use Illuminate\Support\Facades\Redirect;

class RegisteredUsersController
{
    public function index()
    {
        return Redirect::to('/');
    }
}