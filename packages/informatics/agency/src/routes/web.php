<?php

Route::group(['namespace' => 'Informatics\Agency\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function() {

    Route::group(['middleware' => 'adminAndAgencyCheck'], function() {
        Route::resource('user', 'IndexController');
        Route::get('deleteUser/{id}', [
            'as'   => 'user.deleteUser',
            'uses' => 'IndexController@deleteUser'
        ]);
    });

});
