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
// $client_email = $_SESSION['client'];
if(isset($client_email) && !empty($client_email)){
	$user = $select('App\Model\Base\User')->where('email', $client_email)->first();

	if($user){
	// var_dump($user->attributes); die;
		$client_name = $user->attributes->fname;
	}
}

@endphp

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

<header class="header__container default__container">
	<div class="row__container row margin__collapse">
		<div class="logo__container col-md-2 padding__collapse">
			<a class="link__item" href="{{ asset('/') }}">
				<img src="{{ $preview(asset('uploads/design/logo.png'), 162, 35) }}" alt="{{ env('APP_NAME') }}" style="width: 162px"/>
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
						<p class="username__label font-weight-light" style="line-height: 32px;">{{ __('default.welcome_title') }}, {{ $client_name }}!</p>
						@endisset

						<img class="item__img" src="{{ $preview(asset('uploads/design/icons-97.svg'), 30, 30) }}" alt="login"/>
					</a>
				</li>

				<li class="list__item">
					<a id="link-cart__container" class="link__item" href="{{ url($cart->link) }}">
						<img class="item__img" src="{{ $preview(asset('uploads/design/icons-02.svg'), 30, 30) }}" alt="cart" />

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