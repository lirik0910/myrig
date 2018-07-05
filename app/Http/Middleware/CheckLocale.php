<?php

namespace App\Http\Middleware;

use Closure; 
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
class CheckLocale
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
        $method = $request->method();
        if ($method === 'GET' || $method === 'POST') {
            $currentHost = $request->getHttpHost();
            $currentHostParts = explode('.', $currentHost);

            App::setLocale($currentHostParts[0]);

            geoip($_SERVER['REMOTE_ADDR'])->iso_code;
        }

//         if($request->method() == 'GET' || $request->method() == 'POST'){
//             $current_domain = $request->getSchemeAndHttpHost();

//             $clientIp = $_SERVER['REMOTE_ADDR'];
//             $locale = strtolower(geoip($clientIp)->iso_code);
// /*            if($locale !== 'ua' && $locale !== 'ru'){
//                 $locale = 'en';
//             }*/
//             $sngCountries = [
//                 'az', 'am', 'by', 'ge', 'kz', 'kg', 'ru', 'tm', 'uz'
//             ];

//             if(in_array($locale, $sngCountries)){
//                 $locale = 'ru';
//             } elseif ($locale !== 'ua' && !in_array($locale, $sngCountries)){
//                 $locale = 'en';
//             }

//             if($request->get('locale')){
//                 session()->put('locale', $request->get('locale'));
//             }

//             if(session()->get('locale')){
//                 $locale = session()->get('locale');
//             }

//             App::setLocale($locale);

//             $uaDomain = config('app.ua_domain');
//             $ruDomain = config('app.ru_domain');
//             $enDomain = config('app.en_domain');

//             if($locale == 'ua' && $current_domain !== $uaDomain || $locale == 'ru' && $current_domain !== $ruDomain || $locale =='en' && $current_domain !== $enDomain){
//                 switch ($locale){
//                     case 'ua':
//                         return redirect(config('app.ua_domain'));
//                         break;
//                     case 'ru':
//                         return redirect(config('app.ru_domain'));
//                         break;
//                     case 'en':
//                         return redirect(config('app.en_domain'));
//                         break;
//                 }
//             }
//         }

        return $next($request);
    }
}
