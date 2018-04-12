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
        //var_dump($current_domain); die;
        if($request->method() == 'GET'){
            $current_domain = $_SERVER['HTTP_HOST'];
            $session_locale = session()->get('locale');
            //var_dump($cache); die;
            if(!$session_locale){
                $clientIp = $_SERVER['REMOTE_ADDR'];
                $locale = geoip($clientIp)->iso_code;
                if($locale != 'UA' &&  $locale != 'RU'){
                    $locale = 'en';
                } else{
                    $locale = strtolower($locale);
                }
                session()->put('locale', $locale);
                App::setLocale($locale);
            }
        }

        return $next($request);
    }
}
