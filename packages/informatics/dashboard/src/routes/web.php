<?php

Route::group(['namespace' => 'Informatics\Dashboard\Controllers', 'prefix' => 'user', 'middleware' => 'loggedIn'], function () {

    Route::get('/', [
        'as' => 'admin.dashboard',
        'uses' => 'IndexController@index'
    ]);

});