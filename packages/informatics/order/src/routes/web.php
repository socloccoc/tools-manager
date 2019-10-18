<?php

Route::group(['namespace' => 'Informatics\Order\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function () {

    Route::resource('order', 'IndexController');

    Route::get('/order', [
        'as'   => 'order.list.api',
        'uses' => 'IndexController@index'
    ]);

    Route::get('/order-web', [
        'as'   => 'order.list.web',
        'uses' => 'IndexController@orderWeb'
    ]);



});

Route::group(['namespace' => 'Informatics\Order\Controllers', 'prefix' => 'order'], function () {
    Route::group(['prefix' => 'ajax'], function () {
        Route::get('getDistrictByProvince', [
            'as'   => 'getDistrictByProvince',
            'uses' => 'AjaxController@getDistrictByProvince'
        ]);
        Route::get('getVillageByDistrict', [
            'as'   => 'getVillageByDistrict',
            'uses' => 'AjaxController@getVillageByDistrict'
        ]);
        Route::get('getSessionByDate', [
            'as'   => 'getSessionByDate',
            'uses' => 'AjaxController@getSessionByDate'
        ]);
    });
});