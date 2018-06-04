<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Base\User;
use Illuminate\Support\Facades\Auth;

class ManagerMiddleware
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
		if (Auth::user() && User::checkPolicy('login_manager') === false) {
			return redirect('/');
		}

		return $next($request);
	}
}
