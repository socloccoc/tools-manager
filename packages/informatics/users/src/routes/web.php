<?php

Route::group(['namespace' => 'Informatics\Users\Controllers', 'prefix' => 'manager', 'middleware' => 'loggedIn'], function() {

    Route::resource('user-key', 'IndexController');

});
