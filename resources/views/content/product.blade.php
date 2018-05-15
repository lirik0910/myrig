@extends('layouts.app')

@section('content')
<main style="width: 100%">

<div class="main-back" style="position: absolute;"></div>
<script>
	var width = $(window).width(),
		cont = $('.container').outerWidth();
	var margin = (width - cont) / 2;
	var wM = cont * 33.333333 / 100 + margin;

	if (width > 767) {
		$('.main-back').css('left', wM +'px');
	}

	else {
		$('.main-back').css('left', '0px');
	}
</script>
@php
	$context = $select('App\Model\Base\Context')->where('title', $locale)->first();

$product = App\Model\Shop\Product::where('page_id', $it->id)->where('context_id', $context->id)->where('delete', 0)->with('images', 'options')->first();
//var_dump($it->id); die;
foreach ($product->options as $item) {
	if ($item->type->title === 'video') {
		$video = $item;
		break;
	}
}

if($product->auto_price){
    $autoprice = $product->calcAutoPrice();
    if(!$autoprice){
        $price = number_format($product->price, 2, '.', '');
    } else{
        $price = number_format($autoprice, 2, '.', '');
    }
} else{
    $price = number_format($product->price, 2, '.', '');
}

foreach($product->categories as $category){
    if ($category->title == 'Base'){
        $payback = new App\Http\Controllers\ProductController();
$payback = $payback->calcPayback($product->id);
    }
}

@endphp
<section class="content item">
<div class="container">

@isset($product)
<div class="article-row row">
	<div class="col-sm-4">
		<div id="isync1" class="  owl-carousel owl-theme">
			@foreach ($product->images as $item)
			<div class="product-item">
				<img width="300" height="300" src="@if(empty($item->name)){{ $preview(asset('uploads/' . 'penguins.jpg'), 300, 300) }}@else{{ $preview(asset('uploads/' . $item->name), 300, 300) }}@endif" class="attachment-medium size-medium" alt="img" title="{{ htmlentities($it->title) }}" />
			</div>
			@endforeach
		</div>

		<div id="isync2" class="visible-md owl-carousel owl-theme">
			@foreach ($product->images as $item)
			<div class="product-item">
				<img width="47" height="47" src="@if(empty($item->name)){{ $preview(asset('uploads/' . 'penguins.jpg'), 47, 47) }}@else{{ $preview(asset('uploads/' . $item->name), 47, 47) }}@endif" class="attachment-i47 size-i47" alt="img" title="{{ htmlentities($it->title) }}" />
			</div>
			@endforeach
		</div>
	</div>

	<div class="col-sm-8">
		<div class="article-text">
			<h1>{{ $product->title }}</h1>


			<div class="tag @if ($product->productStatus->title === 'in-stock') tag-check @elseif ($product->productStatus->title === 'pre-order') tag-order  @elseif ($product->productStatus->title === 'not-available') tag-no @endif">{{ __('common.product_status_' . str_replace(' ', '_', mb_strtolower($product->productStatus->description))) }}</div>

			@if(isset($product->warranty) && !empty($product->warranty))<div class="tag tag-waranty">{{ __('default.warranty') }} {{ $product->warranty }}</div>@endif
	
			<div class="single-product-price">
				<span class="woocommerce-Price-amount amount">
					<span class="woocommerce-Price-currencySymbol">&#36;</span>
					{{ $price }}
				</span>
			</div>
							
			<form class="related-form item-count__container">
				<span class="input-number ">
					<input id="{{ 'count-products-' . $product->id }}" type="text" name="count" class="form-control form-number count add-to-cart-count" value="{{ isset($inCart[$product->id]) ? $inCart[$product->id] : 1 }}" data-id="{{ $product->id }}" />

					<div class="btn-count btn-count-plus" data-id="{{ $product->id }}">
						<i class="fa fa-plus"></i>
					</div>

					<div class="btn-count btn-count-minus" data-id="{{ $product->id }}">
						<i class="fa fa-minus"></i>
					</div>
				</span>

				@if (isset($inCart[$product->id]))
					<a data-success="{{ __('default.added') }}" data-add="{{ __('default.to_cart') }}" rel="nofollow" href="#" data-id="{{ $product->id }}" class="btn-default intocarts">
						<span>{{ __('default.added') }}</span>
						<i class="fa fa-spin fa-refresh" style="display: none"></i>
					</a>
				@elseif ($product->productStatus->title === 'not-available')
					<a rel="nofollow" href="#report-availability" data-id="{{ $product->id }}" class="btn-default report-availability">
						<span>{{ __('default.report_availability') }}</span>
						<i class="fa fa-spin fa-refresh" style="display: none"></i>
					</a>
				@else
					<a data-success="{{ __('default.added') }}" data-add="{{ __('default.to_cart') }}" rel="nofollow" href="#" data-id="{{ $product->id }}" class="btn-default addtocarts">
						<span>{{ __('default.to_cart') }}</span>
						<i class="fa fa-spin fa-refresh" style="display: none"></i>
					</a>
				@endif
			</form>
			@if(isset($payback) && !empty($payback)) <div class="tag tag-payback">{{ __('default.payback') }} {{ $payback }} @if(substr((string)$payback, -1) == 1) {{ __('default.day') }} @elseif(substr((string)$payback, -1) == 2 && $locale !== 'en') {{ __('default.two_days') }} @else {{ __('default.days') }} @endif</div>@endif
			
			<div class="single-product-tabs">
				<div class="product-tab-links">
					<a href="" class="active" data-target="#description" data-wpel-link="internal">{{ __('default.description') }}</a>

					<a href="" class="" data-target="#details">
						<span class="hidden-xxs">{{ __('default.characteristics') }}</span>
						<span class="visible-xxs">{{ __('default.characteristics') }}</span>
					</a>

					@if (isset($video))
					<a href="" class="" data-target="#video">
						{{ __('default.video') }}
					</a>
					@endif
				</div>
				
				<div class="tabs-field">
					<div id="description">
						{!! $product->description !!}
					</div>
				
					<div id="details" style="">
						<table class="shop_attributes">
							<tbody>
							@foreach ($product->options as $item)
								@if ($item->type->title === 'characteristic')
								<tr>
									<th>{{ $item->name }}</th>
									<td>
										<p>{{ $item->value }}</p>
									</td>
									</tr>
								@endif
							@endforeach
							</tbody>
						</table>
					</div>
					
					@if (isset($video))
					<div id="video" style="display: block;">
						{!! $video->value !!}
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endisset

</div>
</section>


</main>
@include('parts.shop.report-availability_form')
@endsection