@extends('layouts.app')

@php 
$mainProducts = $select('\App\Model\Shop\Product')
	->whereHas('categories', function ($q) {
		$q->where('title', 'Base');
	})
	->with('page', 'options', 'images')
	->get();

$secondaryProducts = $select('\App\Model\Shop\Product')
	->whereHas('categories', function ($q) {
		$q->where('title', 'Secondary');
	})
	->with('page', 'options', 'images')
	->get();
@endphp

@section('content')
<main>
<div class="main-back"></div>
	
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
			<div id="relatedSlider" class="owl-carousel owl-theme">
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
@endsection