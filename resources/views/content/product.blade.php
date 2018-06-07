@extends('layouts.app')

@section('content')

@php
	$context = $select('App\Model\Base\Context')->where('title', $locale)->first();

	$product = App\Model\Shop\Product::where('page_id', $it->id)
		->where('context_id', $context->id)
		->with('images', 'options')
		->first();
	$btcPrice = number_format($product->calcBtcPrice(), 4, '.', '');

	foreach ($product->options as $item) {
		if ($item->type->title === 'video') {
			$video = $item;
			break;
		}
	}

	if ($product->auto_price) {
	    $autoprice = $product->calcAutoPrice();
	    
	    if (!$autoprice) {
	        $price = number_format($product->price, 2, '.', '');
	    } else{
	        $price = number_format($autoprice, 2, '.', '');
	    }
	}
	else {
	    $price = number_format($product->price, 2, '.', '');
	}

	foreach($product->categories as $category) {
		if ($category->title == 'Base') {
			$payback = new App\Http\Controllers\ProductController();
			$payback = $payback->calcPayback($product->id);
		}
	}

@endphp

<div id="dark__container" class="dark__container"></div>

<div class="products__container default__container">
	<div class="row row__container product-item__container margin__collapse">
		<div class="col-sm-4 row slider__container margin__collapse" style="display: block;">
			<div class="border__container"></div>

			<div id="product-slider__container" class="product-slider__container owl-carousel owl-theme">
				@foreach($product->images as $image)
				<div class="slide__item text-center" data-dot="<button class='slide-dot__button padding__collapse'><div class='slide-item__progress'></div></button>">
					<img src="{{ $preview(asset('uploads/' . $image->name), 300, 300) }}" class="slide__icon" alt="{{ $image->name }}" title="{{ $product->title }}" />
					</div>
				@endforeach
			</div>

			<div id="dots-slider__container" class="dots-slider__container owl-carousel owl-theme">
				@foreach($product->images as $image)
				<div class="slide__item text-center">
					<img src="{{ $preview(asset('uploads/' . $image->name), 47, 47) }}" class="slide__icon" alt="{{ $image->name }}" title="{{ $product->title }}" />
				</div>
				@endforeach
			</div>
		</div>

		<div class="col-sm-8 product-content__container margin__collapse">
			<div class="border__container"></div>
			
			<h2 class="title__container font-weight-bold">
				{{ $product->title }}
			</h2>

			<div class="tags__container @if ($product->productStatus->title === 'in-stock') tag-check__icon @elseif ($product->productStatus->title === 'pre-order') tag-order__icon  @elseif ($product->productStatus->title === 'not-available') tag-no__icon @endif">
				{{ __('common.product_status_' . str_replace(' ', '_', mb_strtolower($product->productStatus->description))) }}
			</div>

			@if(isset($product->warranty) && !empty($product->warranty))
			<div class="tags__container tag-waranty__icon">
				{{ __('default.warranty') }} {{ $product->warranty }}
			</div>
			@endif

			<div>
				<div class="price__container">
					<span class="default__price">
						<span class="currency__symbol">&#36;</span>
						{{ $price }}
					</span>

					<span class="bitcoin__price">
						{{ $btcPrice }}
						<i class="fa fa-bitcoin"></i>
					</span>
				</div>
			</div>

			<form class="cart-count__container">
				<div class="counter__container">
					<input id="{{ 'count-products-' . $product->id }}" type="text" name="count" class="form-control form-number cart-count__input text-center" value="{{ isset($inCart[$product->id]) ? $inCart[$product->id] : 1 }}" data-id="{{ $product->id }}" />
						
					<button class="default__button plus-icon__button padding__collapse margin__collapse" data-id="{{ $product->id }}">
						<i class="fa fa-plus"></i>
					</button>

					<button class="default__button minus-icon__button padding__collapse margin__collapse" data-id="{{ $product->id }}">
						<i class="fa fa-minus"></i>
					</button>
				</div>
				
				@if (isset($inCart[$product->id]))
				<button class="default__button cart__button added-cart__button text-uppercase" data-product-id="{{ $product->id }}" data-adding-text="{{ __('default.to_cart') }}" data-added-text="{{ __('default.added') }}">
					<span>{{ __('default.added') }}</span>
					<i class="fa fa-spin fa-refresh" style="display: none"></i>
				</button>
				@elseif ($product->productStatus->title === 'not-available')
				<button class="default__button cart__button availability-cart__button text-uppercase" data-product-id="{{ $product->id }}">
					<span>{{ __('default.report_availability') }}</span>
					<i class="fa fa-spin fa-refresh" style="display: none"></i>
				</button>
				@else
				<button class="default__button cart__button add-cart__button text-uppercase" data-product-id="{{ $product->id }}" data-adding-text="{{ __('default.to_cart') }}" data-added-text="{{ __('default.added') }}">
					<span>{{ __('default.to_cart') }}</span>
					<i class="fa fa-spin fa-refresh" style="display: none"></i>
				</button>
				@endif
			</form>
				
			@if(isset($payback) && !empty($payback))
				<div class='tags__container tag-payback__icon'>
					{{ __('default.payback') }} {{ $payback }} {{ __('default.days') }}
				</div>
			@endif

			<div class="tabs__container product__description">
				<div class="tab-control__container">
					<button class="tab__item padding__collapse active" data-id="1">
						{{ __('default.description') }}
					</button>

					<button class="tab__item padding__collapse" data-id="2">
						{{ __('default.characteristics') }}
					</button>

					@if (isset($video))
					<button class="tab__item padding__collapse" data-id="3">
						{{ __('default.video') }}
					</button>
					@endif
				</div>

				<div class="tab-content__container">
					<div class="content__container active font-weight-light" data-id="1">
						{!! $product->description !!}
					</div>

					<div class="content__container" data-id="2">
						<table class="attributes__container text-left">
							<tbody>
							@foreach ($product->options as $item)
								@if ($item->type->title === 'characteristic')
								<tr>
									<th>{{ $item->name }}</th>
									<td>
										<p class="margin__collapse padding__collapse">{{ $item->value }}</p>
									</td>
									</tr>
								@endif
							@endforeach
							</tbody>
						</table>
					</div>

					@if (isset($video))
					<div class="content__container" data-id="3">
						{!! $video->value !!}
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

@endsection