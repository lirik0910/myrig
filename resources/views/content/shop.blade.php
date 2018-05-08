@extends('layouts.app')

@php
//var_dump($it); die;
$mainProducts = $select('\App\Model\Shop\Product')
	->whereHas('categories', function ($q) {
		$q->where('title', 'Base');
	})
	->where('delete', 0)
	->where('context_id', $it->context_id)
	->with('page', 'options', 'images')
	->get();

$secondaryProducts = $select('\App\Model\Shop\Product')
	->whereHas('categories', function ($q) {
		$q->where('title', 'Secondary');
	})
	->where('delete', 0)
    ->where('context_id', $it->context_id)
	->with('page', 'options', 'images')
	->get();
//var_dump($secondaryProducts); die;
@endphp

@section('content')
<main style="width: 100%" style="position: absolute;">
<div class="main-back"></div>
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
	
<section class="content item items">
	<div class="container">
		<div class="clearfix" style="clear: both"></div>
		@foreach($mainProducts as $item)
			@if (isset($item->page))
				@include('parts.shop.item', $item)
			@endif
		@endforeach
	</div>
</section>

<section class="related">
	<div class="container">
		<div class="row">
			<header>{{ __('default.optional_equipment') }}</header>
			<div id="relatedSlider" class="related-slider owl-carousel owl-theme">
				@foreach ($secondaryProducts as $item)
					@if (isset($item->page))
						@include('parts.shop.slideItem', $item)
					@endif
				@endforeach

			</div>
		</div>
	</div>
</section>
</main>
@include('parts.shop.report-availability_form')
@endsection
