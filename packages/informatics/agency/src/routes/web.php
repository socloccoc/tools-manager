<?php

Route::group(['namespace' => 'Informatics\Admin\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function() {

    Route::group(['middleware' => 'agencyCheck'], function() {

        Route::resource('user', 'IndexController');

    });

});
