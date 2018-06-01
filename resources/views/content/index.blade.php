@extends('layouts.app')
@section('content')

@php
$shop = $select('App\Model\Base\Page')
	->whereHas('view', function ($q) {
		$q->where('title', 'Shop');
	})
	->first();
@endphp

<div id="dark__container" class="dark__container"></div>

<div id="index-slider__container" class="index-slider__container owl-carousel owl-theme">
	@foreach ($multi['indexSlider'] as $slide)
		@include('partsIndex.slideItem', $slide)
	@endforeach
</div>

<div class="promo__container">
	<div class="row__container row default__container">
		@foreach ($multi['indexLinks'] as $item)
			@include('partsIndex.promoItem', $item)
		@endforeach
	</div>
</div>

@endsection