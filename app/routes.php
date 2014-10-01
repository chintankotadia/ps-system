<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** before auth routes **/
Route::group(['before' => 'guest'], function() {
    Route::get('login',                     'AuthController@getLogin');
    Route::post('login',                    'AuthController@postLogin');
    Route::get('/',                         'DashboardController@getIndex');
});


/** after auth routes **/
Route::group(['before' => 'auth'], function() {
    Route::get('/',                         'DashboardController@getIndex');
    Route::get('logout',                    'AuthController@getLogout');
    Route::get('setting',                   'UserController@getSetting');
    Route::post('setting',                  'UserController@postSetting');

});


/** after admin routes **/
Route::group(['before' => 'admin'], function() {
    Route::controller('admin/user',    'UserController');
    Route::controller('admin',          'AdminController');
});