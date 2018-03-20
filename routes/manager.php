<?php

use Illuminate\Http\Request;

/** Check available components and display in components menu
 */
use App\Http\Middleware\Manager\ComponentCollectionMiddleware;

/** Access policy middleware for folders of filesystem component
 */
use App\Http\Middleware\Manager\FolderListMiddleware;
use App\Http\Middleware\Manager\FolderEditMiddleware;
use App\Http\Middleware\Manager\FolderCreateMiddleware;
use App\Http\Middleware\Manager\FolderDeleteMiddleware;

/** Access policy middleware for files of filesystem component
 */
use App\Http\Middleware\Manager\FileListMiddleware;
use App\Http\Middleware\Manager\FileEditMiddleware;
use App\Http\Middleware\Manager\FileCreateMiddleware;
use App\Http\Middleware\Manager\FileDeleteMiddleware;

/** Access policy middleware for user models
 */
use App\Http\Middleware\Manager\UserCollectionMiddleware;
use App\Http\Middleware\Manager\UserOneMiddleware;
use App\Http\Middleware\Manager\UserEditMiddleware;
use App\Http\Middleware\Manager\UserDeleteMiddleware;

/** Access policy middleware for page models
 */
use App\Http\Middleware\Manager\PageCollectionMiddleware;
use App\Http\Middleware\Manager\PageOneMiddleware;
use App\Http\Middleware\Manager\PageCreateMiddleware;
use App\Http\Middleware\Manager\PageEditMiddleware;
use App\Http\Middleware\Manager\PageDeleteMiddleware;

/** Access policy middleware for products models
 */
use App\Http\Middleware\Manager\ProductCollectionMiddleware;
use App\Http\Middleware\Manager\ProductOneMiddleware;
use App\Http\Middleware\Manager\ProductCreateMiddleware;
use App\Http\Middleware\Manager\ProductEditMiddleware;
use App\Http\Middleware\Manager\ProductDeleteMiddleware;

/** Access policy middleware for order models
 */
use App\Http\Middleware\Manager\OrderCollectionMiddleware;
use App\Http\Middleware\Manager\OrderOneMiddleware;
use App\Http\Middleware\Manager\OrderCreateMiddleware;
use App\Http\Middleware\Manager\OrderEditMiddleware;
use App\Http\Middleware\Manager\OrderDeleteMiddleware;

/** Access policy middleware for delete site cache
 */
use App\Http\Middleware\Manager\CacheDeleteMiddleware;

/** Access policy middleware for site vocabularies
 */
use App\Http\Middleware\Manager\VocabularyListMiddleware;
use App\Http\Middleware\Manager\VocabularyEditMiddleware;

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

Route::prefix('vocabulary')
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

Route::prefix('rates')
	->middleware('auth')
	->group(function () {
		Route::get('/', 'Manager\Base\ViewController@index');
});

Route::prefix('api')
	->middleware('auth')
	->group(function() {
		Route::prefix('component')->group(function() {
			Route::get('/', 'Manager\Base\ComponentController@all')->middleware(ComponentCollectionMiddleware::class);
		});

		Route::prefix('folder')->group(function() {
			Route::get('/', 'Manager\Base\FolderController@get')->middleware(FolderListMiddleware::class);
			Route::put('/', 'Manager\Base\FolderController@rename')->middleware(FolderEditMiddleware::class);
			Route::post('/', 'Manager\Base\FolderController@create')->middleware(FolderCreateMiddleware::class);
			Route::delete('/', 'Manager\Base\FolderController@delete')->middleware(FolderDeleteMiddleware::class);
		});

		Route::prefix('file')->group(function() {
			Route::get('/', 'Manager\Base\FileController@get')->middleware(FileListMiddleware::class);
			Route::put('/', 'Manager\Base\FileController@rename')->middleware(FileEditMiddleware::class);
			Route::post('/', 'Manager\Base\FileController@create')->middleware(FileCreateMiddleware::class);
			Route::delete('/', 'Manager\Base\FileController@delete')->middleware(FileDeleteMiddleware::class);
		});

		Route::prefix('user')->group(function() {
			Route::get('/', 'Manager\Base\UserController@all')->middleware(UserCollectionMiddleware::class);
			Route::get('/{id}', 'Manager\Base\UserController@get')->middleware(UserOneMiddleware::class);
			Route::put('/{id}', 'Manager\Base\UserController@edit')->middleware(UserEditMiddleware::class);
			Route::delete('/', 'Manager\Base\UserController@deleteMany')->middleware(UserDeleteMiddleware::class);
			Route::delete('/{id}', 'Manager\Base\UserController@delete')->middleware(UserDeleteMiddleware::class);
		});

		Route::prefix('policy')->group(function() {
			Route::get('/', 'Manager\Base\PolicyController@all');
		});

		Route::prefix('page')->group(function() {
			Route::get('/', 'Manager\Base\PageController@all')->middleware(PageCollectionMiddleware::class);
			Route::get('/{id}', 'Manager\Base\PageController@get')->middleware(PageOneMiddleware::class);
			Route::post('/', 'Manager\Base\PageController@create')->middleware(PageCreateMiddleware::class);
			Route::put('/{id}', 'Manager\Base\PageController@update')->middleware(PageEditMiddleware::class);
			Route::delete('/{id}', 'Manager\Base\PageController@delete')->middleware(PageDeleteMiddleware::class);
		});

		Route::prefix('product')->group(function() {
			Route::get('/statuses', 'Manager\Shop\ProductStatusController@all');
			Route::get('/option/type', 'Manager\Shop\ProductOptionTypeController@all');

			Route::get('/', 'Manager\Shop\ProductController@all')->middleware(ProductCollectionMiddleware::class);
			Route::get('/{id}', 'Manager\Shop\ProductController@one')->middleware(ProductOneMiddleware::class);
			Route::post('/', 'Manager\Shop\ProductController@create')->middleware(ProductCreateMiddleware::class);
			Route::put('/{id}', 'Manager\Shop\ProductController@update')->middleware(ProductEditMiddleware::class);
			Route::delete('/', 'Manager\Shop\ProductController@deleteMany')->middleware(ProductDeleteMiddleware::class);
			Route::delete('/{id}', 'Manager\Shop\ProductController@delete')->middleware(ProductDeleteMiddleware::class);
		});

		Route::prefix('order')->group(function() {
			Route::get('/', 'Manager\Shop\OrderController@all')->middleware(OrderCollectionMiddleware::class);
			Route::get('/{id}', 'Manager\Shop\OrderController@one')->middleware(OrderOneMiddleware::class);
			Route::post('/', 'Manager\Shop\OrderController@create')->middleware(OrderCreateMiddleware::class);
			Route::put('/{id}', 'Manager\Shop\OrderController@update')->middleware(OrderEditMiddleware::class);
			Route::get('/log/{id}', 'Manager\Shop\OrderController@log');
			Route::delete('/{id}', 'Manager\Shop\OrderController@delete')->middleware(OrderDeleteMiddleware::class);
		});

		Route::prefix('rate')->group(function() {
			Route::get('/', 'Manager\Shop\ExchangeRateController@one');
			Route::put('/', 'Manager\Shop\ExchangeRateController@update');
		});

		Route::prefix('cache')->group(function() {
			Route::delete('/', 'Manager\Base\CacheController@delete')->middleware(CacheDeleteMiddleware::class);
		});

		Route::prefix('vocabulary')->group(function() {
			Route::get('/', 'Manager\Base\CacheController@all')->middleware(VocabularyListMiddleware::class);
			Route::put('/', 'Manager\Base\CacheController@update')->middleware(VocabularyEditMiddleware::class);
		});

		Route::prefix('lang')->group(function() {
			Route::get('/', 'Manager\Base\LangController@all');
			Route::get('/{id}', 'Manager\Base\LangController@one');
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

		Route::prefix('category')->group(function() {
			Route::get('/', 'Manager\Shop\CategoryController@all');
		});

		Route::prefix('currency')->group(function() {
			Route::get('/', 'Manager\Shop\CurrencyController@all');
		});

		Route::prefix('delivery')->group(function() {
			Route::get('/', 'Manager\Shop\DeliveryController@all');
		});

		Route::prefix('payment')->group(function() {
			Route::get('/', 'Manager\Shop\PaymentTypeController@all');
		});
});