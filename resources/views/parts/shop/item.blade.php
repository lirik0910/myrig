<div class="article-row row">
    <div class="col-sm-4">
        <div class="slider-tag"></div>
        <div class="itemSlider owl-carousel owl-theme">
            @foreach($item->images as $image)
                <div class="product-item @if($loop->first) active @endif">
                    <img width="300" height="300" src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" class="attachment-medium size-medium" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1.png" data-large_image_width="1280" data-large_image_height="1280" sizes="(max-width: 300px) 100vw, 300px" />
                </div>
            @endforeach
        </div>
        <div class="itemSliderVer visible-md">
            @foreach($item->images as $image)
                <div class="product-item @if($loop->first) active @endif">
                    <img width="47" height="47" src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg" class="attachment-i47 size-i47" alt="" title="" data-src="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg" data-large_image="https://myrig.com.ua/wp-content/uploads/2018/01/dm_2-1-47x47.jpg" data-large_image_width="1280" data-large_image_height="1280" sizes="(max-width: 47px) 100vw, 47px" />
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
			
			<div class="tag tag-order">Предзаказ</div>
			<div class="tag tag-waranty" >Расширенная гарантия 180 дней</div>

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
					value="{{ isset($inCart[$item->id]) ? $inCart[$item->id] : 1 }}" />
					
					<div class="btn-count btn-count-plus" data-id="{{ $item->id }}">
						<i class="fa fa-plus"></i>
					</div>

					<div class="btn-count btn-count-minus" data-id="{{ $item->id }}">
						<i class="fa fa-minus"></i>
					</div>
				</span>

				<a data-success="Добавлено!" rel="nofollow" href="#" data-id="{{ $item->id }}" class="btn-default addtocarts">{{ __('shop.to_cart') }}</a>
			</form>
			
			<div class='tag tag-payback'>Окупаемость 201 день</div>
		</div>
	</div>
</div>