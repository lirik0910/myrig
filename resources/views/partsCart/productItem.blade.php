@php
$icon = $item->images->first();
$options = $item->options->groupBy('name')->toArray();

if ($item->auto_price) {
	$price = number_format($item->calcAutoPrice(), 2, '.', '');
}
else {
	$price = number_format($item->price, 2, '.', '');
}
$btcPrice = number_format($item->calcBtcPrice(), 4, '.', '');

@endphp

<div id="{{ 'product-item__container-' . $item->id }}" class="row row__container product-item__container margin__collapse">
	<div class="col-sm-4 row slider__container margin__collapse" style="padding-left: 0; padding-right: 0">
		<div class="border__container"></div>

		<div class="product-promo__container row padding__collapse" style="margin: 0 auto">
			<div class="col-sm-6 icon__container margin__collapse padding__collapse text-center mobile-icon__container">
				<img width="100" height="100" src="{{ asset('uploads/' . $icon['name']) }}" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="" />
			</div>

			<div class="col-sm-6 title__container margin__collapse padding__collapse">
				<h3 class="font-weight-normal margin__collapse">{{ $item->title }}</h3>
			</div>
		</div>
	</div>

	<div class="col-sm-8 product-content__container mobile-product-content__container margin__collapse">
		<div class="border__container"></div>

		<div class="padding__collapse mobile-title-default__container">
			<h3 class="font-weight-normal margin__collapse">{{ $item->title }}</h3>

			<button data-id="{{ $item->id }}" class="delete__button padding__collapse margin__collapse" style="position: absolute; right: 0;">
				<img src="{{ asset('uploads/design/close.png') }}" alt="" />
			</button>
		</div>

		<div class="row margin__collapse padding__collapse" style="align-items: center;">
			<form class="col-sm-3 cart-count__container mobile-cart-count__container margin__collapse padding__collapse">
				<div class="counter__container" style="width: 128px">
					<input id="{{ 'count-products-' . $item->id }}" type="text" name="count" class="form-control form-number cart-count__input margin__collapse padding__collapse text-center" value="{{ isset($inCart[$item->id]) ? $inCart[$item->id] : 1 }}" data-id="{{ $item->id }}" data-default-price="{{ $item->price }}" data-bitcoin-price="{{ $btcPrice }}" />
							
					<button class="default__button plus-icon__button padding__collapse margin__collapse" data-id="{{ $item->id }}">
						<i class="fa fa-plus"></i>
					</button>

					<button class="default__button minus-icon__button padding__collapse margin__collapse" data-id="{{ $item->id }}">
						<i class="fa fa-minus"></i>
					</button>
				</div>
					
				@if (isset($inCart[$item->id]))
				<button class="d-none default__button cart__button added-cart__button text-uppercase" data-product-id="{{ $item->id }}" data-adding-text="{{ __('default.to_cart') }}" data-added-text="{{ __('default.added') }}">
					<span>{{ __('default.added') }}</span>
					<i class="fa fa-spin fa-refresh" style="display: none"></i>
				</button>
				@elseif ($item->productStatus->title === 'not-available')
				<button class="d-none default__button cart__button availability-cart__button text-uppercase" data-product-id="{{ $item->id }}">
					<span>{{ __('default.report_availability') }}</span>
					<i class="fa fa-spin fa-refresh" style="display: none"></i>
				</button>
				@else
				<button class="d-none default__button cart__button add-cart__button text-uppercase" data-product-id="{{ $item->id }}" data-adding-text="{{ __('default.to_cart') }}" data-added-text="{{ __('default.added') }}">
					<span>{{ __('default.to_cart') }}</span>
					<i class="fa fa-spin fa-refresh" style="display: none"></i>
				</button>
				@endif
			</form>

			<div class="col-sm-4 margin__collapse price__container padding__collapse mobile-price__container">
				<span class="font-weight-bold default-small__price">
					<span class="currency__symbol">&#36;</span>
					<span id="{{ 'default-price__container-' . $item->id }}">{{ $price }}</span>
				</span>

				<span class="bitcoin-small__price">
					<span id="{{ 'bitcoin-price__container-' . $item->id }}">{{ $btcPrice }}</span>
					<i class="fa fa-bitcoin"></i>
				</span>
			</div>

			<div class="col-sm-3 tags__container tag-check__icon margin__collapse padding__collapse" style="padding-left: 38px !important">
				{{ __('common.product_status_' . str_replace(' ', '_', mb_strtolower($item->productStatus->description))) }}
			</div>

			<button data-id="{{ $item->id }}" class="col-sm-1 delete__button padding__collapse margin__collapse d-none-991">
				<img src="{{ asset('uploads/design/close.png') }}" alt="" />
			</button>
		</div>
	</div>
</div>