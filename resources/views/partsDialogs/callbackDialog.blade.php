<div id="contacts__dialog" class="curtain__container">
	<div class="center__container">
		<div class="dialog__container contacts-dialog__container">
			<div class="title__container">
				<span>{{ __('default.contact_us_button') }}</span>
			</div>

			<form id="callback__form" class="form__container" method="post" action="/back_call">
				{{ csrf_field() }}

				<input id="name__field" name="name" type="text" class="field__input" placeholder="{{ __('default.name') }}" />

				<input type="tel" name="tel" class="field__input" required="required" placeholder="{{ __('default.phone') }}" />
				<input type="email" name="email" value="callback@myrig.com" hidden="hidden"/>

				<button type="submit" name="submit" class="text-uppercase default__button submit__button" />{{ __('default.request_a_call') }}</button>

				<input type="hidden" name="action" value="formcall_ajax_request">
				<input type="hidden" name="subject" value="Заказать звонок - Bitmain">
			</form>

			<div class="callback-success__container">
				<div class="message__container">{{ __('default.thank_you') }}</div>
				<div class="content__container">{{ __('default.manager_contact') }}</div>
			</div>
		</div>
	</div>
</div>