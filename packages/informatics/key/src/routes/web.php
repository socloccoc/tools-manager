<?php

Route::group(['namespace' => 'Informatics\Key\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function() {

    Route::group(['middleware' => 'adminAndAgencyCheck'], function() {
        Route::resource('key', 'IndexController');

        Route::group(['prefix' => 'ajax'], function () {
            Route::post('getKeyInfo', [
                'as' => 'getKeyInfo',
                'uses' => 'AjaxController@getKeyInfo'
            ]);
        });

        Route::post('updateKey', [
            'as'   => 'key.updateKey',
            'uses' => 'IndexController@updateKey'
        ]);

        Route::get('deleteKey/{id}', [
            'as'   => 'key.deleteKey',
            'uses' => 'IndexController@deleteKey'
        ]);

        Route::post('adjournKey', [
            'as'   => 'key.adjourn',
            'uses' => 'IndexController@adjournKey'
        ]);

        Route::get('changeSirial/{id}', [
            'as'   => 'key.changeSirial',
            'uses' => 'IndexController@changeSirial'
        ]);
    });

});
