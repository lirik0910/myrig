@php
$icon = $item->images->first();
@endphp

<div class="table-row">
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
			<input type="number" class="input-text form-control form-number qty text" step="1" min="0" max="" value="1" title="Кол-во" size="4" inputmode="numeric" />
								
			<div class="btn-count btn-count-plus">
				<i class="fa fa-plus"></i>
			</div>
									
			<div class="btn-count btn-count-minus">
				<i class="fa fa-minus"></i>
			</div>
		</span>
	</div>

	<div class="table-cell total-price">
		<span class="table-price">
			<span class="woocommerce-Price-amount amount">
				<span class="woocommerce-Price-currencySymbol">&#36;</span>2810.00
			</span>
		</span>

		<span class="table-bitcoin">0.2443
			<i class="fa fa-bitcoin"></i>
		</span>
	</div>

	<div class="table-cell table-tag">
		<div class="tag tag-order">Предзаказ</div>
	</div>

	<div class="table-cell table-close">
		<a href="https://myrig.com.ua/cart/?remove_item=d8074a35855a7f4935e3e19222d9a9eb&#038;_wpnonce=8cf40aa6ca&#038;locale=" class="remove" aria-label="Удалить эту позицию" data-product_id="4652" data-product_sku="DM_16ua" data-wpel-link="internal">
			<img src="https://myrig.com.ua/wp-content/themes/bitmain/img/close.png" alt="" />
		</a>
	</div>
</div>