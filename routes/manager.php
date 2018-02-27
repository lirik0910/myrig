<?php

use Illuminate\Http\Request;

Route::auth();
Route::get('/', 'Manager\ViewController@index')->middleware('auth');

Route::prefix('pages')
	->middleware('auth')
	->group(function () {
		Route::get('/', 'Manager\ViewController@index');
		Route::get('/{id}', 'Manager\ViewController@index');
		Route::get('/create', 'Manager\ViewController@index');
});

Route::prefix('files')
	->middleware('auth')
	->group(function () {
		Route::get('/', 'Manager\ViewController@index');
});

Route::prefix('api')
	->middleware('auth')
	->group(function() {
		Route::prefix('page')->group(function() {
			Route::get('/', 'Manager\PageController@all');
			Route::get('/tree', 'Manager\PageController@tree');
			Route::get('/{id}', 'Manager\PageController@get');
			Route::get('/childs/{id}', 'Manager\PageController@childs');
			Route::get('/except/{id}', 'Manager\PageController@except');
			Route::get('/variable/{id}', 'Manager\VariableContentController@all');
			
			Route::put('/{id}', 'Manager\PageController@update');
			Route::post('/', 'Manager\PageController@create');
			Route::delete('/{id}', 'Manager\PageController@remove');
		});

		Route::prefix('variable')->group(function() {
			Route::get('/{id}', 'Manager\VariableController@all');
		});

		Route::prefix('context')->group(function() {
			Route::get('/', 'Manager\ContextController@all');
		});

		Route::prefix('view')->group(function() {
			Route::get('/', 'Manager\ViewController@all');
		});

		Route::prefix('components')->group(function() {
			Route::get('/', 'Manager\ComponentController@all');
		});

		Route::prefix('folder')->group(function() {
			Route::get('/', 'Manager\FileManagerController@folder');
			Route::put('/', 'Manager\FileManagerController@rename');
			Route::post('/', 'Manager\FileManagerController@createFolder');
			Route::delete('/', 'Manager\FileManagerController@deleteFolder');
		});

		Route::prefix('file')->group(function() {
			Route::get('/', 'Manager\FileManagerController@file');
			Route::put('/', 'Manager\FileManagerController@rename');
			Route::post('/', 'Manager\FileManagerController@createFile');
			Route::delete('/', 'Manager\FileManagerController@deleteFile');
		});
});