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
		return json_decode(file_get_contents('https://www.iplocate.io/api/lookup/' . $_SERVER['REMOTE_ADDR']))->country_code ?? 'ua';
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
			if ($currentHostParts[0] !== $clientLocation) {
				return header('Location: ' . config('app.' . $clientLocation .'_domain'));
			}
		}

		return $next($request);
	}
}
