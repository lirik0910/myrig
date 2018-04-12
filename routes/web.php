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
use Illuminate\Support\Facades\Cache;


foreach (\App\Model\Base\Page::all() as $page) {
	Route::get($page->link, 'PageController@view');
}

Route::prefix('connector')
	->group(function () {
		Route::get('cart', 'SessionController@get');
		Route::post('cart', 'SessionController@add');
		Route::delete('cart', 'SessionController@delete');
});

Route::post('switch-locale', function (Request $request){
    $locale = $request->post('locale');

    if($locale){
        Cache::put('locale', $locale, 86400);
        App::setLocale($locale);
    }
    //var_dump(App::getLocale()); die;
});
Route::post('create_report', 'ReportController@create');
Route::post('rep-avail', 'ProductController@all');
Route::post('profile', 'ClientAuthController@updateClient');
Route::get('checkout/order_success/{number}', 'PageController@view');
Route::get('/shop/{id}', 'ProductController@getContent');
Route::post('/create_ticket', 'ZendeskController@createTicket');
Route::post('/calc', 'CalculateController@checkMethod');
Route::get('/calc_btn', 'CalculateController@checkMethod');
Route::get('/sso-login/{ssotoken?}', 'ClientAuthController@login');
Route::post('/checkout', 'OrderController@create');
Route::post('/back_call', function (Request $request){
	$data = $request->post();
	try{
		Zendesk::tickets()->create([
			'subject' => $data['subject'],
			'description' => 'Заказ обратного звонка',
			'name' => $data['name'],
			'tel' => $data['tel']
		]);
	} catch (\GuzzleHttp\Exception\RequestException $e){
		$requestException = RequestException::create($e->getRequest(), $e->getResponse(), $e);
		return $requestException;
	}
});