<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});
Route::any('/', 'WechatController@serve');
Route::any('/wechat', 'WechatController@serve');
Route::any('/log', function (){
	$filepath = storage_path('logs/laravel.log');
	return response()-> download($filepath);
});
Route::any('/phpinfo', function (){
	return phpinfo();
});
