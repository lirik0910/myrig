@extends('layouts.app')

@php
$deliveries = $select('App\Model\Shop\Delivery')->where('active', 1)->get();
$paymentTypes = $select('App\Model\Shop\PaymentType')->get();
if(isset($_SESSION['client'])){
	$client_email = $_SESSION['client'];
} else{
	$client_email = '';
}

$user = $select('App\Model\Base\User')->where('email', $client_email)->with('attributes')->first();
$count = 0;
foreach ($inCart as $i) {
	$count += (int) $i;
}

$cart = $select('App\Model\Base\Page')
	->whereHas('view', function ($q) {
		$q->where('title', 'Cart');
	})
	->first();

$products = $select('\App\Model\Shop\Product')
	->where(function ($q) use($inCart) {
			foreach ($inCart as $key => $el) {
				$q->orWhere('id', $key);
			}
			return $q;
		})->get();

$total = 0;
$btcTotal = 0;

foreach ($products as $item) {
	if (isset($inCart[$item->id])) {
		if($item->auto_price) {
			$price = number_format($item->calcAutoPrice(), 2, '.', '');
		}
		else {
			$price = number_format($item->price, 2, '.', '');
		}

		$btcPrice = number_format($item->calcBtcPrice(), 4, '.', '');
		$btcTotal += $inCart[$item->id] * $btcPrice;
		$total += $inCart[$item->id] * $price;
	}
}


@endphp

@section('content')

<div id="dark__container" class="dark__container"></div>

<div class="products__container default__container checkout__container">
	<div class="row row__container product-item__container margin__collapse" style="padding-bottom: 8px;">
		<div class="col-sm-4 row slider__container margin__collapse padding__collapse">
			<div class="border__container"></div>

			<div class="form-products__container">
				<i class="article-arrow__icon"></i>

				<span style="height: 115px; line-height: 115px;" class="d-inline-block">
					{{ __('default.in_the_cart') }}
				
					<a href="{{ url($cart->link) }}" class="default__link products-count__link font-weight-bold">
						{{ $count }}
					</a>
				</span>
			</div>
		</div>

		<div class="col-sm-8 product-content__container margin__collapse amount__container" style="background-color: #F2F2F2">
			<div class="border__container"></div>

			<div class="price__container cart-amount__containrt padding__collapse">
				<span class="amount__label text-uppercase font-weight-light">
					{{ __('default.total') }}
				</span>
				
				<span class="font-weight-bold default-small__price" style="font-size: 24px">
					<span class="currency__symbol">&#36;</span>
					<span id="default-price__container">{{ number_format($total, 2, '.', '') }}</span>
				</span>

				<span class="bitcoin-small__price">
					<span id="bitcoin-price__container">{{ number_format($btcTotal, 4, '.', '') }}</span>
					<i class="fa fa-bitcoin"></i>
				</span>
			</div>
		</div>
	</div>

	<form id="post-checkout__form" action="/checkout" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<div class="row row__container product-item__container margin__collapse">
			<div class="col-sm-4 row slider__container margin__collapse" style="padding: 42px 0 0">
				<div class="border__container"></div>

				<h3 class="form-title__container padding__collapse">{{ __('default.checkout_title') }}</h3>
				<div class="checkout__form">
					<input type="text" id="first-name__input" class="field__input field__grey" name="first_name" value="@isset($user->attributes->fname) {{ $user->attributes->fname }} @endisset" required placeholder="{{ __('default.first_name_label') }}" />

					<input type="text" id="last-name__input" class="field__input field__grey" name="last_name" placeholder="{{ __('default.last_name_label') }}" value="@isset($user->attributes->lname) {{$user->attributes->lname}} @endisset" required />

					<select name="country" id="country__select" class="country__select d-none field__grey">
						<option value="">{{ __('default.select_country') }}</option>
						<option value="AZ">{{ __('common.country_AZ') }}</option>
						<option value="AM">{{ __('common.country_AM') }}</option>
						<option value="BY">{{ __('common.country_BY') }}</option>
						<option value="GE">{{ __('common.country_GE') }}</option>
						<option value="KZ">{{ __('common.country_KZ') }}</option>
						<option value="KG">{{ __('common.country_KG') }}</option>
						@if($locale != 'en') <option value="RU">{{ __('common.country_RU') }}</option>@endif
						<option value="TM">{{ __('common.country_TM') }}</option>
						<option value="UZ">{{ __('common.country_UZ') }}</option>
						<option value="UA">{{ __('common.country_UA') }}</option>
					</select>

					<input type="text" class="field__input field__grey" name="address" placeholder="{{ __('default.address_label') }}" value="@isset($user->attributes->address) {{$user->attributes->address}} @endisset" required />

					<div class="row margin__collapse padding__collapse">
						<div class="col-sm-6 margin__collapse" style="padding: 0 18px 0 0">
							<input type="text" class="field__input field__grey d-block" name="city" placeholder="{{ __('default.city_label') }}" required />
						</div>

						<div class="col-sm-6 margin__collapse padding__collapse">
							<input type="text" class="field__input field__grey d-block" placeholder="{{ __('default.region_label') }}" name="state" required />
						</div>

						<div class="col-sm-6 margin__collapse" style="padding: 0 18px 0 0">
							<input type="tel" class="field__input field__grey d-block" name="phone" placeholder="Phone {{ __('default.phone_input') }}" value="@isset($user->attributes->phone) {{$user->attributes->phone}} @endisset" required />
						</div>

						<div class="col-sm-6 margin__collapse padding__collapse">
							<input type="email" class="field__input field__grey d-block" name="email" placeholder="{{ __('default.email_label') }}" value="@isset($user->email) {{$user->email}} @endisset" required />
						</div>
					</div>
				</div>

				<div class="payment-types__container" style="width: 100%">
					<h3 class="payment-types-title__container">{{ __('default.payment_methods') }}</h3>

					<ul class="list__container" style="padding: 12px 24px 0">
						@foreach($paymentTypes as $type)
						<li class="list__item">
							<input id="{{ 'payment-type__item-' . $type->id }}" type="radio" class="payment-type__input" name="payment_method" data-id="{{ $type->id }}" value="{{ $type->id }}" style="display: inline" @if($loop->first) checked='checked' @endif />

							<label class="font-weight-normal" for="{{ 'payment-type__item-' . $type->id }}">{{ $type->title }}</label>
						</li>
						@endforeach
					</ul>
				</div>

				<div class="additional-data__container" style="width: 100%">
					<h3 class="additional-data-title__container">{{ __('default.additional_info') }}</h3>

					<div style="padding: 18px 26px">
						<textarea name="comment" class="field__input field__grey d-block" placeholder="Post office number etc"  rows="2" cols="5"></textarea>
					</div>
				</div>
			</div>

			<div class="checkout-products__container products col-sm-8 product-content__container margin__collapse" style="padding: 42px 0 0 32px;">
				<div class="border__container"></div>

				<h3 class="title-default__container font-weight-light checkout-order__title">
					{{ __('default.your_order') }}
				</h3>

				<div class="checkout-products__container" style="border: 6px solid #DDD;">
					<table class="checkout-products__table">
						<tr>
							<th class="font-weight-light" style="padding: 8px 0">{{ __('default.photo') }}</th>
							<th class="font-weight-light" style="padding: 8px 0">{{ __('default.name') }}</th>
							<th class="font-weight-light checkout-order__count" style="padding: 8px 0">{{ __('default.count') }}</th>
							<th class="font-weight-light checkout-order__cost" style="padding: 8px 0">{{ __('default.cost') }}</th>
						</tr>

						@foreach($products as $item)
							@include('partsCheckout.productItem', ['item' => $item, 'cart' => $inCart])
						@endforeach
					</table>

					<div class="d-flex" style="border-top: 1px solid #FFF; border-bottom: 1px solid #FFF; padding: 12px 0; position: relative; align-items: center;">
						<h3 class="d-inline-block font-weight-bold delivery-title__col">{{ __('default.delivery') }}</h3>

						<div class="d-inline-block checkout-deliveries__container">
							@foreach($deliveries as $delivery)
							<div class="delivery-method__item @if($loop->first) ua-delivery__method @elseif($loop->iteration == 2 || $loop->iteration == 3) ru-delivery__method @else selfment-delivery__method @endif" style="margin: 0 4px; display: none;">
								<input id="{{ 'delivery__radio-' . $delivery->id }}" type="radio" name="delivery" value="{{ $delivery->id }}" @if($loop->iteration == 2) checked='checked' @endif />

								<label style="cursor: pointer" for="{{ 'delivery__radio-' . $delivery->id }}">{{ $delivery->title }}</label>
							</div>
							@endforeach

							<div class="without-delivery__method" style="margin: 0 4px; line-height: 20px">
								<input type="text" name="without-delivery" value="0" class="without-delivery d-none" />

								<p style="color: red;" class="padding__collapse margin__collapse">There are no shipping methods available. Please double check your address, or contact us if you need any help.</p>
							</div>
						</div>
					</div>

					<div class="text-right price__container cart-amount__containrt padding__collapse" style="margin: 12px 0; width: 100%">
						<span class="amount__label text-uppercase font-weight-light">
							{{ __('default.total') }}
						</span>
							
						<span class="font-weight-bold default-small__price" style="font-size: 24px">
							<span class="currency__symbol">&#36;</span>
							<span id="default-price__container">{{ number_format($total, 2, '.', '') }}</span>
						</span>

						<span class="bitcoin-small__price">
							<span id="bitcoin-price__container">{{ number_format($btcTotal, 4, '.', '') }}</span>
							<i class="fa fa-bitcoin"></i>
						</span>
					</div>
				</div>

				<input type="hidden" id="_wpnonce" name="_wpnonce" value="381a54753b" />
				<input type="hidden" name="_wp_http_referer" value="/checkout/" />

				<button class="default__button text-uppercase confirm__button" type="submit">{{ __('default.approve_order') }}</button>
			</div>
		</div>
	</form>
</div>

@endsection