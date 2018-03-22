@extends('layouts.app')

@section('content')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0VFdy6lo9DhNk0aeq0XlsShrLa_5jf9k" defer=""></script>

<main class="contact-map">

<div class="main-back">
	<div id="mapField" data-img="https://myrig.com.ua/wp-content/themes/bitmain/img/contact_logo.png?v=1" data-lat="39.768294" data-lng="-104.90209679999998"></div>
</div>
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
							@isset($var['address'])
								<div class="address">{{$var['address']}}</div>
							@endisset
							@isset($var['phone'])
								<div class="phones">
									@isset($var['phone'])
										<a href="tel:{{$var['phone']}}" data-wpel-link="internal">{{$var['phone']}}</a>
									@endisset
									
									@if(!empty($var['telegram']))
										<br>Telegram channel<br />
										<a href="http://http://t.me/myrigservice" style="color: #2ba1df;" data-wpel-link="external" rel="nofollow external noopener noreferrer">{{$var['telegram']}}</a>
									@endif
								</div>
							@endisset
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