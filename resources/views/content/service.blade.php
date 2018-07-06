@extends('layouts.app')

@section('content')

<div id="dark__container" class="dark__container"></div>

<div class="products__container default__container">
	<div class="row row__container product-item__container margin__collapse">
		<div class="d-block col-sm-4 slider__container margin__collapse padding__collapse">
			<div class="border__container"></div>

			<h3 class="title__container font-weight-bold news-title__container margin__collapse">
				{{ $it->introtext }}
			</h3>
		</div>

		<div class="col-sm-8 product-content__container news-content__container margin__collapse">
			<div class="border__container"></div>

			<div class="content__container font-weight-light">
				<p>{!! $it->content !!}</p>

				<button id="ticket__button" class="default__button text-uppercase">{{ __('default.create_ticket') }}</button>

				<p style="margin-top: 18px">
					<strong><span style="color: #60a600;">{{ __('default.contact_for_communication') }}</span></strong><br />

					+38 (044) 360-79-58 {{__('default.ukraine')}}
				</p>

				<p>+7 (499) 918-73-89 {{__('default.russia')}}</p>
				<p>+1-844-248-62-46 USA</p>

				<p>Telegram &#8212; <span style="color: #2ba1df;"><a style="color: #2ba1df;" href="http://t.me/myrigservice" data-wpel-link="external" rel="nofollow external noopener noreferrer" target="_blank">@myrigservice</a></span><br />
				support@myrig.com  </p>

				<p><strong><span style="color: #60a600;">{{ __('default.schedule') }}</span></strong><br />{!! __('default.monday_friday') !!}<br />10:00 &#8212; 19:00</p>
			</div>
		</div>


	</div>
</div>
	
@endsection