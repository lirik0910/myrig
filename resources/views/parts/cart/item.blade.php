@php
$icon = $item->images->first();
$options = $item->options->groupBy('name')->toArray();

if($item->auto_price){
    $price = number_format($item->calcAutoPrice(), 2, '.', '');
} else{
    $price = number_format($item->price, 2, '.', '');
}

$btcPrice = number_format($item->calcBtcPrice(), 4, '.', '');
@endphp

<div class="table-row" id="{{ 'cart-line-item-' . $item->id }}">
	<div class="table-cell table-product-photo">
		<a href="{{ asset($it->l) }}" data-wpel-link="internal">
			<img width="100" height="100" src="{{ asset('uploads/' . $icon['name']) }}" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="" />
		</a>
	</div>
							
	<div class="table-cell table-product">
		<div>{{ $item->title }}</div>
	</div>
					
	<div class="table-cell table-middle">
		<span class="input-number">
			<input id="{{ 'count-products-' . $item->id }}" type="number" class="input-text form-control form-number qty text count add-to-cart-count server" step="1" min="0" max="" value="{{ $inCart[$item->id] }}" title="{{ __('cart.amount') }}" size="4" inputmode="numeric" data-id="{{ $item->id }}" data-price="{{ $item->price }}" />
								
			<div class="btn-count btn-count-plus server">
				<i class="fa fa-plus"></i>
			</div>
									
			<div class="btn-count btn-count-minus server">
				<i class="fa fa-minus"></i>
			</div>
		</span>
	</div>

	<div class="table-cell total-price">
		<span class="table-price">
			<span class="woocommerce-Price-amount amount">
				<span class="woocommerce-Price-currencySymbol">&#36;</span>
				<span id="{{ 'amount-default-value-' . $item->id }}">{{ number_format($price * $inCart[$item->id], 2, '.', '') }}</span>
			</span>
		</span>

		<span class="table-bitcoin">
			<span id="{{ 'amount-bitcoin-value-' . $item->id }}">{{ number_format($btcPrice * $inCart[$item->id], 4, '.', '') }}</span>
			<i class="fa fa-bitcoin"></i>
		</span>
	</div>

	@if (isset($options['status']))
	<div class="table-cell table-tag">
		<div class="tag tag-order">{{ $options['status'][0]['value'] }}</div>
	</div>
	@endif

	<div class="table-cell table-close">
		<a href="#" class="remove" aria-label="{{ __('cart.remove_product') }}" data-id="{{ $item->id }}" data-wpel-link="internal">
			<img src="{{ asset('uploads/design/close.png') }}" alt="" />
		</a>
	</div>
</div>