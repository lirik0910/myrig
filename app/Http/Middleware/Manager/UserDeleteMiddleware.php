<?php

namespace App\Http\Middleware\Manager;

use Closure;
use App\Model\Base\User;
use Illuminate\Support\Facades\Auth;

class UserDeleteMiddleware
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
		if (Auth::user() && User::checkPolicy('user_delete') === false) {
			return response()->json(['message' => 'Access denied'], 403);
		}

		return $next($request);
	}
}
