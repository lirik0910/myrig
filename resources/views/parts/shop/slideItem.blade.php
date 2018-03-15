<a href="{{ asset($item->page->link) }}" class="related-item" data-wpel-link="internal">
	<div class="related-title">{{ $item->title }}</div>
	
	<div class="related-img">
		@if (isset($item->images[0]))
		<img width="1000" height="1000" src="{{ asset('uploads/' . $item->images[0]->name) }}" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="previw" />
		@endif
	</div>

	@if ($item->productStatus->title === 'in-stock')
		<div class="tag tag-check">{{ $item->productStatus->description }}</div>
	@elseif ($item->productStatus->title === 'pre-order')
		<div class="tag tag-order">{{ $item->productStatus->description }}</div>
	@elseif ($item->productStatus->title === 'not-available')
		<div class="tag tag-no">{{ $item->productStatus->description }}</div>
	@endif

	<div class="tag tag tag-waranty">{{ __('default.warranty') }} {{ $item->warranty }}</div>

	<div class="related-price">
		<div>
			<span class="woocommerce-Price-amount amount">
				<span class="woocommerce-Price-currencySymbol">&#36;</span>
				{{ number_format($item->price, 2, '.', '') }}
			</span>
		
			<span class="table-bitcoin">0.0192
				<i class="fa fa-bitcoin"></i>
			</span>
		</div>
		
		<div class="note"></div>
		<div class="tag tag-info"></div>
	</div>

	<form class="related-form item-count__container">
		<span class="input-number ">
			<input id="{{ 'count-products-' . $item->id }}" type="text" name="count" class="form-control form-number count add-to-cart-count" value="{{ isset($inCart[$item->id]) ? $inCart[$item->id] : 1 }}" data-id="{{ $item->id }}" />
					
			<div class="btn-count btn-count-plus" data-id="{{ $item->id }}">
				<i class="fa fa-plus"></i>
			</div>

			<div class="btn-count btn-count-minus" data-id="{{ $item->id }}">
				<i class="fa fa-minus"></i>
			</div>
		</span>

		@if (isset($inCart[$item->id]))
			<p data-success="{{ __('shop.added') }}" data-add="{{ __('default.to_cart') }}" data-id="{{ $item->id }}" class="btn-default intocarts">
				<span>{{ __('default.added') }}</span>
				<i class="fa fa-spin fa-refresh" style="display: none"></i>
			</p>
		@elseif ($item->productStatus->title === 'not-available')
			<p class="btn-default disabled">
				<span>{{ __('default.added') }}</span>
				<i class="fa fa-spin fa-refresh" style="display: none"></i>
			</p>
		@else
			<p data-success="{{ __('default.added') }}" data-add="{{ __('default.to_cart') }}" data-id="{{ $item->id }}" class="btn-default addtocarts">
				<span>{{ __('default.to_cart') }}</span>
				<i class="fa fa-spin fa-refresh" style="display: none"></i>
			</p>
		@endif
	</form>
</a>