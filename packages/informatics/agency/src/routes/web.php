<?php

Route::group(['namespace' => 'Informatics\Agency\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function() {

    Route::group(['middleware' => 'agencyCheck'], function() {
        Route::resource('user', 'IndexController');
    });

});
