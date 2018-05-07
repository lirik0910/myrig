@extends('layouts.app')

@section('content')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0VFdy6lo9DhNk0aeq0XlsShrLa_5jf9k" defer=""></script>

<main class="contact-map">

<div class="main-back" style="left: 588px !important">
	<div id="mapField" data-img="https://myrig.com.ua/wp-content/themes/bitmain/img/contact_logo.png?v=1" data-lat="39.768294" data-lng="-104.90209679999998"></div>
</div>
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
</script>
@php
//var_dump($multi['Contact items'])

@endphp
<section class="content contact">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				@isset($multi['Contact items'])
					@foreach($multi['Contact items'] as $var)
						<div class="contact-item @if($loop->first)head-contact-item @endif" data-lat="{{$var['lat']}}" data-lng="{{$var['lng']}}">
							<p><!--:ru--></p>
							<div class="country">{{$var['country']}}</div>
							<div class="service">{{$var['serviceType']}}</div>
							<div class="add-info"></div>
							@if(!empty($var['address']))
								<div class="address">{{$var['address']}}</div>
							@endif
							<div class="phones">
							    @if(!empty($var['phone']))
									<a href="tel:{{$var['phone']}}" data-wpel-link="internal">{{$var['phone']}}</a>
								@endif
								@if(!empty($var['telegram']))
									<br>Telegram channel<br />
									<a href="http://http://t.me/myrigservice" style="color: #2ba1df;" data-wpel-link="external" rel="nofollow external noopener noreferrer">{{$var['telegram']}}</a>
								@endif
							</div>
							<p><!--:--></p>
						</div>
					@endforeach
				@endisset
			</div>

			<div class="article-content col-sm-8"></div>
		</div>
	</div>
</section>

</main>
@endsection