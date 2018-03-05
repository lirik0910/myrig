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

foreach (\App\Model\Base\Page::all() as $page) {
	Route::get($page->link, 'PageController@view');
}

/*Route::get('/shop/{id}', 'ProductController@getContent');
Route::post('/create_ticket', 'ZendeskController@createTicket');
Route::post('/calc', 'CalculateController@checkMethod');

Route::post('/back_call', function (Request $request){
	var_dump($request->post()); die;
});*/