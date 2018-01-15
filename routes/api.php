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

Route::post('/shop',[
	'uses' => 'ShopController@store'
]);

Route::put('/shop/{id}',[
	'uses' => 'ShopController@update'
]);
Route::delete('/shop/{id}',[
	'uses' => 'ShopController@destroy'
]);

Route::middleware(['jwt.auth'])->group(function () {
	Route::get('/shop/getall',[
		'uses' => 'ShopController@index'
	]);
	Route::get('/shop/getpreffered',[
		'uses' => 'ShopController@getPreffered'
	]);
	Route::get('isloggedin', function(){
      return response()->json(array('res' => true,'message'=>'you are logged in!'));
  });

	Route::get('logout',[
    'uses' => 'UserController@logout'
  ]);

	Route::get('/shop/like/{id}',[
		'uses' => 'ShopController@like'
	]);

	Route::get('/shop/dislike/{id}',[
		'uses' => 'ShopController@dislike'
	]);
});
