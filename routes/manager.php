<?php

use Illuminate\Http\Request;

Route::auth();
Route::get('/', 'Manager\Base\ViewController@index')->middleware('auth');

Route::prefix('pages')
	->middleware('auth')
	->group(function () {
		Route::get('/', 'Manager\Base\ViewController@index');
		Route::get('/{id}', 'Manager\Base\ViewController@index');
		Route::get('/create', 'Manager\Base\ViewController@index');
});

Route::prefix('files')
	->middleware('auth')
	->group(function () {
		Route::get('/', 'Manager\Base\ViewController@index');
});

Route::prefix('users')
	->middleware('auth')
	->group(function () {
		Route::get('/', 'Manager\Base\ViewController@index');
});

Route::prefix('orders')
	->middleware('auth')
	->group(function () {
		Route::get('/', 'Manager\Base\ViewController@index');
});

Route::prefix('products')
	->middleware('auth')
	->group(function () {
		Route::get('/', 'Manager\Base\ViewController@index');
		Route::get('/{id}', 'Manager\Base\ViewController@index');
		Route::get('/create', 'Manager\Base\ViewController@index');
});

Route::prefix('api')
	->middleware('auth')
	->group(function() {
		Route::prefix('component')->group(function() {
			Route::get('/', 'Manager\Base\ComponentController@all');
		});

		Route::prefix('folder')->group(function() {
			Route::get('/', 'Manager\Base\FolderController@get');
			Route::put('/', 'Manager\Base\FolderController@rename');
			Route::post('/', 'Manager\Base\FolderController@create');
			Route::delete('/', 'Manager\Base\FolderController@delete');
		});

		Route::prefix('file')->group(function() {
			Route::get('/', 'Manager\Base\FileController@get');
			Route::put('/', 'Manager\Base\FileController@rename');
			Route::post('/', 'Manager\Base\FileController@create');
			Route::delete('/', 'Manager\Base\FileController@delete');
		});

		Route::prefix('user')->group(function() {
			Route::get('/', 'Manager\Base\UserController@all');
			Route::get('/{id}', 'Manager\Base\UserController@get');
			Route::put('/{id}', 'Manager\Base\UserController@edit');
			Route::delete('/', 'Manager\Base\UserController@deleteMany');
			Route::delete('/{id}', 'Manager\Base\UserController@delete');
		});

		Route::prefix('policy')->group(function() {
			Route::get('/', 'Manager\Base\PolicyController@all');
		});

		Route::prefix('page')->group(function() {
			Route::get('/', 'Manager\Base\PageController@all');
			Route::get('/{id}', 'Manager\Base\PageController@get');
			Route::post('/', 'Manager\Base\PageController@create');
			Route::put('/{id}', 'Manager\Base\PageController@update');
			Route::delete('/{id}', 'Manager\Base\PageController@delete');
		});

		Route::prefix('product')->group(function() {
			Route::get('/', 'Manager\Shop\ProductController@all');
			Route::get('/{id}', 'Manager\Shop\ProductController@one');
			Route::post('/', 'Manager\Shop\ProductController@create');
			Route::put('/{id}', 'Manager\Shop\ProductController@update');
			Route::delete('/', 'Manager\Shop\ProductController@deleteMany');
			Route::delete('/{id}', 'Manager\Shop\ProductController@delete');
		});

		Route::prefix('context')->group(function() {
			Route::get('/', 'Manager\Base\ContextController@all');
		});

		Route::prefix('view')->group(function() {
			Route::get('/', 'Manager\Base\ViewController@all');
		});

		Route::prefix('status')->group(function() {
			Route::get('/', 'Manager\Shop\OrderStatusController@all');
		});

		Route::prefix('delivery')->group(function() {
			Route::get('/', 'Manager\Shop\DeliveryController@all');
		});

		Route::prefix('payment')->group(function() {
			Route::get('/', 'Manager\Shop\PaymentTypeController@all');
		});

		Route::prefix('order')->group(function() {
			Route::get('/', 'Manager\Shop\OrderController@all');
			Route::get('/{id}', 'Manager\Shop\OrderController@one');
			Route::post('/', 'Manager\Shop\OrderController@create');
			Route::put('/{id}', 'Manager\Shop\OrderController@update');
			Route::get('/log/{id}', 'Manager\Shop\OrderController@log');
			Route::delete('/{id}', 'Manager\Shop\OrderController@delete');
		});
});