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
        //var_dump('dvsdvsd'); die;
        if($request->method() == 'GET'){
            $current_domain = $_SERVER['HTTP_HOST'];

            $clientIp = $_SERVER['REMOTE_ADDR'];
            $locale = strtolower(geoip($clientIp)->iso_code);
            if($locale !== 'ua' && $locale !== 'ru'){
                $locale = 'en';
            }

            if($request->get('locale')){
                session()->put('locale', $request->get('locale'));
            }
            //var_dump($locale, $current_domain); die;
            if($locale == 'ua' && $current_domain !== env('UA_DOMAIN') || $locale == 'ru' && $current_domain !== env('RU_DOMAIN') || $locale =='en' && $current_domain !== env('EN_DOMAIN')){
                //var_dump($locale, $current_domain); die;
                if(session()->get('locale')){
                    switch (session()->get('locale')){
                        case 'ua':
                            App::setLocale('ua');
                            return redirect(env('UA_DOMAIN'));
                            break;
                        case 'ru':
                            App::setLocale('ru');
                            return redirect(env('RU_DOMAIN'));
                            break;
                        case 'en':
                            App::setLocale('en');
                            return redirect(env('EN_DOMAIN'));
                            break;
                    }
                } else{
                    App::setLocale($locale);
                }
            } else{
                App::setLocale($locale);
            }
        }

        return $next($request);
    }
}
