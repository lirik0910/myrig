<?php

namespace App\Http\Middleware\Manager;

use Closure;
use App\Model\Base\User;
use Illuminate\Support\Facades\Auth;

class ComponentCollectionMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$allow = [];
		if (Auth::user()) {
			if (User::checkPolicy('page_collection') === true) {
				$allow[] = '/pages';
				$allow[] = '/pages/create?parent_id=16&context_id=1&link=news&view_id=10';
				$allow[] = '/pages/create?parent_id=17&context_id=1&link=info&view_id=10';
			}

			if (User::checkPolicy('user_collection') === true) {
				$allow[] = '/users';
			}

			if (User::checkPolicy('order_collection') === true) {
				$allow[] = '/orders';
			}

			if (User::checkPolicy('product_collection') === true) {
				$allow[] = '/products';
			}

			if (User::checkPolicy('rates_list') === true) {
				$allow[] = '/rates';
			}

			if (User::checkPolicy('file_list') === true && User::checkPolicy('folder_list')) {
				$allow[] = '/files';
			}
		}
		$request->merge(['allow_list' => $allow]);

		return $next($request);
	}
}
