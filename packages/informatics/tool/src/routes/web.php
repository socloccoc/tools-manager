<?php

Route::group(['namespace' => 'Informatics\Tool\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function() {

    Route::group(['middleware' => 'adminCheck'], function() {

        Route::resource('tool', 'IndexController');

    });

});
