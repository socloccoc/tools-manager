<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('/checkKey', [
        'as'   => 'key.check',
        'uses' => 'KeyApiController@checkKey'
    ]);

    Route::post('/updatePointOrder', [
        'as'   => 'key.updatePointOrder',
        'uses' => 'KeyApiController@updatePointOrder'
    ]);

    Route::post('/updatePointRegister', [
        'as'   => 'key.updatePointRegister',
        'uses' => 'KeyApiController@updatePointRegister'
    ]);

    Route::get('/getPointOrder/{key}', [
        'as'   => 'key.getPointOrder',
        'uses' => 'KeyApiController@getPointOrder'
    ]);

    Route::get('/getPointRegister/{key}', [
        'as'   => 'key.getPointRegister',
        'uses' => 'KeyApiController@getPointRegister'
    ]);

    Route::post('/addPointForKey', [
        'as'   => 'key.addPointForKey',
        'uses' => 'KeyApiController@addPointForKey'
    ]);

    Route::post('/validateKey', [
        'as'   => 'key.validateKey',
        'uses' => 'KeyApiController@validateKey'
    ]);

    Route::resource('app', 'AppApiController');
    Route::resource('order', 'OrderApiController');
    Route::post('/checkOrder', [
        'as'   => 'order.checkOrder',
        'uses' => 'OrderApiController@checkOrder'
    ]);

    Route::get('/checkUser/{key}', [
        'as'   => 'key.checkUser',
        'uses' => 'KeyApiController@checkUser'
    ]);

});