@extends('layouts.app')

@php 
$products = $select('\App\Model\Shop\Product')->get();
@endphp

@section('content')
<main>

<div class="main-back"></div>
	
<section class="content item">
	<div class="container">
		<div class="clearfix" style="clear: both"></div>

		@foreach($products as $item)
			@include('parts.shop.item', $item);
		@endforeach
	</div>
</section>


</main>
@endsection