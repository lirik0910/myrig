<div id="ticket__dialog" class="curtain__container">
	<div class="center__container">
		<div class="ticket-dialog__container">
			<div class="title__container">
				<span>{{ __('default.create_ticket_button') }}</span>
			</div>

			<form id="ticket__form" class="ticket__form form__container" method="post" action="/create_ticket">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="action" value="ticket_ajax_request" />
				<input type="hidden" name="subject" value="Тикет - Bitmain" />

				<input id="email__field" name="email" type="email" class="field__input" placeholder="E-mail" required="required" />

				<input id="subject__field" name="topic" type="text" class="field__input" placeholder="{{ __('default.topic') }}" required="required" />

				<textarea rows="5" class="field__input" name="message" placeholder="{{ __('default.description') }}" style="height: auto;"></textarea>

				<div id="seleted-file__container"></div>
				<label for="file__field" class="file__label">
					<i class="fa fa-paperclip"></i> {{ __('default.attach_file') }}
				</label>
				<input id="file__field" type="file" name="file" style="display: none;" />

				<button type="submit" name="submit" class="default__button submit__button text-uppercase">{{ __('default.send') }}</button>
			</form>

			<div class="callback-success__container">
				<div class="message__container">{{ __('default.thank_you') }}</div>
				<div class="content__container">{{ __('default.manager_contact') }}</div>
			</div>
		</div>
	</div>
</div>