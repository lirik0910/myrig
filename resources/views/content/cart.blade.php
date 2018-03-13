@extends('layouts.app')

@if (count($inCart) === 0)
	<script type="text/javascript">
		window.location = "{{ url('shop')/*$get($settings['site.shop_page'])->link)*/ }}";
	</script>

@else
@php
$products = $select('\App\Model\Shop\Product')
	->where(function ($q) use($inCart) {
			foreach ($inCart as $key => $el) {
				$q->orWhere('id', $key);
			}
			return $q;
		})->get();

$total = 0;
foreach ($products as $item) {
	if (isset($inCart[$item->id])) {
		$total += $inCart[$item->id] * $item->price;
	}
}
@endphp

@section('content')
<main>

<div class="main-back"></div>
<section class="content cart">
	<div class="container">
		<div class="article-row row cart-holder">

			<div class="woocommerce">
				<form id="cart-form" class="cart-field woocommerce" method="post">
					<div class="table-like">
						@foreach ($products as $item)
							@include('parts.cart.item', $item)
						@endforeach

						<div class="table-row total-row">
							<div class="table-cell table-product-photo"></div>
							<div class="table-cell table-product"></div>
							
							<div class="table-cell table-middle">
								{{ __('default.total') }}
							</div>
							
							<div class="table-cell total-price">
								<span class="table-price">
									<strong>
										<span class="woocommerce-Price-amount amount">
											<span class="woocommerce-Price-currencySymbol">&#36;</span>
											<span id="total-default-cost">
												{{ number_format($total, 2, '.', '') }}
											</span>
										</span>
									</strong>
								</span>

								<span class="table-bitcoin">
									<span id="total-bitcon-cost">0.2443</span>
									<i class="fa fa-bitcoin"></i>
								</span>
							</div>

							<div class="table-cell table-submit">
								<a href="{{ url($get($settings['site.checkout_page'])->link) }}" class="btn-default" data-wpel-link="internal">{{ __('default.make_order') }}</a>
							</div>
							
							<div class="table-cell table-close"></div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

</section>
</main>

@endsection
@endif