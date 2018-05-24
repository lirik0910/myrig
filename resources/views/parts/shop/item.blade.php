@php
	$options = $item->options->groupBy('name')->toArray();

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

	foreach($item->categories as $category){
		if ($category->title == 'Base'){
			$payback = new App\Http\Controllers\ProductController();
			$payback = $payback->calcPayback($item->id);
		}
	}

	if($locale == 'en'){
		$default_img = 'default/eng.no-photo.jpg';
	} else{
		$default_img = 'default/ru.no-photo.jpeg';
	}

@endphp
<div class="article-row row">
	<div class="col-sm-4">
		<div class="slider-tag"></div>
		@if(count($item->images) > 0)
			<div class="itemSlider owl-carousel owl-theme">
				@foreach($item->images as $image)
					<div class="product-item @if($loop->first) active @endif">
						<img width="300" height="300" src="@if(empty($image->name) or !file_exists(public_path() . '/uploads/' . $image->name)){{ $preview(asset('uploads/' . $default_img), 300, 300) }}@else{{ $preview(asset('uploads/' . $image->name), 300, 300) }}@endif" class="attachment-medium size-medium" alt="" title="" data-src="@if(empty($image->name) or !file_exists(public_path() . '/uploads/' . $image->name)){{ $preview(asset('uploads/' . $default_img), 300, 300) }}@else{{ $preview(asset('uploads/' . $image->name), 300, 300) }}@endif" data-large_image="@if(empty($image->name) or !file_exists(public_path() . '/uploads/' . $image->name)){{ asset('uploads/' . $default_img) }}@else{{ asset('uploads/' . $image->name) }}@endif" data-large_image_width="1280" data-large_image_height="1280" sizes="(max-width: 300px) 100vw, 300px" />
					</div>
				@endforeach
			</div>
			<div class="itemSliderVer visible-md">
				@foreach($item->images as $image)
					<div class="product-item @if($loop->first) active @endif">
						<img width="47" height="47" src="@if(empty($image->name) or !file_exists(public_path() . '/uploads/' . $image->name)){{ $preview(asset('uploads/' . $default_img), 47, 47) }}@else{{ $preview(asset('uploads/' . $image->name), 47, 47) }}@endif" class="attachment-i47 size-i47" alt="" title="" data-src="@if(empty($image->name) or !file_exists(public_path() . '/uploads/' . $image->name)){{ $preview(asset('uploads/' . $default_img), 47, 47) }}@else{{ $preview(asset('uploads/' . $image->name), 47, 47) }}@endif" data-large_image="@if(empty($image->name) or !file_exists(public_path() . '/uploads/' . $image->name)){{ asset('uploads/' . $default_img) }}@else{{ asset('uploads/' . $image->name) }}@endif" data-large_image_width="1280" data-large_image_height="1280" sizes="(max-width: 47px) 100vw, 47px" />
					</div>
				@endforeach
			</div>
		@else
			<div class="itemSlider owl-carousel owl-theme">
				<div class="product-item active">
					<img width="300" height="300" src="{{ $preview(asset('uploads/' . $default_img), 300, 300) }}" class="attachment-medium size-medium" alt="" title="" data-src="{{ $preview(asset('uploads/' . $default_img), 300, 300) }}" data-large_image="{{ $preview(asset('uploads/' . $default_img), 300, 300) }}" data-large_image_width="1280" data-large_image_height="1280" sizes="(max-width: 300px) 100vw, 300px" />
				</div>
			</div>
			<div class="itemSliderVer visible-md">
				<div class="product-item active">
					<img width="47" height="47" src="{{ $preview(asset('uploads/' . $default_img), 47, 47) }}" class="attachment-i47 size-i47" alt="" title="" data-src="{{ $preview(asset('uploads/' . $default_img), 47, 47) }}" data-large_image="{{ $preview(asset('uploads/' . $default_img), 47, 47) }}" data-large_image_width="1280" data-large_image_height="1280" sizes="(max-width: 47px) 100vw, 47px" />
				</div>
			</div>
		@endif
	</div>

	<div class="col-sm-8">
		<div class="article-text">
			<h2>
				 <a href="{{ asset($item->page->link) }}" data-wpel-link="internal">
					{{ $item->title }}
				</a>
			</h2>


			<div class="tag @if ($item->productStatus->title === 'in-stock') tag-check @elseif ($item->productStatus->title === 'pre-order') tag-order  @elseif ($item->productStatus->title === 'not-available') tag-no @endif">{{ __('common.product_status_' . str_replace(' ', '_', mb_strtolower($item->productStatus->description))) }}</div>

			@if(isset($item->warranty) && !empty($item->warranty))<div class="tag tag tag-waranty">{{ __('default.warranty') }} {{ $item->warranty }}</div>@endif

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
					{{ $price }}
				</span>

				<span class="table-bitcoin">{{ $btcPrice }}
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
						<span class="sp">{{ __('default.added') }}</span>
						{{-- <i class="fa fa-spin fa-refresh"></i> --}}
					</a>
				@elseif ($item->productStatus->title === 'not-available')
					<a rel="nofollow" href="#report-availability" data-id="{{ $item->id }}" class="btn-default report-availability">
						<span>{{ __('default.report_availability') }}</span>
						{{-- <i class="fa fa-spin fa-refresh"></i> --}}
					</a>
				@else
					<a data-success="{{ __('default.added') }}" data-add="{{ __('default.to_cart') }}" rel="nofollow" href="#" data-id="{{ $item->id }}" class="btn-default addtocarts">
						<span>{{ __('default.to_cart') }}</span>
						<i class="fa fa-spin fa-refresh"></i>
					</a>
				@endif
			</form>

			@if(isset($payback) && !empty($payback)) <div class="tag tag-payback">{{ __('default.payback') }} {{ $payback }} @if(substr((string)$payback, -1) == 1) {{ __('default.day') }} @elseif((int)substr((string)$payback, -1) > 1 && (int)substr((string)$payback, -1) < 5 && $locale !== 'en') {{ __('default.two_days') }} @else {{ __('default.days') }} @endif</div>@endif
		</div>
	</div>
</div>