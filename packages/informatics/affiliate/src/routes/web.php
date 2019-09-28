<?php

Route::group(['namespace' => 'Informatics\Affiliate\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function() {

    Route::group(['middleware' => 'adminCheck'], function() {

        Route::resource('affiliate', 'IndexController');

    });

});
