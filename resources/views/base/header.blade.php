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
$client_email = session()->get('client');
if(isset($client_email) && !empty($client_email)){
    $user = $select('App\Model\Base\User')->where('email', $client_email)->first();

    if($user){
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
					<a href="{{url(env('APP_URL') . 'sso-login')}}" class="profile-link reg-f0" data-wpel-link="internal">
                        @isset($client_name)<p class=""> Welcome, {{ $client_name }}! </p>@endisset
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