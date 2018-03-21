@extends('layouts.app')

@php
$deliveries = $select('App\Model\Shop\Delivery')->where('active', 1)->get();
$paymentTypes = $select('App\Model\Shop\PaymentType')->get();
$user = $select('App\Model\Base\User')->where('email', session()->get('client'))->with('attributes')->first();
//var_dump($user->attributes);
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
	    if($item->auto_price){
            $price = number_format($item->calcAutoPrice(), 2, '.', '');
        } else{
            $price = number_format($item->price, 2, '.', '');
        }
        $btcPrice = number_format($item->calcBtcPrice(), 4, '.', '');
        $btcTotal += $inCart[$item->id] * $btcPrice;
		$total += $inCart[$item->id] * $price;
	}
}


@endphp

@section('content')
<main>
<div class="main-back"></div>

<section class="content order">
<div class="container">
	<div class="row products">
		<div class="col-sm-4">
			<div>
				<i class="article-arrow"></i>
				{{ __('default.in_the_cart') }} 
				<a href="{{ url($cart->link) }}" class="product-link" data-wpel-link="internal">
					{{ $count }}
				</a>
			</div>
		</div>

		<div class="article-content col-sm-8">
			<div class="article-text">
				<div>{{ __('default.total') }}
					<span class="price">
						<strong>
							<span class="woocommerce-Price-amount amount">
								<span class="woocommerce-Price-currencySymbol">&#36;</span>
								<span id="total-default-cost">{{ number_format($total, 2, '.', '') }}</span>
							</span>
						</strong>
					</span>

					<span class="bitcoin">
						<span id="total-bitcon-cost">{{ number_format($btcTotal, 4, '.', '') }}</span>
						<i class="fa fa-bitcoin"></i>
					</span>
				</div>
			</div>
		</div>
	</div>

	<div class="row widgets">
		<div class="woocommerce">
			<form id="checkout_form" name="checkout" method="post" class="checkout woocommerce-checkout" action="{{ url($it->link) }}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="col-sm-4" id="customer_details">
					<div class="widget wPay">
						<div class="woocommerce-billing-fields">
							<h3>{{ __('default.checkout_title') }}</h3>

							<div class="woocommerce-billing-fields__field-wrapper">
								<p class="form-row form-row-first form-group validate-required" id="billing_first_name_field" data-priority="10">
									<label for="billing_first_name" class="">
										{{ __('default.first_name_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr>
									</label>

									<input type="text" class="input-text form-control" name="first_name" id="billing_first_name" placeholder="{{ __('default.first_name_label') }}" value="@isset($user->attributes->fname) {{$user->attributes->fname}} @endisset" autocomplete="given-name" autofocus="autofocus" required />
								</p>

								<p class="form-row form-row-last form-group validate-required" id="billing_last_name_field" data-priority="20">
									<label for="billing_last_name" class="">
										{{ __('default.last_name_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr>
									</label>

									<input type="text" class="input-text form-control" name="last_name" id="billing_last_name" placeholder="{{ __('default.last_name_label') }}" value="@isset($user->attributes->lname) {{$user->attributes->lname}} @endisset" autocomplete="family-name" required />
								</p>

								<p class="form-row form-row-full validate-required woocommerce-validated" id="billing_country_field" data-priority="40">
									<label for="billing_country" class="">
										{{ __('default.country_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<select name="country" id="billing_country" class="country_to_state country_select form-control select2-hidden-accessible" autocomplete="country" required>
										<option value="">{{ __('default.select_country') }}</option>
										<option value="AZ">{{ __('common.country_AZ') }}</option>
										<option value="AM">{{ __('common.country_AM') }}</option>
										<option value="BY">{{ __('common.country_BY') }}</option>
										<option value="GE">{{ __('common.country_GE') }}</option>
										<option value="KZ">{{ __('common.country_KZ') }}</option>
										<option value="KG">{{ __('common.country_KG') }}</option>
										<option value="RU">{{ __('common.country_RU') }}</option>
										<option value="TM">{{ __('common.country_TM') }}</option>
										<option value="UZ">{{ __('common.country_UZ') }}</option>
										<option value="UA">{{ __('common.country_UA') }}</option>
									</select>

									<noscript>
										<input type="submit" name="woocommerce_checkout_update_totals" value="{{ __('default.update_country') }}" />
									</noscript>
								</p>

								<p class="form-row form-row-wide address-field form-group validate-required" data-priority="50" style="width: 100%; overflow: hidden;">
									<label for="billing_address_1" class="">
										{{ __('default.address_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<input type="text" class="input-text form-control" name="address" placeholder="{{ __('default.address_label') }}" value="@isset($user->attributes->address) {{$user->attributes->address}} @endisset" autocomplete="address-line1" required />
								</p>

								<p class="form-row form-row-wide address-field form-group validate-required" data-priority="70">
									<label for="billing_city" class="">
										{{ __('default.city_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<input type="text" class="input-text form-control" name="city" placeholder="{{ __('default.city_label') }}" autocomplete="address-level2" required />
								</p>

								<p class="form-row form-row-full validate-required validate-state" data-priority="80">
									<label for="billing_state" class="">
										{{ __('default.region_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<input type="text" class="input-text form-control" placeholder="{{ __('default.region_label') }}" name="state" autocomplete="address-level1" required />
								</p>

								<p class="form-row form-row-first form-group validate-required validate-phone" id="billing_phone_field" data-priority="100" style="width: 100%; overflow: hidden;">
									<label for="billing_phone" class="">
										{{ __('default.phone_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<input type="tel" class="input-text form-control" name="phone" id="billing_phone" placeholder="Phone {{ __('default.phone_input') }}" value="@isset($user->attributes->phone) {{$user->attributes->phone}} @endisset" autocomplete="tel" required />
								</p>

								<p class="form-row form-row-last form-group validate-required validate-email" id="billing_email_field" data-priority="110">
									<label for="billing_email" class="">
										{{ __('default.email_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<input type="email" class="input-text form-control" name="email" id="billing_email" placeholder="{{ __('default.email_label') }}" value="@isset($user->email) {{$user->email}} @endisset" autocomplete="email username" required />
								</p>
							</div>
						</div>

						<div id="order_review" class="woocommerce-checkout-review-order">
							<h3 id="order_review_heading">{{ __('default.payment_methods') }}</h3>

							<div id="payment" class="woocommerce-checkout-payment">
								<ul class="wc_payment_methods payment_methods methods">
                                    @foreach($paymentTypes as $type)
                                        <li class="payment_method">
                                            <input type="radio" class="payment-type" id="payment_method_{{$loop->iteration}}" name="payment_method" data-id="{{$type->id}}" value="{{$type->id}}"  @if($loop->first) checked='checked' @endif data-order_button_text="" style="display: inline" />

                                            <label for="payment_method_cheque">{{$type->title}}</label>

                                            <div class="payment_box" style="display:none;">
                                                <p>{{ __('default.payment_methods_description') }}</p>
                                            </div>
                                        </li>
                                    @endforeach
								</ul>

								<div class="form-row place-order">
									<noscript>Поскольку ваш браузер не поддерживает JavaScript или в нем он отключен, просим убедиться в том, что вы нажали кнопку <em>Обновить итог</em> перед регистрацией заказа. Иначе, есть риск неправильного подсчета стоимости.<br/>
										<input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="Обновить итог" />
									</noscript>

									<input type="hidden" id="_wpnonce" name="_wpnonce" value="381a54753b" /><input type="hidden" name="_wp_http_referer" value="/checkout/" />
								</div>
							</div>
						</div>

						<div class="woocommerce-shipping-fields"></div>
						<div class="woocommerce-additional-fields">
							<h3>Additional info</h3>

							<div class="woocommerce-additional-fields__field-wrapper">
								<p class="form-row form-row-full" id="order_comments_field" data-priority="">
									<textarea name="comment" class="input-text form-control" id="order_comments" placeholder="Post office number etc"  rows="2" cols="5"></textarea>
								</p>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-8">
					<div class="article-text">
						<div class="widget wDelivery">
							<h3 id="order_review_heading">Your order</h3>

							<div id="product-checkout" class="shop_table woocommerce-checkout-review-order-table">
								<div class="table-like">
									<div class="table-row table-header">
										<div class="table-cell table-cell-title">Photo</div>
										<div class="table-cell">Name</div>
										<div class="table-cell">Count</div>
										<div class="table-cell table-cell-status">Cost</div>
									</div>
                                    @foreach($products as $item)
                                        @include('parts.checkout.item_products_list', ['item' => $item, 'cart' => $inCart])
                                    @endforeach
									<div class="table-row delivery-wrap">
										<div class="table-cell">
											<span class="delivery">Delivery</span>
										</div>

										<div class="table-cell">
											<span class="delivery-status" style="word-wrap: break-word">
												<tr class="shipping">
													<td data-title="Доставка">
														<ul id="shipping_method">
                                                            @foreach($deliveries as $delivery)
                                                            <li style="display: inline-block">
																<input type="radio" name="delivery" id="shipping_method_{{$loop->iteration}}" data-index="{{$delivery->id}}" value="{{$delivery->id}}" class="shipping_method"  @if($loop->first) checked='checked' @endif/>

																<label for id="shipping_method_{{$loop->iteration}}">{{$delivery->title}}</label>
															</li>
                                                            @endforeach
															<li>
																<input type="radio" name="delivery" data-index="0"  value="0" class="shipping_method"  />

																<label for="shipping_method_0_local_pickup15">Self shipment</label>
															</li>
														</ul>
													</td>
												</tr>
											</span>
										</div>

										<div class="table-cell"></div>
										<div class="table-cell"></div>
									</div>

									<div class="table-row">
										<div class="table-cell"></div>
										<div class="table-cell"></div>
										<div class="table-cell total">
											Итого:
										</div>
										
										<div class="table-cell total-price-wrap">
											<span class="table-price">
											 	<strong>
											 		<span class="woocommerce-Price-amount amount">
											 			<span class="woocommerce-Price-currencySymbol">&#36;</span>{{ number_format($total, 2, '.', '') }}
											 		</span>
											 	</strong>
											 </span>
											 <span class="table-bitcoin">{{ number_format($btcTotal, 4, '.', '') }}<i class="fa fa-bitcoin"></i></span>
										</div>
									</div>
								</div>
							</div>

							<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Approve order" data-value="Approve order" />
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
    <div class="output-message" style="display: none"></div>

</div>
</section>
</main>
@endsection