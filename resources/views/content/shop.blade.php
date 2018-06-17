@extends('layouts.app')

@php
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

if($locale === 'en'){
	$defaultImage = asset('uploads/default/en.no-photo.jpg');
} else{
	$defaultImage = asset('uploads/default/ru.no-photo.jpeg');
}
@endphp

@section('content')

<div id="dark__container" class="dark__container"></div>

<div class="products__container default__container">
	@foreach($mainProducts as $item)
		@include('partsShop.productItem', $item)
	@endforeach
</div>

<div class="related__container">
	<div class="container align__container default__container">
		<div class="row">
			<div class="related__title">{{ __('default.optional_equipment') }}</div>
			<div id="related-slider__container" class="related-slider__container owl-carousel owl-theme">
			@foreach ($secondaryProducts as $key => $item)
				@php
					$item->index = $key;
				@endphp
				@include('partsShop.relatedItem', $item)
			@endforeach
			</div>

			<div id="related-dots__container" class="related-dots__container"></div>
		</div>
	</div>
</div>

@endsection