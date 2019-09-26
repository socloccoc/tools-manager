<?php

Route::group(['namespace' => 'Informatics\Analytics\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function() {

    Route::group(['middleware' => 'adminCheck'], function() {
        Route::resource('analytics', 'IndexController');
    });

});
