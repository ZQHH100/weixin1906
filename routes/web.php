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

Route::get('/', function () {
	//echo "DAADD";die;
	phpinfo();
	return view('welcome');
});

Route::prefix('/test')->group(function(){

    Route::get('/decrypt2','TestController@decrypt2');
    
    Route::get('/encrypt1','TestController@encrypt1');

	Route::get('/rsa','TestController@rsa');
});
Route::get('/rsaSign','TestController@rsaSign');
