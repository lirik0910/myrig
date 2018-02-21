<?php

use Illuminate\Http\Request;

/*Auth::routes();
Route::group(['prefix' => 'manager', 'middleware' => ['web', 'auth']], function () {
	Route::get('/', 'Manager\DashboardController@index');
});*/

Route::get('/', function () {
	return 'hello';
});