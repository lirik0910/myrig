<div class="slide-item__container margin__collapse" data-dot="<button class='slide-dot__button padding__collapse'><div class='slide-item__progress'></div></button>">
	<div class="row__container row default__container">
		<div class="slide-about__container col-md-4 padding__collapse center__align font-weight-light">
			<div class="vertical-align__container">
				<h4 class="slide__title font-weight-light">
					{!! $slide['header'] !!}
				</h4>

				<div class="slide__content">
					{!! $slide['content'] !!}
				</div>

				<a href="{{ url( $slide['link'] ) }}" class="slide__link default__button text-uppercase">
					{{ __('default.more_info') }}
				</a>
			</div>
		</div>

		@php
		$img = asset('uploads/' . $slide['icon']);
		$imgInfo = getimagesize($img);
		@endphp

		@if($imgInfo[1] < $imgInfo[0])
		<div class="slide-icon__container col-md-8 padding__collapse" style="background-image: url('{{ $preview($img, 1350, 941) }}')"></div>
		@else
		<div class="slide-icon__container col-md-8 padding__collapse" style="background-image: url('{{ $preview($img, 800, 800) }}')"></div>
		@endif
	</div>
</div>