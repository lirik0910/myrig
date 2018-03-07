@extends('layouts.app')

@php 
$products = $select('\App\Model\Shop\Product')->with('page', 'options', 'images')->get();
//var_dump($products); die;
@endphp

@section('content')
<main>
<div class="main-back"></div>
	
<section class="content item">
	<div class="container">
		<div class="clearfix" style="clear: both"></div>
		@foreach($products as $item)
			@if (isset($item->page))
				@include('parts.shop.item', $item)
			@endif
		@endforeach
	</div>
</section>
</main>
@endsection