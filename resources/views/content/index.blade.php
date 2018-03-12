@extends('layouts.app')

@section('content')

<main>
<div class="main-back"></div>

@php
$mainProducts = $select('App\Model\Shop\Product')
	->whereHas('categories', function ($q) {
		$q->where('title', 'Base');
	})
	->with('page', 'options', 'images')
	->get();
$shop = $select('App\Model\Base\Page')
	->whereHas('view', function ($q) {
		$q->where('title', 'Shop');
	})
	->first();
@endphp

<section class="slider">
	<div class="container-fluid">
		<div class="row">
			<div class="main-slider owl-carousel owl-theme" id="mainSlider">
				@foreach ($mainProducts as $product)
				<div class="main-slide" data-dot="<span><p class='dashnav-progress'></p></span>">
					<div class="container">
						<div class="slide-text">
							<div class="title">
							{{ $product->title }}
							</div>
								
							<div class="subtitle">
							@foreach ($product->options as $option)
								@if ($option->name == 'introtext')
									{{ $option->value }}
								@endif
							@endforeach
							</div>
							
							@if ($shop)
							<a href="{{ url( $shop->link ) }}" class="btn-default" data-wpel-link="internal">{{ __('default.more_info') }}</a>
							@endif
						</div>
						
						@if (isset($product->images[0]))
						<div class="slide-img" style="background-image: url('{{ asset($product->images[0]->name ) }}')"></div>
						@endif
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</section>

<section class="banners">
	<div class="container">
		<div class="row">
		@if (isset($multi['indexLinks']))
			@foreach ($multi['indexLinks'] as $var)
			@php
				$page = $get($var['page_id']);
			@endphp
			
			<a href="{{ url($page->link) }}" class="banner col-sm-4" data-wpel-link="internal">
			
				<div class="banner-text">
					<div class="title">
						{{ $page->title }}
					</div>
					
					<div class="subtitle">
						{{ $page->introtext }}
					</div>
				</div>
				
				<div class="banner-back" style="background-image: url('{{ asset('uploads/' . $var['icon']) }}'); top: 37px; width: 80px; right: 54px; left: 300px;"></div>
			</a>
			@endforeach
		@endif
		</div>
	</div>
</section>
</main>
@endsection