<?php

namespace App\Http\Middleware;

use Closure; 
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class CheckLocale
{
	public $sngCountries = [
		'az', 'am', 'by', 'ge', 'kz', 'kg', 'ru', 'tm', 'uz'
	];


	public function defineCountry()
	{
		$locale = explode(';', file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=279a52ca7e17a0f4a96079079d564ea24be53143fa9b4e11db066f80cf8577fa&ip=' . $_SERVER['REMOTE_ADDR']))[3];
		return $locale === '-' ? 'ua' : $locale;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$method = $request->method();
        //App::setLocale('ua');
		if ($method === 'GET' || $method === 'POST') {
			$currentHost = $request->getHttpHost();
			$currentHostParts = explode('.', $currentHost);

			$clientLocation = strtolower($this->defineCountry());
			if (in_array($clientLocation, $this->sngCountries)) {
				$clientLocation = 'ru';
			}

			else if ($clientLocation !== 'ua') {
				$clientLocation = 'en';
			}

			$newLocale = $request->get('locale');
			if ($newLocale) {
				$_SESSION['locale'] = ($clientLocation = $newLocale);
			}

			else {
				$clientLocation = $_SESSION['locale'] ?? ($_SESSION['locale'] = $clientLocation);
			}

			App::setLocale($clientLocation);
			if ($currentHostParts[0] && $currentHostParts[0] !== $clientLocation) {
				return redirect(config('app.' . $clientLocation .'_domain') . '?locale=' . $clientLocation);
			}
		}

		return $next($request);
	}
}
