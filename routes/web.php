<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [
    'middleware' => 'isLogin',
    'as' => 'login',
    'uses' => 'Informatics\Auth\Controllers\LoginController@create'
]);

Route::post('/login', [
    'as' => 'login-post',
    'uses' => 'Informatics\Auth\Controllers\LoginController@store'
]);

Route::get('/logout', [
    'as' => 'logout',
    'uses' => 'Informatics\Auth\Controllers\LoginController@logout'
]);


Route::group(['namespace' => 'App\Http\Controllers\FrontEnd'], function() {

    Route::get('/', [
        'as' => 'home',
        'uses' => 'HomeController@index'
    ]);

    Route::get('/tran/acc', [
        'middleware' => 'loggedIn',
        'as' => 'purchased.account',
        'uses' => 'HistoryController@purchasedAccount'
    ]);

    Route::get('/nap-the', [
        'middleware' => 'loggedIn',
        'as' => 'charge.card',
        'uses' => 'ChargeCardController@index'
    ]);

    Route::get('/charge-card-history', [
        'middleware' => 'loggedIn',
        'as' => 'charge.card.history',
        'uses' => 'ChargeCardHistoryController@index'
    ]);

    Route::post('/chargeCard', [
        'middleware' => 'loggedIn',
        'as' => 'charge.card.complete',
        'uses' => 'ChargeCardController@chargeCardComplete'
    ]);

    Route::get('/user/profile', [
        'middleware' => 'loggedIn',
        'as' => 'user.profile',
        'uses' => 'UserController@profile'
    ]);

    Route::get('/user/change-password', [
        'middleware' => 'loggedIn',
        'as' => 'change.password',
        'uses' => 'UserController@changePassword'
    ]);

    Route::post('/user/change-password-complete', [
        'middleware' => 'loggedIn',
        'as' => 'change.password.complete',
        'uses' => 'UserController@changePasswordComplete'
    ]);

//    Route::post('/user/buyacc', [
//        'middleware' => 'loggedIn',
//        'as' => 'buyacc',
//        'uses' => 'UserController@buyacc'
//    ]);
//
//    Route::group(['prefix' => 'ajax'], function () {
//        Route::post('getAccountInfo', [
//            'as' => 'getAccountInfo',
//            'uses' => 'AjaxController@getAccountInfo'
//        ]);
//    });

    Route::get('{slug}', 'HomeController@index')->where('slug', '^(?!.*manager).*$');

});
