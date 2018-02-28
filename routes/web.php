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
use Illuminate\Http\Request;



$request = new Request();
//var_dump($request->getQueryString()); die;
Route::get($request->path(), 'PageController@view');

Route::post('/back_call', function (Request $request){
    var_dump($request->post()); die;
});



