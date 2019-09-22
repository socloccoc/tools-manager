<?php

Route::group(['namespace' => 'Informatics\Admin\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function() {

    Route::group(['middleware' => 'adminCheck'], function() {

        Route::resource('admin', 'IndexController');

    });

});
