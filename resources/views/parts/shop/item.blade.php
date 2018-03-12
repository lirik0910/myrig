@php
	$options = $item->options->groupBy('name')->toArray();
@endphp
<div class="article-row row">
	<div class="col-sm-4">
		<div class="slider-tag"></div>
		<div class="itemSlider owl-carousel owl-theme">
			@foreach($item->images as $image)
				<div class="product-item @if($loop->first) active @endif">
					<img width="300" height="300" src="{{ asset('uploads/' . $image->name) }}" class="attachment-medium size-medium" alt="" title="" data-src="{{ asset('uploads/' . $image->name) }}" data-large_image="{{ asset('uploads/' . $image->name) }}" data-large_image_width="1280" data-large_image_height="1280" sizes="(max-width: 300px) 100vw, 300px" />
				</div>
			@endforeach
		</div>
		<div class="itemSliderVer visible-md">
			@foreach($item->images as $image)
				<div class="product-item @if($loop->first) active @endif">
					<img width="47" height="47" src="{{ asset('uploads/' . $image->name) }}" class="attachment-i47 size-i47" alt="" title="" data-src="{{ asset('uploads/' . $image->name) }}" data-large_image="{{ asset('uploads/' . $image->name) }}" data-large_image_width="1280" data-large_image_height="1280" sizes="(max-width: 47px) 100vw, 47px" />
				</div>
			@endforeach
		</div>
	</div>

	<div class="col-sm-8">
		<div class="article-text">
			<h2>
				<a href="{{ asset($item->page->link) }}" data-wpel-link="internal">
					{{ $item->title }}
				</a>
			</h2>

			@if ($item->productStatus->title === 'in-stock')
				<div class="tag tag-check">{{ $item->productStatus->description }}</div>
			@elseif ($item->productStatus->title === 'pre-order')
				<div class="tag tag-order">{{ $item->productStatus->description }}</div>
			@elseif ($item->productStatus->title === 'not-available')
				<div class="tag tag-no">{{ $item->productStatus->description }}</div>
			@endif

			<div class="tag tag tag-waranty">{{ __('default.warranty') }} {{ $item->warranty }}</div>

			@if (isset($item->page->view->variables))
				@if (isset($item->page->view->variables))
				<div>
					<ul>
					@foreach ($item->page->view->variables as $field)
						@foreach ($field->variableContent as $var)
							@if ($var->page_id == $item->page->id)
							<li>{{ $var->content }}</li>
							@endif
						@endforeach
					@endforeach
					</ul>
				</div>
				@endif
			@endif

			<div class="single-product-price item-cost__container">
				<span class="woocommerce-Price-amount amount">
					<span class="woocommerce-Price-currencySymbol">&#36;</span>
					{{ number_format($item->price, 2, '.', '') }}
				</span>

				<span class="table-bitcoin">0.2485
					<i class="fa fa-bitcoin"></i>
				</span>
			</div>

			<form class="related-form item-count__container">
				<span class="input-number ">
					<input id="{{ 'count-products-' . $item->id }}" type="text" name="count" class="form-control form-number count add-to-cart-count"
					value="{{ isset($inCart[$item->id]) ? $inCart[$item->id] : 1 }}" data-id="{{ $item->id }}" />
					
					<div class="btn-count btn-count-plus" data-id="{{ $item->id }}">
						<i class="fa fa-plus"></i>
					</div>

					<div class="btn-count btn-count-minus" data-id="{{ $item->id }}">
						<i class="fa fa-minus"></i>
					</div>
				</span>

				@if (isset($inCart[$item->id]))
					<a data-success="{{ __('default.added') }}" data-add="{{ __('default.to_cart') }}" rel="nofollow" href="#" data-id="{{ $item->id }}" class="btn-default intocarts">
						<span>{{ __('default.added') }}</span>
						<i class="fa fa-spin fa-refresh" style="display: none"></i>
					</a>
				@else
					<a data-success="{{ __('default.added') }}" data-add="{{ __('default.to_cart') }}" rel="nofollow" href="#" data-id="{{ $item->id }}" class="btn-default addtocarts">
						<span>{{ __('default.to_cart') }}</span>
						<i class="fa fa-spin fa-refresh" style="display: none"></i>
					</a>
				@endif
			</form>
			
			<div class='tag tag-payback'>{{ __('default.payback') }}</div>
		</div>
	</div>
</div>