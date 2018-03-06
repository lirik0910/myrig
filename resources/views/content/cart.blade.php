@extends('layouts.app')

@php
$products = $select('\App\Model\Shop\Product')
	->where(function ($q) use($inCart) {
			foreach ($inCart as $key => $el) {
				$q->orWhere('id', $key);
			}
			return $q;
		})->get();
@endphp

@section('content')
<main>

<div class="main-back"></div>
<section class="content cart">
	<div class="container">
		<div class="article-row row cart-holder">

			<div class="woocommerce">
				<form class="cart-field cart-form woocommerce" action="https://myrig.com.ua/cart/" method="post" data-url="https://myrig.com.ua/cart/">
					<div class="table-like">
						@foreach ($products as $item)
							@include('parts.cart.item', $item)
						@endforeach
					</div>

					<div class="table-row total-row">
									<div class="table-cell table-product-photo">
									</div>
									<div class="table-cell table-product">
									</div>
									<div class="table-cell table-middle">
										Итого            </div>
									<div class="table-cell total-price">
										<span class="table-price"><strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#36;</span>2810.00</span></strong> </span>
										<span class="table-bitcoin">0.2443<i class="fa fa-bitcoin"></i></span>
									</div>
									<div class="table-cell table-submit">
										<a href="https://myrig.com.ua/checkout/" class="btn-default" data-wpel-link="internal">Оформить заказ</a>
									</div>
									<div class="table-cell table-close">
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