<?php

Route::group(['namespace' => 'Informatics\Order\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function() {


        Route::get('/order', [
            'as'   => 'order.list',
            'uses' => 'IndexController@index'
        ]);

});
