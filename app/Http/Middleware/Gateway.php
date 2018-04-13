<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Gateway
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
		if ($request->method() == 'GET') {
			$locale = strtolower(geoip($_SERVER['REMOTE_ADDR'])->iso_code);

			/** Url контекста относительно текущей локали
			 */
			$needUrl = env(strtoupper($locale) . '_DOMAIN');

			/** Получить запрашиваемый url
			 */ 
			$currentUrl = $request->getSchemeAndHttpHost();

			/** Если запрашиваемый url отличается от необходимого
			 */
			if ($needUrl != $currentUrl) {
				//session(['locale' => 'ru']);
				print_R(session('locale'));
				/** Если запрос осуществляется с параметром locale
				 */
				if ($request->get('locale') || session('locale')) {
					//session()->forget('locale');
					//session(['locale' => 'ru']);
					//App::setLocale($request->get('locale'));
					return $next($request);
				}

				/** Если нет, тогда перекинуть на нужный url 
				 */
				else return redirect($needUrl);
			}
		}

		return $next($request);
	}
}
