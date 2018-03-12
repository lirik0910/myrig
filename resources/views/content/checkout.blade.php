@extends('layouts.app')

@php 
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
foreach ($products as $item) {
	if (isset($inCart[$item->id])) {
		$total += $inCart[$item->id] * $item->price;
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
						<span id="total-bitcon-cost">6.5626</span>
						<i class="fa fa-bitcoin"></i>
					</span>
				</div>
			</div>
		</div>
	</div>

	<div class="row widgets">
		<div class="woocommerce">
			<form name="checkout" method="post" class="checkout woocommerce-checkout" action="{{ url($it->link) }}" enctype="multipart/form-data">
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

									<input type="text" class="input-text form-control" name="first_name" id="billing_first_name" placeholder="{{ __('default.first_name_label') }}" autocomplete="given-name" autofocus="autofocus" />
								</p>

								<p class="form-row form-row-last form-group validate-required" id="billing_last_name_field" data-priority="20">
									<label for="billing_last_name" class="">
										{{ __('default.last_name_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr>
									</label>

									<input type="text" class="input-text form-control" name="last_name" id="billing_last_name" placeholder="{{ __('default.last_name_label') }}" autocomplete="family-name" />
								</p>

								<p class="form-row form-row-full validate-required woocommerce-validated" id="billing_country_field" data-priority="40">
									<label for="billing_country" class="">
										{{ __('default.country_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<select name="country" id="billing_country" class="country_to_state country_select form-control select2-hidden-accessible" autocomplete="country">
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

									<input type="text" class="input-text form-control" name="address" placeholder="{{ __('default.address_label') }}" autocomplete="address-line1" />
								</p>

								<p class="form-row form-row-wide address-field form-group validate-required" data-priority="70">
									<label for="billing_city" class="">
										{{ __('default.city_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<input type="text" class="input-text form-control" name="city" placeholder="{{ __('default.city_label') }}" autocomplete="address-level2" />
								</p>

								<p class="form-row form-row-full validate-required validate-state" data-priority="80">
									<label for="billing_state" class="">
										{{ __('default.region_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<input type="text" class="input-text form-control" placeholder="{{ __('default.region_label') }}" name="state" autocomplete="address-level1" />
								</p>

								<p class="form-row form-row-first form-group validate-required validate-phone" id="billing_phone_field" data-priority="100" style="width: 100%; overflow: hidden;">
									<label for="billing_phone" class="">
										{{ __('default.phone_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<input type="tel" class="input-text form-control" name="phone" id="billing_phone" placeholder="{{ __('default.phone_input') }}" autocomplete="tel" />
								</p>

								<p class="form-row form-row-last form-group validate-required validate-email" id="billing_email_field" data-priority="110">
									<label for="billing_email" class="">
										{{ __('default.email_label') }}
										<abbr class="required" title="{{ __('default.required') }}">*</abbr></label>

									<input type="email" class="input-text form-control" name="email" id="billing_email" placeholder="{{ __('default.email_label') }}" autocomplete="email username" />
								</p>
							</div>
						</div>

						<div id="order_review" class="woocommerce-checkout-review-order">
							<h3 id="order_review_heading">{{ __('default.payment_methods') }}</h3>

							<div id="payment" class="woocommerce-checkout-payment">
								<ul class="wc_payment_methods payment_methods methods">
									<li class="wc_payment_method payment_method_cheque">
										<input id="payment_type" type="radio" class="input-radio" name="payment_method" value="cheque"  checked='checked' data-order_button_text="" />

										<label for="payment_method_cheque">Bitcoin</label>

										<div class="payment_box payment_method_cheque">
											<p>{{ __('default.payment_methods_description') }}</p>
										</div>
									</li>

									<li class="wc_payment_method payment_method_cod">
										<input id="payment_method_cod" type="radio" class="input-radio" name="payment_method" value="cod"  data-order_button_text="" />

										<label for="payment_method_cod">Оплата наличными </label>

										<div class="payment_box payment_method_cod" style="display:none;">
											<p>С вами свяжется наш менеджер для уточнения деталей</p>
										</div>
									</li>
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
							<h3>Доп. информация</h3>

							<div class="woocommerce-additional-fields__field-wrapper">
								<p class="form-row form-row-full" id="order_comments_field" data-priority="">
									<textarea name="order_comments" class="input-text form-control" id="order_comments" placeholder="В примечании указывайте номер отделения (Для Новой Почты)"  rows="2" cols="5"></textarea>
								</p>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-8">
					<div class="article-text">
						<div class="widget wDelivery">
							<h3 id="order_review_heading">Ваш заказ</h3>

							<div id="product-checkout" class="shop_table woocommerce-checkout-review-order-table">
								<div class="table-like">
									<div class="table-row table-header">
										<div class="table-cell table-cell-title">Фото</div>
										<div class="table-cell">Название</div>
										<div class="table-cell">Кол-во</div>
										<div class="table-cell table-cell-status">Стоимость</div>
									</div>

									<div class="table-row">
										<div class="table-cell foto">
											<img src="https://myrig.com.ua/wp-content/uploads/2018/01/dragonmint-1-100x100.png" title="">
										</div>

										<div class="table-cell product">
											<a href="https://myrig.com.ua/product/dragonmint-16-th-s-2/" data-wpel-link="internal">DRAGONMINT T1 16TH/s</a>

											<span class="hidden-md">Цена товара</span>
											<span class="table-price">$2810</span>

											<span class="table-bitcoin">0.3248
												<i class="fa fa-bitcoin"></i>
											</span>
										</div>

										<div class="table-cell number">
											<span class="hidden-md">Количество</span>
											<span> 17 шт.</span>
										</div>

										<div class="table-cell number-price">
											<span class="hidden-md">Стоимость</span>
											<span class="table-price">$47770</span>
											<span class="table-bitcoin">5.5222
												<i class="fa fa-bitcoin"></i>
											</span>
										</div>
									</div>

									<div class="table-row">
										<div class="table-cell foto">
											<img src="https://myrig.com.ua/wp-content/uploads/2018/01/D3-100x100.png" title="">
										</div>

										<div class="table-cell product">
											<a href="https://myrig.com.ua/product/antminer-d3-19-3gh-s/" data-wpel-link="internal">ANTMINER D3 19.3GH/s</a>
											<span class="hidden-md">Цена товара</span>
											<span class="table-price">$1500</span>
											<span class="table-bitcoin">0.1734<i class="fa fa-bitcoin"></i></span>
										</div>

										<div class="table-cell number">
											<span class="hidden-md">Количество</span>
											<span> 2 шт.</span>
										</div>

										<div class="table-cell number-price">
											<span class="hidden-md">Стоимость</span>
											<span class="table-price">$3000</span>
											<span class="table-bitcoin">0.3468<i class="fa fa-bitcoin"></i></span>
										</div>
									</div>

									<div class="table-row">
										<div class="table-cell foto">
											<img src="https://myrig.com.ua/wp-content/uploads/2018/01/S9-100x100.png" title="">
										</div>

										<div class="table-cell product">
											<a href="https://myrig.com.ua/product/antminer-s9-13-5th-s/" data-wpel-link="internal">ANTMINER S9 13.5TH/s</a>

											<span class="hidden-md">Цена товара</span>
											<span class="table-price">$3000</span>
											<span class="table-bitcoin">0.3468<i class="fa fa-bitcoin"></i></span>
										</div>

										<div class="table-cell number">
											<span class="hidden-md">Количество</span>
											<span>2 шт.</span>
										</div>

										<div class="table-cell number-price">
											<span class="hidden-md">Стоимость</span>
											<span class="table-price">$6000</span>
											<span class="table-bitcoin">0.6936
												<i class="fa fa-bitcoin"></i>
											</span>
										</div>
									</div>

									<div class="table-row delivery-wrap">
										<div class="table-cell">
											<span class="delivery">Доставка</span>
										</div>

										<div class="table-cell">
											<span class="delivery-status">
												<tr class="shipping">
													<td data-title="Доставка">
														<ul id="shipping_method">
															<li>
																<input type="radio" name="shipping_method[0]" data-index="0" id="shipping_method_0_booster_custom_shipping_w_zones16" value="booster_custom_shipping_w_zones:16" class="shipping_method"  checked='checked' />

																<label for="shipping_method_0_booster_custom_shipping_w_zones16">Новая Почта</label>
															</li>

															<li>
																<input type="radio" name="shipping_method[0]" data-index="0" id="shipping_method_0_local_pickup15" value="local_pickup:15" class="shipping_method"  />

																<label for="shipping_method_0_local_pickup15">Самовывоз</label>
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
											 			<span class="woocommerce-Price-currencySymbol">&#36;</span>56770.00
											 		</span>
											 	</strong>
											 </span>
											 <span class="table-bitcoin">6.5626<i class="fa fa-bitcoin"></i></span>
										</div>
									</div>
								</div>
							</div>

							<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Подтверждаю заказ" data-value="Подтверждаю заказ" />
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