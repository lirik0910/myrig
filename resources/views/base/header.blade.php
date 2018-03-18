@php 
$menu = $select('App\Model\Base\Page')
	->where('parent_id', 0)
	->where(function ($q) {
		return $q
			->where('view_id', 3)
			->orWhere('view_id', 6)
			->orWhere('view_id', 7)
			->orWhere('view_id', 4);
	})->get();

$cart = $select('App\Model\Base\Page')
	->where('view_id', 8)
	->first();

$count = 0;
foreach ($inCart as $i) {
	$count += (int) $i;
}
@endphp

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
					@foreach($menu as $item)
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-26">
							<a href="{{ asset($item->link) }}" data-wpel-link="internal">{{ $item->title }}</a>
						</li>
					@endforeach
					</ul>
				</div>

				<div class="user-panel">
					<a href="{{url(env('APP_URL') . 'sso-login')}}" class="reg-f0" data-wpel-link="internal">
						<img src="{{ $preview(asset('uploads/design/icons-97.svg'), 30, 30) }}" alt="login"/>
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