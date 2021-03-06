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

@endphp

<div class="row row__container product-item__container margin__collapse">
	<div class="col-sm-4 row slider__container margin__collapse">
		<div class="border__container"></div>

		<div class="vertical-slider__container" >
			@foreach($item->images as $image)
				@php
					$imageLink = 'uploads/' . $image->name;
				@endphp
				@if(empty($image->name) || !File::exists(public_path($imageLink)))
					<div class="slide__item text-center @if($loop->first) active @endif">
						<img src="{{ $preview($defaultImage, 47, 47) }}" class="slide__icon" alt="{{ $image->name }}" title="{{ $item->title }}" />
					</div>
				@else
					<div class="slide__item text-center @if($loop->first) active @endif">
						<img src="{{ $preview($imageLink, 47, 47) }}" class="slide__icon" alt="{{ $image->name }}" title="{{ $item->title }}" />
					</div>
				@endif
			@endforeach
		</div>

		<div class="single-slider__container owl-carousel owl-theme padding__collapse">
			@foreach($item->images as $image)
				@php
					$imageLink = 'uploads/' . $image->name;
				//var_dump($imageLink, File::exists(public_path($imageLink))); die;
				@endphp

				@if(empty($image->name) || !File::exists(public_path($imageLink)))
					<div class="slide__item text-center @if($loop->first) active @endif" data-dot="<button class='slide-dot__button padding__collapse'><div class='slide-item__progress'></div></button>">
						<img src="{{ $preview($defaultImage, 300, 300) }}" class="slide__icon" alt="{{ $image->name }}" title="{{ $item->title }}" />
					</div>
				@else
					<div class="slide__item text-center @if($loop->first) active @endif" data-dot="<button class='slide-dot__button padding__collapse'><div class='slide-item__progress'></div></button>">
						<img src="{{ $preview($imageLink, 300, 300) }}" class="slide__icon" alt="{{ $image->name }}" title="{{ $item->title }}" />
					</div>
				@endif
			@endforeach
		</div>
	</div>

	<div class="col-sm-8 product-content__container margin__collapse">
		<div class="border__container"></div>
		
		<h2 class="title__container font-weight-bold">
			 <a @isset($item->page) href="{{ asset($item->page->link) }}" @endisset>{{ $item->title }}</a>
		</h2>

		<div class="tags__container @if ($item->productStatus->title === 'in-stock') tag-check__icon @elseif ($item->productStatus->title === 'pre-order') tag-order__icon  @elseif ($item->productStatus->title === 'not-available') tag-no__icon @endif">
			{{ __('common.product_status_' . str_replace(' ', '_', mb_strtolower($item->productStatus->description))) }}
		</div>

		@if(isset($item->warranty) && !empty($item->warranty))
		<div class="tags__container tag-waranty__icon">
			{{ __('default.warranty') }} {{ $item->warranty }}
		</div>
		@endif

		@if (isset($item->page) && isset($item->page->view->variables))
			@if (isset($item->page->view->variables))
			<ul class="options__list margin__collapse font-weight-light">
			@foreach ($item->page->view->variables as $field)
				@foreach ($field->variableContent as $var)
					@if ($var->page_id == $item->page->id)
					<li class="list__item">{{ $var->content }}</li>
					@endif
				@endforeach
			@endforeach
			</ul>
			@endif
		@endif

		<div class="price__container">
			<span class="default__price">
				<span class="currency__symbol">&#36;</span>
				{{ $price }}
			</span>

			<span class="bitcoin__price">
				{{ $btcPrice }}
				<i class="fa fa-bitcoin"></i>
			</span>
		</div>

		<form class="cart-count__container">
			<div class="counter__container">
				<input id="{{ 'count-products-' . $item->id }}" type="text" name="count" class="form-control form-number cart-count__input margin__collapse padding__collapse text-center" value="{{ isset($inCart[$item->id]) ? $inCart[$item->id] : 1 }}" data-id="{{ $item->id }}" />
					
				<button class="default__button plus-icon__button padding__collapse margin__collapse" data-id="{{ $item->id }}">
					<i class="fa fa-plus"></i>
				</button>

				<button class="default__button minus-icon__button padding__collapse margin__collapse" data-id="{{ $item->id }}">
					<i class="fa fa-minus"></i>
				</button>
			</div>
			
			@if (isset($inCart[$item->id]))
			<button class="default__button cart__button added-cart__button text-uppercase" data-product-id="{{ $item->id }}" data-adding-text="{{ __('default.to_cart') }}" data-added-text="{{ __('default.added') }}">
				<span>{{ __('default.added') }}</span>
				<i class="fa fa-spin fa-refresh" style="display: none"></i>
			</button>
			@elseif ($item->productStatus->title === 'not-available')
			<button class="default__button cart__button availability-cart__button text-uppercase" data-product-id="{{ $item->id }}">
				<span>{{ __('default.report_availability') }}</span>
				<i class="fa fa-spin fa-refresh" style="display: none"></i>
			</button>
			@else
			<button class="default__button cart__button add-cart__button text-uppercase" data-product-id="{{ $item->id }}" data-adding-text="{{ __('default.to_cart') }}" data-added-text="{{ __('default.added') }}">
				<span>{{ __('default.to_cart') }}</span>
				<i class="fa fa-spin fa-refresh" style="display: none"></i>
			</button>
			@endif
		</form>
		@php	
		 $sub1 = substr($payback, -1);
		 $sub2 = substr($payback, -2);
		@endphp
		@if($payback)
		<div class='tags__container tag-payback__icon'>
			{{ __('default.payback') }} {{ $payback  }} @if($sub2 == 11){{ __('default.days') }}  @elseif($sub1 == 1){{ __('default.day') }}  @elseif($sub1 > 1 and $sub1 < 5){{ __('default.two_days') }}  @else{{ __('default.days') }}@endif
		</div>
		@endif
	</div>
</div>