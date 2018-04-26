@extends('layouts.app')

@section('content')

<main>
<div class="main-back"></div>

@php
$shop = $select('App\Model\Base\Page')
	->whereHas('view', function ($q) {
		$q->where('title', 'Shop');
	})
	->first();
//var_dump($multi); die;
@endphp

<section class="slider">
	<div class="container-fluid">
		<div class="row">
			<div class="main-slider owl-carousel owl-theme" id="mainSlider">
			@if (isset($multi['indexSlider']))
				@foreach ($multi['indexSlider'] as $slide)

				<div class="main-slide" data-dot="<span><p class='dashnav-progress'></p></span>">
					<div class="container">
						<div class="slide-text">
							<div class="title">
							{{ $slide['header'] }}
							</div>
								
							<div class="subtitle">
							{!! $slide['content'] !!}
							</div>
							
							@if ($shop)
							<a href="{{ url( $slide['link'] ) }}" class="btn-default" data-wpel-link="internal">{{ __('default.more_info') }}</a>
							@endif
						</div>
						
						<div class="slide-img" style="background-image: url('{{ $preview(asset('uploads/' . $slide['icon']), 1024, 941) }}')"></div>
					</div>
				</div>
				@endforeach
			@endif
			</div>
		</div>
	</div>
</section>

<section class="banners">
	<div class="container">
		<div class="row">
		@if (isset($multi['indexLinks']))
			@foreach ($multi['indexLinks'] as $var)
			
			<a href="{{ url($var['link']) }}" class="banner col-sm-4" data-wpel-link="internal">
			
				<div class="banner-text">
					<div class="title">
						{{ $var['header'] }}
					</div>
					
					<div class="subtitle">
						{{ $var['content'] }}
					</div>
				</div>

				<div class="banner-back" style="background-image: url('{{ $preview(asset('uploads/' . $var['icon']), 80, 100) }}'); top: 37px; width: 80px; right: 54px; left: 300px;"></div>
			</a>
			@endforeach
		@endif
		</div>
	</div>
</section>
</main>
@endsection