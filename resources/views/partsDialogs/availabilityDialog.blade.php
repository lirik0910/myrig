<div id="availability__dialog" class="curtain__container">
	<div class="center__container">
		<div class="availability-dialog__container">
			<div class="title__container">
				<span>{{ __('default.report_availability_popup') }}</span>
			</div>

			<form id="availability__form" class="availability__form form__container" method="post" action="">
				<div class="report-message__container font-weight-bold">
					{{ __('default.leave_request') }}
				</div>

				<input type="hidden" name="_token" value="{{ csrf_token() }}" />

				<input id="name__field" name="name" type="text" class="field__input" placeholder="{{ __('default.name') }}" required="required" />

				<input id="email__field" name="email" type="email" class="field__input" placeholder="E-mail" required="required" />

				<input type="tel" name="phone" class="field__input" required="required" placeholder="{{ __('default.phone') }}" />

				<div id="products-select__container" class="products-select__container">
					<div class="product-item__container product-item__container-1 row padding__collapse">
						<div class="select__container col-sm-8 padding__collapse margin__collapse">
							<ul class="list__container products__list toggle__list padding__collapse margin__collapse"></ul>
							
							<div class="selected__product toggle__current"></div>

							<input type="hidden" name="products[0][id]" class="product-selected__input toggle__input prooduct-item__field" />
						</div>

						<div class="col-sm-1 padding__collapse margin__collapse"></div>

						<div class="cart-count__container col-sm-3 padding__collapse margin__collapse text-right">
							<div class="counter__container">
								<input type="text" name="products[0][count]" class="form-control form-number cart-count__input margin__collapse padding__collapse text-center input__border count-item__field" value="1" />
									
								<button class="default__button plus-icon__button padding__collapse margin__collapse">
									<i class="fa fa-plus"></i>
								</button>

								<button class="default__button minus-icon__button padding__collapse margin__collapse">
									<i class="fa fa-minus"></i>
								</button>
							</div>
						</div>
					</div>
				</div>

				<div class="products-control__container">
					<button id="add-product__button" class="add-product__button transparent__button">+</button>
					<button id="delete-product__button" class="delete-product__button transparent__button">-</button>
				</div>

				<div class="recaptcha__container">
					<div class="form-group">
						<div id="g-recaptcha" data-check="0"></div>
					</div>
					<p class="error-captcha__container text-center font-weight-bold">{{ __('default.captcha') }}</p>
				</div>

				<button type="submit" name="submit" class="default__button submit__button text-uppercase">{{ __('default.send') }}</button>
			</form>

			<div class="callback-success__container">
				<div class="message__container">{{ __('default.thank_you') }}</div>
				<div class="content__container">{{ __('default.manager_contact') }}</div>
			</div>
		</div>
	</div>
</div>