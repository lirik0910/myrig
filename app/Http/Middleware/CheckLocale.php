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
        //var_dump($request); die;
        if($request->method() == 'GET' || $request->method() == 'POST'){
            $current_domain = $request->getSchemeAndHttpHost();

            $clientIp = $_SERVER['REMOTE_ADDR'];
            $locale = strtolower(geoip($clientIp)->iso_code);
            if($locale !== 'ua' && $locale !== 'ru'){
                $locale = 'en';
            }
            //App::setLocale($locale);

            if($request->get('locale')){
                session()->put('locale', $request->get('locale'));
                $locale = session()->get('locale');
            }
            //var_dump(session()->get('locale'));// die;
/*            if(!session()->get('locale')){
                session()->put('locale', $locale);
            }*/
            $uaDomain = config('app.ua_domain');
            $ruDomain = config('app.ru_domain');
            $enDomain = config('app.en_domain');
            //var_dump($uaDomain, $ruDomain, $enDomain); die;

            if($locale == 'ua' && $current_domain !== $uaDomain || $locale == 'ru' && $current_domain !== $ruDomain || $locale =='en' && $current_domain !== $enDomain){

/*                if(session()->get('locale')){
                  //  var_dump('Evil!!'); die;
                    App::setLocale(session()->get('locale'));
                    switch (session()->get('locale')){
                        case 'ua':
                            return redirect(config('app.ua_domain'));
                            break;
                        case 'ru':
                            return redirect(config('app.ru_domain'));
                            break;
                        case 'en':
                            return redirect(config('app.en_domain'));
                            break;
                    }
                } else{*/
                    switch ($locale){
                        case 'ua':
                            return redirect(config('app.ua_domain'));
                            break;
                        case 'ru':
                            return redirect(config('app.ru_domain'));
                            break;
                        case 'en':
                            return redirect(config('app.en_domain'));
                            break;
                    }
  //              }
            }

/*            switch ($current_domain) {
                case config('app.ua_domain'):
                   // $locale = 'ua';
                    App::setLocale('ua');
                    break;

                case config('app.ru_domain'):
                    App::setLocale('ru');
                    //$locale = 'ru';
                    break;

                case config('app.en_domain'):
                    //$locale = 'en';
                    App::setLocale('en');
                    break;

                default:
                    break;
            }*/
        }
        //var_dump($locale); die;
        return $next($request);
    }
}
