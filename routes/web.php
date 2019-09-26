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

Route::get('/change-password', [
    'as' => 'change.password.view',
    'uses' => 'Informatics\Auth\Controllers\LoginController@changePasswordView'
]);

Route::post('/change-password', [
    'as' => 'change.password.complete',
    'uses' => 'Informatics\Auth\Controllers\LoginController@changePasswordComplete'
]);

Route::group(['namespace' => 'App\Http\Controllers'], function() {
    Route::match(['get', 'post'], '/', function(){
        return redirect('/login');
    });
});
//Route::get('/{any}', function ($any) {
//
//    return redirect('/login');
//
//})->where('all', '(.*)');
//\Illuminate\Support\Facades\App::missing(function($exception)
//{
//    return redirect('/login');
//});
//Route::any('{all?}', 'App\Http\Controllers\HomeController@index')->where('all', '(.*)');
//Route::any('{!all}', function(){
//    return abort(405);
//})->where('all', '.*');