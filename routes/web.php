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
    return view('index');
});

Route::get('/news', function (){
    return view('news');
});

Route::get('/shop', function (){
    return view('shop');
});

Route::get('/service', function (){
    return view('service');
});

Route::get('/contacts', function (){
    return view('contacts');
});

Route::get('/cart', function (){
    return view('cart');
});
