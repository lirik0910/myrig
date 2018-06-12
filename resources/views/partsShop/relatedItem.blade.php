@php
    if($item->auto_price){
        $autoprice = $item->calcAutoPrice();
        if(!$autoprice){
            $price = number_format($item->price, 2, '.', '');
        } else{
            $price = number_format($autoprice, 2, '.', '');
        }
    } else{
        $price = number_format($item->price, 2, '.', '');
    }

    $btcPrice = number_format($item->calcBtcPrice(), 4, '.', '');
@endphp

<div class="related-item__container" data-dot="<button class='slide-dot__button padding__collapse' data-id={{ $item->index }}><div class='slide-item__progress'></div></button>">
	<a href="{{ $item->page->link }}" class="d-block">
		<div class="title__container">{{ $item->title }}</div>

		<div class="icon__container text-center">
			@if (isset($item->images[0]))
				<img width="1000" height="1000" src="{{ $preview(asset('uploads/' . $item->images[0]->name), 215, 215) }}" class="related__icon" alt="product" />
			@endif
		</div>

		<div class="tags__container @if ($item->productStatus->title === 'in-stock') tag-check__icon @elseif ($item->productStatus->title === 'pre-order') tag-order__icon  @elseif ($item->productStatus->title === 'not-available') tag-no__icon @endif">
			{{ __('common.product_status_' . str_replace(' ', '_', mb_strtolower($item->productStatus->description))) }}
		</div>

		<div class="tags__container tag-waranty__icon">
			{{ __('default.warranty') }} {{ $item->warranty }}
		</div>

		<div class="price__container">
		<span class="default__price font-weight-bold">
			<span class="currency__symbol">&#36;</span>
			{{ number_format($price, 2, '.', '') }}
		</span>

			<span class="bitcoin__price font-weight-light text-nowrap">
			{{ $btcPrice }}
				<i class="fa fa-bitcoin"></i>
		</span>
		</div>

		<form class="cart-count__container">
			<div class="counter__container">
				<input id="{{ 'count-products-' . $item->id }}" type="text" name="count" class="form-control form-number cart-count__input default__border text-center" value="{{ isset($inCart[$item->id]) ? $inCart[$item->id] : 1 }}" data-id="{{ $item->id }}" />

				<button class="default__button plus-icon__button padding__collapse" data-id="{{ $item->id }}">
					<i class="fa fa-plus"></i>
				</button>

				<button class="default__button minus-icon__button padding__collapse" data-id="{{ $item->id }}">
					<i class="fa fa-minus"></i>
				</button>
			</div>

			@if (isset($inCart[$item->id]))
				<button class="default__button cart__button added-cart__button padding__collapse text-uppercase" data-product-id="{{ $item->id }}" data-adding-text="{{ __('default.to_cart') }}" data-added-text="{{ __('default.added') }}">
					<span>{{ __('default.added') }}</span>
					<i class="fa fa-spin fa-refresh" style="display: none"></i>
				</button>
			@elseif ($item->productStatus->title === 'not-available')
				<button class="default__button cart__button padding__collapse availability-cart__button text-uppercase" data-product-id="{{ $item->id }}">
					<span>{{ __('default.report_availability') }}</span>
					<i class="fa fa-spin fa-refresh" style="display: none"></i>
				</button>
			@else
				<button class="default__button cart__button padding__collapse add-cart__button text-uppercase" data-product-id="{{ $item->id }}" data-adding-text="{{ __('default.to_cart') }}" data-added-text="{{ __('default.added') }}">
					<span>{{ __('default.to_cart') }}</span>
					<i class="fa fa-spin fa-refresh" style="display: none"></i>
				</button>
			@endif
		</form>
	</a>
</div>