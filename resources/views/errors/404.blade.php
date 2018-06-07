{{-- @extends('layouts.app')

@section('content')
    <h1>Ошибка 404</h1>
@endsection --}}
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta lang="{{ app()->getLocale() }}" />

<title>{{ htmlentities('404') }}</title>
<meta name="description" content="{{ htmlentities('Page error') }}" />
<base href="{{ asset('/') }}" />

<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="format-detection" content="telephone=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="google-site-verification" content="YroKW8N1nmTvNHctf_WMuPtVYhPqE4bklPM-o6buvrc" />
<style>@font-face{font-family:Roboto;src:url(/fonts/RobotoRegular.ttf?290793a328775e85f880f7da86503cd2) format("truetype");src:url(/fonts/RobotoRegular.eot?eee713d6454874d4d1d8babd8dd562cf),url(/fonts/RobotoRegular.eot?eee713d6454874d4d1d8babd8dd562cf) format("embedded-opentype"),url(/fonts/RobotoRegular.woff?18b2429ba6e7179daeec5438639ab65f) format("woff");font-weight:400;font-style:normal}@font-face{font-family:Roboto;src:url(/fonts/RobotoBold.eot?cbb753be961007a7e782f57f7eacbc94);src:url(/fonts/RobotoBold.eot?cbb753be961007a7e782f57f7eacbc94) format("embedded-opentype"),url(/fonts/RobotoBold.woff?af01b5037ff63cf05210745f4c248269) format("woff"),url(/fonts/RobotoBold.ttf?b2c24342409e47baaeb690d76cbd7df3) format("truetype");font-weight:700;font-style:normal}@font-face{font-family:Roboto;src:url(/fonts/RobotoMedium.eot?6646320247af520dbd6fd3e9c0192f65);src:url(/fonts/RobotoMedium.eot?6646320247af520dbd6fd3e9c0192f65) format("embedded-opentype"),url(/fonts/RobotoMedium.woff?5ca830617cdc06dbc5e2d46878bba8b1) format("woff"),url(/fonts/RobotoMedium.ttf?9f69ecf8a3c39b994ebd5bed7d284f58) format("truetype");font-weight:600;font-style:normal}@font-face{font-family:Roboto;src:url(/fonts/RobotoLight.eot?fd160a7ab05613cd3a733e0046995d92);src:url(/fonts/RobotoLight.eot?fd160a7ab05613cd3a733e0046995d92) format("embedded-opentype"),url(/fonts/RobotoLight.woff?1d638d89cf0cf96babe6efef7fc4d388) format("woff"),url(/fonts/RobotoLight.ttf?e025164d56e8e3c156d41d989b3cdf1b) format("truetype");font-weight:300;font-style:normal}body,html{margin:0;padding:0;width:100%;height:auto;font-size:16px;overflow-x:hidden;font-family:Roboto,sans-serif!important}button,button:focus,input,input:focus,input[type=submit],select,select:focus,textarea,textarea:focus{resize:none!important;border:none;outline:none!important}input.input__border{border:1px solid #60a645}button,label{cursor:pointer!important}a.default__link{color:#60a645;text-decoration:none}a.default__link:hover,a:hover{color:#000;text-decoration:underline}.d-block-991,.d-inline-block-991{display:none}@media (max-width:991px){.d-block-991{display:block}.d-inline-block-991{display:inline-block}}.root__container{overflow:hidden}@media (max-width:767px){.default__container{width:100%!important}}@media (min-width:768px){.default__container{width:728px!important;max-width:728px!important}}@media (min-width:992px){.default__container{width:960px!important;max-width:960px!important}}@media (min-width:1250px){.default__container{width:1220px!important;max-width:1220px!important}}.margin__collapse{margin:0!important}.padding__collapse{padding:0!important}.list__container{list-style:none!important}.field__grey,.field__grey:focus,.field__input,.field__input:focus{padding:0;width:100%;height:40px;line-height:1.2;margin:0 0 15px;border-bottom:1px solid #60a645}.field__grey,.field__grey:focus{border-bottom:1px solid #c5c5c5}.dark__container{top:0;right:0;z-index:-1;width:100%;height:100%;position:fixed;background-color:#f2f2f2}</style>
	</head>

	<body>
@php
$locale = App::getLocale();

		$contexts = App\Model\Base\Context::all();
		$locale_context_id = 1;

		foreach ($contexts as $context){
		    if(trim(strtolower($context->title)) == $locale){
                $locale_context_id = $context->id;
            }
        }
try {
		$all = App\Model\Base\Setting::where('context_id', $locale_context_id)->get();
		}
		catch (\Exception $e) {
			logger($e->getMessage());

			return [];
		}

		$a = [];
		foreach ($all as $item) {
			$a[$item->title] = $item->value;
		}
$products = App\Model\Base\Page::find($a['site.products_page']);
$service =  App\Model\Base\Page::find($a['site.service_page']);
$news =  App\Model\Base\Page::find($a['site.news_page']);
$contacts = App\Model\Base\Page::find($a['site.contacts_page']);

$cart = App\Model\Base\Page::select()
	->where('view_id', 8)
	->first();

// $count = 0;
// foreach ($inCart as $i) {
// 	$count += (int) $i;
// }
if(isset($_SESSION['client'])){
	$client_email = $_SESSION['client'];
}
// $client_email = $_SESSION['client'];
if(isset($client_email) && !empty($client_email)){
	$user = App\Model\Base\User::select()->where('email', $client_email)->first();

	if($user){
	// var_dump($user->attributes); die;
		$client_name = $user->attributes->fname;
	}
}

@endphp
		<div id="root__container" class="root__container">

<div id="loading__container" style="position: fixed; width: 100%; height: 100%; top: 0; left: 0; background-color: #FFF; z-index: 3200"></div>

<div id="mobile-header__container" class="mobile-header__container">
	<nav class="navigation__container" role="navigation">
		<ul class="list__container padding__collapse margin__collapse">
			@if ($products)
			<li class="list__item text-uppercase font-weight-light">
				<a href="{{ asset($products->link) }}">{{ $products->title }}</a>
			</li>
			@endif

			<li class="list__item text-uppercase font-weight-light">
				<a href="https://host.myrig.com/">{{ __('default.hosting_title') }}</a>
			</li>

			@if ($service)
			<li class="list__item text-uppercase font-weight-light">
				<a href="{{ asset($service->link) }}">{{ $service->title }}</a>
			</li>
			@endif

			@if ($news)
			<li class="list__item text-uppercase font-weight-light">
				<a href="{{ asset($news->link) }}">{{ $news->title }}</a>
			</li>
			@endif

			@if ($contacts)
			<li class="list__item text-uppercase font-weight-light">
				<a href="{{ asset($contacts->link) }}">{{ $contacts->title }}</a>
			</li>
			@endif
		</ul>
	</nav>
</div>
@php
 function preview($name = '', $width = 50, $height = 50) {

			$fileInfo = pathinfo($name);
			/** If standart image extension
			 */
			if(isset($fileInfo['extension']) and !empty($fileInfo)){
				if ($fileInfo['extension'] !== 'jpg' && $fileInfo['extension'] !== 'jpeg' && $fileInfo['extension'] !== 'png') {
					return $name;
			}
		}

			/** Cached folder
			 */
			$storageDir = 'optimized/'. $width .'x'. $height;
			
			/** Optimazid file name
			 */
			if(isset($fileInfo['extension']))
			$fileName = md5($name) .'-'. md5($width) .'-'. md5($height) .'.'. $fileInfo['extension'];

			/** Check if current image already exists
			 */
			if(isset($fileName)){
				if (file_exists(public_path('storage/'. $storageDir .'/'. $fileName))) {
				return asset('storage/'. $storageDir .'/'. $fileName);
			}
		}

			/** Try to create folder for current size
			 */
			try {
				Illuminate\Support\Facades\Storage::disk('public')->makeDirectory($storageDir);
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return $name;
			}

			/** Create instance of new file
			 */
			if(isset($name) and !empty($name)){
			$image = Intervention\Image\Facades\Image::make(public_path() .'/'. str_replace(asset('/'), '', $name));
			$image->fit($width, $height);

			/** Try render and save new file
			 */
			try {
				$image->save(storage_path('app/public/'. $storageDir .'/') . $fileName, 60);
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return $name;
			}

			return asset('storage/'. $storageDir .'/'. $fileName);
			}
		};
@endphp

<header class="header__container default__container">
	<div class="row__container row margin__collapse">
		<div class="logo__container col-md-2 padding__collapse">
			<a class="link__item" href="{{ asset('/') }}">
				<img src="{{ preview(asset('uploads/design/logo.png'), 162, 35) }}" alt="{{ env('APP_NAME') }}" style="width: 162px"/>
			</a>
		</div>

		<nav class="navigation__container col-md-8">
			<ul class="list__container row margin__collapse padding__collapse">
				@if ($products)
				<li class="list__item">
					<a class="link__item" href="{{ asset($products->link) }}">{{ $products->title }}</a>
				</li>
				@endif

				<li class="list__item">
					<a class="link__item" href="https://host.myrig.com/">{{ __('default.hosting_title') }}</a>
				</li>
				<li id="dark-border__item"></li>

				@if ($service)
				<li class="list__item">
					<a class="link__item" href="{{ asset($service->link) }}">{{ $service->title }}</a>
				</li>
				@endif

				@if ($news)
				<li class="list__item">
					<a class="link__item" href="{{ asset($news->link) }}">{{ $news->title }}</a>
				</li>
				@endif

				@if ($contacts)
				<li class="list__item">
					<a class="link__item" href="{{ asset($contacts->link) }}">{{ $contacts->title }}</a>
				</li>
				@endif
			</ul>
		</nav>

		<div class="tools__container col-md-2 margin__collapse padding__collapse">
			<ul class="list__container row margin__collapse padding__collapse">
				<li class="list__item toggle-button__container">
					<button id="navigation-toggle__button" class="toggle__button padding__collapse">
						<span class="icon-bar__item"></span>
						<span class="icon-bar__item"></span>
						<span class="icon-bar__item"></span>
					</button>
				</li>

				<li class="list__item">
					<a class="default__link link__item" href="{{ env(strtoupper($locale) . '_DOMAIN') . '/sso-login' }}">
						@isset($client_name)
						<p class="username__label font-weight-light">{{ __('default.welcome_title') }}, {{ $client_name }}!</p>
						@endisset

						<img class="item__img" src="{{ preview(asset('uploads/design/icons-97.svg'), 30, 30) }}" alt="login"/>
					</a>
				</li>

				<li class="list__item">
					<a id="link-cart__container" class="link__item" href="#">
						<img class="item__img" src="{{ preview(asset('uploads/design/icons-02.svg'), 30, 30) }}" alt="cart" />

						<div class="cart__counter text-center font-weight-bold">0</div>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="row" style="margin: 0 auto">
		<div class="col-md-4 padding__collapse"></div>
		<div id="dark-helper__container" class="col-md-8 padding__collapse margin__collapse"></div>
	</div>
</header>
<div class="not_found" >
<h1>404 Not Found</h1>
</div>
@php
	$context = App\Model\Base\Context::select()->where('title', $locale)->first();

	$productsPage = App\Model\Base\Page::select()->where('parent_id', 0)->where('context_id', $context->id)->where('view_id', 3)->first();

	$otherPages = App\Model\Base\Page::select()
		->where('parent_id', 0)
		->where('context_id', $context->id)
		->where(function ($q) {
			return $q
				->orWhere('view_id', 4)
				->orWhere('view_id', 7);
		})->get();

	$courses = App\Model\Shop\ExchangeRate::select()->get()->groupBy('title');
@endphp

<footer id="footer__container" class="footer__container">
	<div class="service__container">
		<div class="row__container row default__container">
			<div class="social__container padding__collapse col-sm-4 col-md-2 col-lg-4">
				<a target="_blank" href="https://t.me/myriglive" class="item__link">
					<div class="title__container">Telegram</div>
					<div class="icon__container text-center">
						<i class="fa fa-telegram"></i>
					</div>
				</a>

				<a target="_blank" href="https://twitter.com/myrig_com" class="item__link">
					<div class="title__container">Twitter</div>
					<div class="icon__container text-center">
						<i class="fa fa-twitter"></i>
					</div>
				</a>

				<a target="_blank" href="http://youtube.com/#" class="item__link">
					<div class="title__container">Youtube</div>
					<div class="icon__container text-center">
						<i class="fa fa-youtube-play"></i>
					</div>
				</a>
			</div>

			<div class="currency-rates__container text-right padding__collapse col-sm-8 col-md-10 col-lg-8">
				<span class="currency__item">BTC <span class="equal__item">=</span> ${{number_format($courses['BTC/USD'][0]->value, 2, '.', '')}}</span>
				
				<span class="currency__item">BCH <span class="equal__item">=</span> ${{number_format($courses['BCH/USD'][0]->value, 2, '.', '')}}</span>
				
				<span class="currency__item">LTC <span class="equal__item">=</span> ${{number_format($courses['LTC/USD'][0]->value, 2, '.', '')}}</span>
				
				<span class="currency__item">DASH <span class="equal__item">=</span> ${{number_format($courses['DASH/USD'][0]->value, 2, '.', '')}}</span>
				
				<span class="currency__item">ETH <span class="equal__item">=</span> ${{number_format($courses['ETH/USD'][0]->value, 2, '.', '')}}</span>
			</div>
		</div>
	</div>

	<div class="info__container">
		<div class="row__container row default__container">
			<div class="logo__container padding__collapse col-sm-2 col-md-2 col-lg-2">
				<a class="link__item logo-link__item" href="{{ asset('/') }}">
					<img class="logo__icon" src="{{ preview(asset('uploads/design/logo.png'), 162, 35) }}" alt="logo" style="width: 162px" />
				</a>
					
				<div class="payment-types__container">
					<img src="{{ asset('uploads/design/bitcoin.png') }}" alt="bitcoin" />
					<img src="{{ asset('uploads/design/paypal.png') }}" alt="paypal" />
				</div>
			</div>

			<ul class="navigation__list list__container margin__collapse padding__collapse col-sm-10 col-md-7 col-lg-7">
				<li class="list__item">
					<a href="{{ url($productsPage->link) }}">
						{{ $productsPage->title }}
					</a>
				</li>

				<li class="list__item">
					<a href="https://host.myrig.com/">
						{{ __('default.footer_hosting') }}
					</a>
				</li>

				@foreach ($otherPages as $page)
				<li class="list__item">
					<a href="{{ url($page->link) }}">
						{{ $page->title }}
					</a>
				</li>
				@endforeach
			</ul>

			<div class="contacts__container padding__collapse col-sm-12 col-md-3 col-lg-3 row">
				<ul id="footer-contacts__list" class="contacts__list col-md-6">
				@php
					$contacts = App\Model\Base\Page::whereHas('view', function ($q) {
						$q->where('title', 'Contacts');
					})->first();
									
					$contactsMulti = [];
					if (isset($contacts)) {
						$contactsMulti = App\Model\Base\MultiVariableContent::multiConvert($contacts->view->variables);
					}
				@endphp

				@foreach ($contactsMulti['Contact items'] as $line)
				<li class="list__item @if($line['country'] == 'USA') active @endif">{{ __('common.cont_' . $line['country'] ) }}
					<div class="phone-area__container">
						@if(isset($line['phone']) && $line['phone']) 
							{{ $line['phone'] }} 
						@else 
							support@myrig.com 
						@endif
					</div>
				</li>
				@endforeach
				</ul>

				<div class="col-md-6 connect-button__container padding__collapse text-right">
					<button id="connect__button" class="default__button connect__button text-uppercase">
						{{ __('default.contact_us_button') }}
					</button>
				</div>

				<div class="locales__container">
					<a title="USA" href="{{ env('EN_DOMAIN') . '?locale=en' }}">
						<img src="{{ asset('uploads/design/us.png') }}" alt="USA">
					</a>

					<a title="UA" href="{{ env('UA_DOMAIN') . '?locale=ua' }}">
						<img src="{{ asset('uploads/design/ua.png') }}" alt="UA">
					</a>

					<a title="RUR" href="{{ env('RU_DOMAIN') . '?locale=ru' }}">
						<img src="{{ asset('uploads/design/ru.png') }}" alt="RU">
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>

<div id="contacts__dialog" class="curtain__container">
	<div class="center__container">
		<div class="dialog__container contacts-dialog__container">
			<div class="title__container">
				<span>{{ __('default.contact_us_button') }}</span>
			</div>

			<form id="callback__form" class="form__container" method="post" action="/back_call">
				{{ csrf_field() }}

				<input id="name__field" name="name" type="text" class="field__input" placeholder="{{ __('default.name') }}" />

				<input type="tel" name="tel" class="field__input" required="required" placeholder="{{ __('default.phone') }}" />
				<input type="email" name="email" value="callback@myrig.com" hidden="hidden"/>

				<button type="submit" name="submit" class="text-uppercase default__button submit__button" />{{ __('default.request_a_call') }}</button>

				<input type="hidden" name="action" value="formcall_ajax_request">
				<input type="hidden" name="subject" value="Заказать звонок - Bitmain">
			</form>

			<div class="callback-success__container">
				<div class="message__container">{{ __('default.thank_you') }}</div>
				<div class="content__container">{{ __('default.manager_contact') }}</div>
			</div>
		</div>
	</div>
</div>

<div id="availability__dialog" class="curtain__container">
	<div class="center__container">
		<div class="availability-dialog__container">
			<div class="title__container">
				<span>{{ __('default.report_availability_popup') }}</span>
			</div>

			<form id="availability__form" class="availability__form form__container" method="post" action="">
				<div class="report-message__container font-weight-bold">
					{{ __('default.leave_request') }}
				</div>

				<input type="hidden" name="_token" value="{{ csrf_token() }}" />

				<input id="name__field" name="name" type="text" class="field__input" placeholder="{{ __('default.name') }}" required="required" />

				<input id="email__field" name="email" type="email" class="field__input" placeholder="E-mail" required="required" />

				<input type="tel" name="phone" class="field__input" required="required" placeholder="{{ __('default.phone') }}" />

				<div id="products-select__container" class="products-select__container">
					<div class="product-item__container product-item__container-1 row padding__collapse">
						<div class="select__container col-sm-8 padding__collapse margin__collapse">
							<ul class="list__container products__list toggle__list padding__collapse margin__collapse"></ul>
							
							<div class="selected__product toggle__current"></div>

							<input type="hidden" name="products[0][id]" class="product-selected__input toggle__input prooduct-item__field" />
						</div>

						<div class="col-sm-1 padding__collapse margin__collapse"></div>

						<div class="cart-count__container col-sm-3 padding__collapse margin__collapse text-right">
							<div class="counter__container">
								<input type="text" name="products[0][count]" class="form-control form-number cart-count__input margin__collapse padding__collapse text-center input__border count-item__field" value="1" />
									
								<button class="default__button plus-icon__button padding__collapse margin__collapse">
									<i class="fa fa-plus"></i>
								</button>

								<button class="default__button minus-icon__button padding__collapse margin__collapse">
									<i class="fa fa-minus"></i>
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="products-control__container">
					<button id="add-product__button" class="add-product__button transparent__button">+</button>
					<button id="delete-product__button" class="delete-product__button transparent__button">-</button>
				</div>

				<div class="recaptcha__container">
					<div class="form-group">
						<div id="g-recaptcha" data-check="0"></div>
					</div>
					<p class="error-captcha__container text-center font-weight-bold">{{ __('default.captcha') }}</p>
				</div>

				<button type="submit" name="submit" class="default__button submit__button text-uppercase">{{ __('default.send') }}</button>
			</form>

			<div class="callback-success__container">
				<div class="message__container">{{ __('default.thank_you') }}</div>
				<div class="content__container">{{ __('default.manager_contact') }}</div>
			</div>
		</div>
	</div>
</div>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<link rel="stylesheet" href="{{ asset('css/' . strtolower('Index') . '.css') }}">
<script type="text/javascript" src="{{ asset('js/' . strtolower('Index') . '.js') }}"></script>
<script type="text/javascript">
	var global = {
		url: "{{ config('app.' . $locale . '_domain') . '/' }}",
		app: {
			connector: "{{ asset('connector') }}"
		}
	};
</script>

<script>
window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("https://assets.zendesk.com/embeddable_framework/main.js","bitmain.zendesk.com");
</script>
</div>
	</body>
</html>