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

Route::post('/user/signup',[
	'uses' => 'UserController@signup'
]);

Route::post('/user/signin',[
	'uses' => 'UserController@signin'
]);
Route::get('/shop/getall',[
	'uses' => 'ShopController@index'
]);

Route::post('/shop',[
	'uses' => 'ShopController@store'
]);

Route::put('/shop/{id}',[
	'uses' => 'ShopController@update'
]);
Route::delete('/shop/{id}',[
	'uses' => 'ShopController@destroy'
]);
