<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8"/>
@php
//var_dump($it); die;
@endphp
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta lang="{{ $locale }}" />
<title>{{ htmlentities($it->title) }}</title>
<meta name="description" content="{{ htmlentities($it->description) }}" />
<base href="{{ asset('/') }}" />

<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="format-detection" content="telephone=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel='dns-prefetch' href='//ajax.googleapis.com' />
<link rel='dns-prefetch' href='//maxcdn.bootstrapcdn.com' />
<link rel='dns-prefetch' href='//s.w.org' />
{{--<link rel='stylesheet' href="{{ URL::asset('css/woocommerce-layout.css?ver=3.2.6') }}" type='text/css' media='all' />
<link rel='stylesheet' href="{{ URL::asset('css/woocommerce-smallscreen.css?ver=3.2.6') }}" type='text/css' media='only screen and (max-width: 768px)' />--}}
<link rel='stylesheet' href='{{ URL::asset('css/woocommerce.css?ver=3.2.6') }}' type='text/css' media='all' />
<link rel="stylesheet" href="{{ URL::asset('css/jquery.fancybox.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/animate.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/select2.css?ver=3.2.6') }}">
<link rel="stylesheet" href="{{ URL::asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/bootstrapvalidator.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/intlTelInput.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/calc.css') }}">
<link rel="stylesheet" id="font-awesome-css"  href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css?ver=2.2.0" type="text/css" media="all" />
<link rel="stylesheet" href="{{ URL::asset('css/bitmain.css?ver=1.55') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style.css?ver=1.55') }}">
<link rel="stylesheet" id="dashicons-css"  href="{{ URL::asset('css/dashicons.min.css?ver=4.9.4') }}" type="text/css" media="all" />

<link rel="apple-touch-icon" sizes="57x57" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="60x60" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="72x72" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="76x76" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="114x114" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="120x120" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="144x144" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="152x152" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="180x180" href="/favicon/fav-new.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/favicon/fav-new.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon/fav-new.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon/fav-new.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon/fav-new.png">
<link rel="manifest" href="/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/favicon/fav-new.png">
<meta name="theme-color" content="#ffffff">

<script type="text/javascript" src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
<script type="text/javascript">
    window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.4\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.4\/svg\/","svgExt":".svg","source":{"concatemoji":"https:\/\/myrig.com.ua\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.9.4"}};
    !function(a,b,c){function d(a,b){var c=String.fromCharCode;l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,a),0,0);var d=k.toDataURL();l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,b),0,0);var e=k.toDataURL();return d===e}function e(a){var b;if(!l||!l.fillText)return!1;switch(l.textBaseline="top",l.font="600 32px Arial",a){case"flag":return!(b=d([55356,56826,55356,56819],[55356,56826,8203,55356,56819]))&&(b=d([55356,57332,56128,56423,56128,56418,56128,56421,56128,56430,56128,56423,56128,56447],[55356,57332,8203,56128,56423,8203,56128,56418,8203,56128,56421,8203,56128,56430,8203,56128,56423,8203,56128,56447]),!b);case"emoji":return b=d([55357,56692,8205,9792,65039],[55357,56692,8203,9792,65039]),!b}return!1}function f(a){var c=b.createElement("script");c.src=a,c.defer=c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var g,h,i,j,k=b.createElement("canvas"),l=k.getContext&&k.getContext("2d");for(j=Array("flag","emoji"),c.supports={everything:!0,everythingExceptFlag:!0},i=0;i<j.length;i++)c.supports[j[i]]=e(j[i]),c.supports.everything=c.supports.everything&&c.supports[j[i]],"flag"!==j[i]&&(c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&c.supports[j[i]]);c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&!c.supports.flag,c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.everything||(h=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",h,!1),a.addEventListener("load",h,!1)):(a.attachEvent("onload",h),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),g=c.source||{},g.concatemoji?f(g.concatemoji):g.wpemoji&&g.twemoji&&(f(g.twemoji),f(g.wpemoji)))}(window,document,window._wpemojiSettings);
</script>
<meta name="google-site-verification" content="YroKW8N1nmTvNHctf_WMuPtVYhPqE4bklPM-o6buvrc" />

	</head>

	<body>
		<div id="root__container" class="root__container">
			@php
			$products = $get($settings['site.products_page']);
			$service = $get($settings['site.service_page']);
			$news = $get($settings['site.news_page']);
			$contacts = $get($settings['site.contacts_page']);

			$cart = $select('App\Model\Base\Page')
				->where('view_id', 8)
				->first();

			$count = 0;
			foreach ($inCart as $i) {
				$count += (int) $i;
			}
			if(isset($_SESSION['client'])){
			    $client_email = $_SESSION['client'];
			}
			//$client_email = $_SESSION['client'];
			if(isset($client_email) && !empty($client_email)){
			    $user = $select('App\Model\Base\User')->where('email', $client_email)->first();

			    if($user){
			    //var_dump($user->attributes); die;
			        $client_name = $user->attributes->fname;
			    }
			}

			@endphp

			<div id="canvas">
				<nav id="myNavmenu" class="navmenu navmenu-default" role="navigation">
					<ul id="menu-main-menu" class="nav">
						@if ($products)
						<li id="menu-item-31" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-31">
							<a href="{{ asset($products->link) }}" data-wpel-link="internal">{{ $products->title }}</a>
						</li>
						@endif

						<li id="menu-item-26" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-26">
							<a href="https://host.myrig.com/" data-wpel-link="internal">{{ __('default.hosting_title') }}</a>
						</li>

						@if ($service)
						<li id="menu-item-29" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-11 current_page_item menu-item-29">
							<a href="{{ asset($service->link) }}" data-wpel-link="internal">{{ $service->title }}</a>
						</li>
						@endif

						@if ($news)
						<li id="menu-item-27" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-27">
							<a href="{{ asset($news->link) }}" data-wpel-link="internal">{{ $news->title }}</a>
						</li>
						@endif

						@if ($contacts)
						<li id="menu-item-30" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-30">
							<a href="{{ asset($contacts->link) }}" data-wpel-link="internal">{{ $contacts->title }}</a>
						</li>
						@endif
					</ul>
				</nav>
			</div>

			<header class="header">
				<nav class="navbar">
					<div class="container">
						<div class="row">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								
								<a class="navbar-brand" href="{{ asset('/') }}" data-wpel-link="internal">
									<img src="{{ $preview(asset('uploads/design/logo.png'), 162, 35) }}" alt="{{ env('APP_NAME') }}" style="width: 162px"/>
								</a>
							</div>
							
							<div class="collapse navbar-collapse" id="myNavbar">
								<ul id="menu-main-menu-1" class="nav navbar-nav">
									@if ($products)
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-26">
										<a href="{{ asset($products->link) }}" data-wpel-link="internal">{{ $products->title }}</a>
									</li>
									@endif

									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-26">
										<a href="https://host.myrig.com/" data-wpel-link="internal">{{ __('default.hosting_title') }}</a>
									</li>

									@if ($service)
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-26">
										<a href="{{ asset($service->link) }}" data-wpel-link="internal">{{ $service->title }}</a>
									</li>
									@endif

									@if ($news)
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-26">
										<a href="{{ asset($news->link) }}" data-wpel-link="internal">{{ $news->title }}</a>
									</li>
									@endif

									@if ($contacts)
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-26">
										<a href="{{ asset($contacts->link) }}" data-wpel-link="internal">{{ $contacts->title }}</a>
									</li>
									@endif
								</ul>
							</div>

							<div class="user-panel">
								<a href="{{ env(strtoupper($locale) . '_DOMAIN') . '/sso-login' }}" class="profile-link reg-f0" data-wpel-link="internal">
			                        @isset($client_name)<p class="username__label"> {{ __('default.welcome_title') }}, {{ $client_name }}! </p>@endisset
									<img src="{{ $preview(asset('uploads/design/icons-97.svg'), 30, 30) }}" alt="login" style=""/>
								</a>

								<a href="{{ url($cart->link) }}" data-wpel-link="internal">
									<img src="{{ $preview(asset('uploads/design/icons-02.svg'), 30, 30) }}" alt="cart"/>
									<div class="label" id="cart-count-label">{{ $count }}</div>
								</a>
							</div>
						</div>
					</div>
				</nav>
			</header>

    <main style="width: 100%" style="position: absolute;">
        @php
            $order = App\Model\Shop\Order::where('number', $number)->with('orderDeliveries', 'products')->first();
            $delivery = App\Model\Shop\Delivery::where('id', $order->orderDeliveries->delivery_id)->first();
            $payment = App\Model\Shop\PaymentType::where('id', $order->payment_type_id)->first();
            //var_dump($order->products); die;
        @endphp
        <div class="main-back"  ></div>
        <script>
            var width = $(window).width(),
                cont = $('.container').outerWidth();
            var margin = (width - cont) / 2;
            var wM = cont * 33.333333 / 100 + margin;

            if (width > 767) {
                $('.main-back').css('left', wM +'px');
            }

            else {
                $('.main-back').css('left', '0px');
            }
            
            jQuery(document).ready(function($){

                if ($("#timer").length) {
                    function startTimer(){
                        var e=document.getElementById("timer").innerHTML.split(/[:]+/),
                            t=e[0],n=checkSecond(e[1]-1);59==n&&(t-=1),
                            document.getElementById("timer").innerHTML=t+":"+n,
                            setTimeout(startTimer,1e3)}

                    function checkSecond(e)
                    {return e<10&&e>=0&&(e="0"+e),e<0&&(e="59"),e}
                    document.getElementById("timer").innerHTML="",
                        startTimer();
                }

            })

        </script>
        <style>
            .timer {
                background: #60a645;
                color: #fff;

                padding: 10px;
                font-weight: bold;
            }
            #timer {
                float: right;
            }
        </style>
        <section class="content order">
            <div class="container">
                <div class="row widgets">
                    <div class="woocommerce">
                        <div class="woocommerce-order">
                            <div class="col-sm-4" id="customer_details">
                                <div class="widget wPay">
                                    <h4 class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">{{ __('default.order_was_successfully_accepted') }}</h4>
                                    <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
                                        <li class="woocommerce-order-overview__order order">
                                            {{ __('default.order_number') }}						<strong>{{$order->number}}</strong>
                                        </li>
                                        <li class="woocommerce-order-overview__date  ">
                                            {{ __('default.date')}} 						<strong>@php echo date('d-m-Y', strtotime($order->created_at)) @endphp</strong>
                                        </li>
                                        <li class="woocommerce-order-overview__total total">
                                            {{ __('default.total_checkout_success')}}						<strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>{{ number_format($order->cost, 2, '.', '') }}</span></strong>
                                        </li>
                                        <li class="woocommerce-order-overview__payment-method method">
                                            {{ __('default.payment')}}						<strong>{{__('default.payment_' . strtolower($payment->title)) }}</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="article-text">
                                    <div class="widget wDelivery">
                                        <section class="woocommerce-order-details">

                                            <h2 class="woocommerce-order-details__title" style="float: left">{{ __('default.info_about_order')}}</h2>
                                            <a class="btn-default" href="download-pdf/{{ $order->number }}" style="float: right; margin-top: 30px; margin-bottom: 20px">{{ __('default.download_invoice')}}</a>

                                            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                                                <thead>
                                                <tr>
                                                    <th class="woocommerce-table__product-name product-name">{{ __('default.product') }}</th>
                                                    <th class="woocommerce-table__product-table product-total">{{ __('default.price') }}</th>
                                                </tr>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->carts as $item)
                                                        @php
															$price = $item->cost;
                                                        @endphp
                                                        <tr class="woocommerce-table__line-item order_item">
                                                            <td class="woocommerce-table__product-name product-name">
                                                                <a @if($item->product->page) href="{{$item->product->page->link}}" data-wpel-link="internal" @endif>{{$item->product->title}}</a> <strong class="product-quantity">&times; {{$item->count}}</strong>	</td>
                                                            <td class="woocommerce-table__product-total product-total">
                                                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>{{ number_format($price * $item->count, 2, '.', '') }}</span>	</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th scope="row">{{ __('default.items_cost') }}</th>
                                                    <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>{{ number_format($order->cost, 2, '.', '') }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{{ __('default.delivery_checkout_success') }}</th>
                                                    <td>@if($delivery->title == 'Without delivery') {{__('default.without_delivery') }}  @else{{$delivery->title}}@endif</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{{ __('default.payment_type') }}</th>
                                                    <td>{{__('default.payment_' . strtolower($payment->title)) }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{{ __('default.total') }}</th>
                                                    <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;{{ number_format($order->cost, 2, '.', '') }}</span></span></td>
                                                </tr>
                                                </tfoot>

                                            </table>
                                            <section class="woocommerce-customer-details">
                                                <h2>{{ __('default.info_about_client') }}</h2>
                                                <table class="woocommerce-table woocommerce-table--customer-details shop_table customer_details">
                                                    <tr>
                                                        <th>{{ __('default.comment') }}</th>
                                                        <td>{{$order->orderDeliveries->comment}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Email:</th>
                                                        <td>{{$order->orderDeliveries->email}}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>{{ __('default.phone') }}</th>
                                                        <td>{{$order->orderDeliveries->phone}}</td>
                                                    </tr>
                                                </table>
                                                <h3 class="woocommerce-column__title">{{ __('default.address_info') }}</h3>
                                                <address>{{$order->orderDeliveries->first_name}} {{$order->orderDeliveries->last_name}}<br/>{{ __('common.country_' . $order->orderDeliveries->country) }}, {{$order->orderDeliveries->city}}<br/>{{$order->orderDeliveries->address}}</address>
                                            </section>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @php
	$context = $select('App\Model\Base\Context')->where('title', $locale)->first();

    $productsPage = $select('App\Model\Base\Page')->where('parent_id', 0)->where('context_id', $context->id)->where('view_id', 3)->first();

    $otherPages = $select('App\Model\Base\Page')
        ->where('parent_id', 0)
        ->where('context_id', $context->id)
        ->where(function ($q) {
            return $q
                ->orWhere('view_id', 4)
                ->orWhere('view_id', 7);
        })->get();

    $courses = $select('App\Model\Shop\ExchangeRate')->get()->groupBy('title');

    $infoPages = $select('App\Model\Base\Page')
        ->where('parent_id', 0)
        ->where('context_id', $context->id)
        ->where('view_id', 10)
        ->get();
@endphp

<footer class="footer">
	<div class="top-row">
		<div class="container">
			<div class="row">
				<div class="social col-sm-4 col-md-2 col-lg-4">
					
					<a target="_blank" href="http://facebook.com/#" data-wpel-link="external" rel="nofollow external noopener noreferrer">
						<div class="social-title">Facebook</div>
						<div class="hidden-icon">
							<i class="fa fa-facebook"></i>
						</div>
					</a>

					<a target="_blank" href="https://twitter.com/myrig_com" data-wpel-link="external" rel="nofollow external noopener noreferrer">
						<div class="social-title">Twitter</div>
						<div class="hidden-icon">
							<i class="fa fa-twitter"></i>
						</div>
					</a>

					<a target="_blank" href="http://youtube.com/#" data-wpel-link="external" rel="nofollow external noopener noreferrer">
						<div class="social-title">Youtube</div>
						<div class="hidden-icon">
							<i class="fa fa-youtube-play"></i>
						</div>
					</a>
				</div>
				
				<div class="exchange col-sm-8 col-md-10 col-lg-8">
					<span class="current">BTC <span class="h-m">=</span> ${{number_format($courses['BTC/USD'][0]->value, 2, '.', '')}}</span>
					<span class="current">BCH <span class="h-m">=</span> ${{number_format($courses['BCH/USD'][0]->value, 2, '.', '')}}</span>
					<span class="current">LTC <span class="h-m">=</span> ${{number_format($courses['LTC/USD'][0]->value, 2, '.', '')}}</span>
					<span class="current">DASH <span class="h-m">=</span> ${{number_format($courses['DASH/USD'][0]->value, 2, '.', '')}}</span>
					<span class="current">ETH <span class="h-m">=</span> ${{number_format($courses['ETH/USD'][0]->value, 2, '.', '')}}</span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="middle-row">
		<div class="container">
			<div class="row">
				<div class="col-sm-2 col-md-2 col-lg-2 logo">
					<a href="{{ asset('/') }}" data-wpel-link="internal">
						<img src="{{ $preview(asset('uploads/design/logo.png'), 162, 35) }}" alt="logo"/>
					</a>
					
					<div class="payment">
						<img src="{{ asset('uploads/design/bitcoin.png') }}" alt="bitcoin"/>
						<img src="{{ asset('uploads/design/paypal.png') }}" alt="paypal"/>
					</div>
				</div>
				
				<div class="col-sm-10 col-md-7 col-lg-7 footer-menu">
					<ul id="menu-footer-menu-1" class="">
						<li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144">
							<a href="{{ url($productsPage->link) }}" data-wpel-link="internal">
								{{ $productsPage->title }}
							</a>
						</li>
						<li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144">
							<a href="https://host.myrig.com/" data-wpel-link="internal">
								{{ __('default.footer_hosting') }}
							</a>
						</li>
						@foreach ($otherPages as $page)
						<li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144">
							<a href="{{ url($page->link) }}" data-wpel-link="internal">
								{{ $page->title }}
							</a>
						</li>
						@endforeach
					</ul>

					<ul id="menu-footer-menu-2" class="">
						@foreach ($infoPages as $page)
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-820">
							<a href="{{ $page->link }}">
								{{ $page->title }}
							</a>
						</li>
						@endforeach
					</ul>
				</div>
				
				<div class="col-sm-12 col-md-3 col-lg-3">
					<div class="contacts">
						<ul>
							@php
								$contacts = App\Model\Base\Page::whereHas('view', function ($q) {
									$q->where('title', 'Contacts');
								})->first();
								
								$contactsMulti = [];
								if (isset($contacts)) {
									$contactsMulti = App\Model\Base\MultiVariableContent::multiConvert($contacts->view->variables);
								}
							@endphp

							@isset($contactsMulti['Contact items'])
								@foreach ($contactsMulti['Contact items'] as $line)
									<li class="@if($line['country'] == 'USA') active @endif">{{ __('common.cont_' . $line['country'] ) }}
										<div class="phone-area">
											@if(isset($line['phone']) && $line['phone']) {{ $line['phone'] }} @else support@myrig.com @endif
										</div>
									</li>
								@endforeach
							@endisset
						</ul>
					</div>
					<a href="#call" class="btn-default reg-c" data-wpel-link="internal">{{ __('default.contact_us_button') }}</a>
					<div class="locale-switcher">
						<a title="USA" href="{{ env('EN_DOMAIN') . '?locale=en' }}" data-wpel-link="external" rel="nofollow external noopener noreferrer">
							<img src="{{ asset('uploads/design/us.png') }}" alt="">
						</a>
						<a title="UKR" href="{{ env('UA_DOMAIN') . '?locale=ua' }}" data-wpel-link="internal">
							<img src="{{ asset('uploads/design/ua.png') }}" alt="">
						</a>
						<a title="RUS" href="{{ env('RU_DOMAIN') . '?locale=ru' }}" data-wpel-link="external" rel="nofollow external noopener noreferrer">
							<img src="{{ asset('uploads/design/ru.png') }}" alt="ru">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<div style="display:none">
	<div id="callsuccess" class="popup-success">
		<div class="modal-header success-header">
			{{ __('default.thank_you') }}</div>
		<div class="modal-body">
			{{ __('default.manager_contact') }}
       </div>
		<div class="modal-footer">
			<button data-fancybox-close>{{ __('default.close') }}</button>
		</div>
	</div>
	<div id="call">
		<div class="modal-header">
			<ul class="reg-links">
				<li class="active" data-target="#enter-field"><a href="" data-wpel-link="internal">{{ __('default.contact_us_button') }}</a></li>
			</ul>
		</div>
		<div class="modal-body">
			<div id="call-field">
				<form id="callback" action="/back_call">
					{{csrf_field()}}
					<div class="form-group">
						<input id="name" type="text" name="name" class="form-control" placeholder="{{ __('default.name') }}" required="required" data-bv-message=" " data-bv-remote-message="Email уже занят"/></div>
					<div class="form-group">
						<input type="email" name="email" value="callback@myrig.com" hidden="hidden"/></div>
					<div class="form-group">
						<input type="tel" name="tel" class="form-control" required="required" data-bv-message=" " placeholder="{{ __('default.phone') }}"/></div>
						{{-- <div class="faspin"><i class="fa fa-cog fa-spin" hidden="hidden"></i></div> --}}
					<div class="form-group">
						{{-- <input type="submit" name="submit" value="{{ __('default.request_a_call') }}" class="btn-default btn-subscribe"/> --}}
						<button type="submit" name="submit" class="btn-default btn-subscribe">{{ __('default.request_a_call') }}<span class="faspin"><i class="fa fa-cog fa-spin" hidden="hidden"></i></span></button>
					</div>
					<input type="hidden" name="action" value="formcall_ajax_request">
					<input type="hidden" name="subject" value="Заказать звонок - Bitmain">
				</form>
				<div class="result">
					<div class="success-header">{{ __('default.thank_you') }}!</div>
					<div class="result-body">{{ __('default.manager_contact') }}.</div>
					<button data-fancybox-close>{{ __('default.close') }}</button>
				</div>
			</div>

		</div>
	</div>

	<div id="ticket">
		<div class="modal-header">
			<ul class="reg-links">
				<li data-target="#enter-field"><a href="" data-wpel-link="internal">{{ __('default.create_ticket_button') }}</a></li>
			</ul>
		</div>
		<div class="modal-body">
			<div id="ticket-field">
				<form id="ticketback">
					{{csrf_field()}}
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="E-mail" required="required" data-bv-message=" " data-bv-remote-message="Email уже занят"/></div>
					<div class="form-group">
						<input type="text" name="topic" class="form-control" required="required" data-bv-message=" " placeholder="{{ __('default.topic') }}"/></div>

					<div class="form-group">
						<textarea name="message" class="form-control" placeholder="{{ __('default.description') }}" required="required" data-bv-message=""></textarea></div>
					<div class="form-group">
						<span class="filename"></span>
						<label for="fileName"><i class="fa fa-paperclip"></i> {{ __('default.attach_file') }}</label>
						<input id="fileName" type="file" name="file" class="form-control" data-bv-message=" "></div>

					<input type="hidden" name="action" value="ticket_ajax_request">
					<input type="hidden" name="subject" value="Тикет - Bitmain">
					<div class="form-group">
						{{-- <input type="submit" name="submit"/> --}}
						<button type="submit" name="submit" class="btn-default btn-subscribe">{{ __('default.send') }}<span class="faspin"><i class="fa fa-cog fa-spin" hidden="hidden"></i></span></button>
					</div>
				</form>
				<div class="result">
					<div class="success-header">{{ __('default.thank_you') }}!</div>
					<div class="result-body">{{ __('default.manager_contact') }}.</div>
					<button data-fancybox-close>{{ __('default.close') }}</button>
				</div>
			</div>

		</div>
	</div>
	<!--<div id="reg">
		<div class="modal-header">
			<ul class="reg-links">
				<li class="active" data-target="#enter-field"><a href="" data-wpel-link="internal">Вход</a></li>
				<li data-target="#reg-field"><a href="" data-wpel-link="internal">Регистрация</a></li>
			</ul>
		</div>
		<div class="modal-body">
			<div id="reg-field">
				<form id="registration" action="#">
					<div class="form-group">
						<input id="user_email" type="email" name="user_email" class="form-control" placeholder="Эл. почта" required="required" data-bv-message=" " data-bv-remote-message="Email уже занят"/></div>
					<div class="form-group">
						<input type="tel" name="billing_phone" class="form-control billing_phone-reg" required="required"  data-bv-digits="true"   data-bv-message=" " placeholder="Телефон"/></div>

					<div class="form-group">
						<input type="submit" name="submit" value="Зарегистрироваться" class="btn-default btn-subscribe"/>
					</div>
					<input type="hidden" name="action" value="bitmain_account_register">
					<input type="hidden" name="register" value="1">
					<input type="hidden" name="subject" value="Регистрация пользователя - Bitmain">
				</form>
				<p class="result" data-text="Регистрация успешная! Пароль отправлен вам на email"></p>
			</div>
			<div id="enter-field">

				<div class="woocommerce">
					<form  id="enter" class="woocomerce-form woocommerce-form-login login " method="post">
						<div class="form-group">
							<input type="text" class="form-control" name="username" id="username" placeholder="Логин" value="" />
						</div>
						<div class="form-group">
							<input class="form-control" type="password" name="password" id="password" placeholder="Пароль"/>
						</div>
						<p class="form-row">
							<input type="hidden" id="woocommerce-login-nonce" name="woocommerce-login-nonce" value="c6b529870e" /><input type="hidden" name="_wp_http_referer" value="/" />             <input type="submit" class="btn-default btn-subscribe" name="login" value="Авторизация" />

						</p>
						<div class="more-wrapper"><a href="/wp-login.php?action=lostpassword" class="btn-recover" data-wpel-link="internal">Напомнить</a></div>
					</form>
				</div>
			</div>
		</div>
	</div>-->
</div>

<div id="response-message" class="modal-body result" style="display: none">
    <div class="success-header">{{ __('default.order_create') }}!</div>
    <div class="result-body">{{ __('default.manager_contact') }}.</div>
    <button id="order_success_close" data-fancybox-close>{{ __('default.okay') }}</button>
</div>

<script type="text/javascript">
	var global = {
		url: "{{ config('app.' . $locale . '_domain') . '/' }}",
		app: {
			connector: "{{ asset('connector') }}",
			csrf: "{{ csrf_token() }}"
		}
	};
	var calc = {};
	var products = {};
</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
		async defer>
</script>


<!-- <script type="text/javascript" src='https://myrig.com.ua/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js?ver=3.2.6'></script> -->
<script type="text/javascript" src="{{ asset('js/owl.carousel.min.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/intlTelInput.min.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.fancybox.min.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrapValidator.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/script.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/Chart.min.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/actions.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/calc.js?ver=1.12') }}"></script>

<script type="text/javascript" src="{{ asset('js/selectWoo.full.min.js?ver=1.0.1') }}"></script>
<script type="text/javascript" src="{{ asset('js/country-select.min.js?ver=3.2.6') }}"></script>
<script type="text/javascript">
var wc_country_select_params = {
	"countries": "[]",
	"i18n_select_state_text": "",
	"i18n_no_matches": "{{ __('default.no_matches') }}",
	"i18n_ajax_error": "",
	"i18n_input_too_short_1": "",
	"i18n_input_too_short_n": "",
	"i18n_input_too_long_1": "",
	"i18n_input_too_long_n": "",
	"i18n_selection_too_long_1": "",
	"i18n_selection_too_long_n": "",
	"i18n_load_more": "",
	"i18n_searching": ""
};
</script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-103386645-1"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-103386645-1');
</script>

<script>
window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("https://assets.zendesk.com/embeddable_framework/main.js","bitmain.zendesk.com");/*]]>*/
</script>
<!-- End of Zendesk Widget script -->


		</div>
	</body>
</html>