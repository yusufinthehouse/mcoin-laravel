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

Route::prefix('v1')->group(function() {
    Route::post('users', 'Api\V1\UserController@create');
    Route::get('users/{user}', 'Api\V1\UserController@get');
    Route::put('users/{user}', 'Api\V1\UserController@update');
    Route::delete('users/{user}', 'Api\V1\UserController@delete');
    
    Route::post('authenticate', 'Api\V1\UserController@login');
});

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('checktoken', 'UserController@getAuthUser');
});
