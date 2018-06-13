@extends('layouts.app')

@php
$products = $select('\App\Model\Shop\Product')
	->where(function ($q) use($inCart) {
		foreach ($inCart as $key => $el) {
			$q->orWhere('id', $key);
		}
		return $q;
	})->get();

$total = 0;
$btcTotal = 0;

foreach ($products as $item) {
	if (isset($inCart[$item->id])) {
		if($item->auto_price) {
			$price = number_format($item->calcAutoPrice(), 2, '.', '');
		}
		else {
			$price = number_format($item->price, 2, '.', '');
		}

		$btcPrice = number_format($item->calcBtcPrice(), 4, '.', '');
		$btcTotal += $inCart[$item->id] * $btcPrice;
		$total += $inCart[$item->id] * $price;
	}
}
@endphp

@section('content')

<div id="dark__container" class="dark__container"></div>

<div class="products__container default__container">
	@foreach ($products as $item)
		@include('partsCart.productItem', $item)
	@endforeach

	<div class="row row__container product-item__container margin__collapse">
		<div class="col-sm-4 row slider__container margin__collapse padding__collapse">
			<div class="border__container"></div>
		</div>

		<div class="col-sm-8 product-content__container margin__collapse">
			<div class="border__container"></div>

			<div id="cart-amount__container" class="price__container cart-amount__containrt padding__collapse">
				<span class="amount__label text-uppercase font-weight-light">
					{{ __('default.total') }}
				</span>
				
				<span class="font-weight-bold default-small__price" style="font-size: 24px">
					<span class="currency__symbol">&#36;</span>
					<span id="default-price__container">{{ number_format($total, 2, '.', '') }}</span>
				</span>

				<span class="bitcoin-small__price">
					<span id="bitcoin-price__container">{{ number_format($btcTotal, 4, '.', '') }}</span>
					<i class="fa fa-bitcoin"></i>
				</span>

				<a href="/checkout" class="default__button text-uppercase order__button">
					{{ __('default.make_order') }}
				</a>
			</div>
		</div>
	</div>
</div>

@endsection