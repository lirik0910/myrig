@php
	$context = $select('App\Model\Base\Context')->where('title', $locale)->first();

	$productsPage = $select('App\Model\Base\Page')->where('parent_id', 0)->where('context_id', $context->id)->where('view_id', 3)->first();

	$otherPages = $select('App\Model\Base\Page')
		->where('parent_id', 0)
		->where('context_id', $context->id)
		->where(function ($q) {
			return $q
				->orWhere('view_id', 4)
				->orWhere('view_id', 7);
		})->get();

	$courses = $select('App\Model\Shop\ExchangeRate')->get()->groupBy('title');

	$infoPages = $select('App\Model\Base\Page')
		->where('parent_id', 0)
		->where('context_id', $context->id)
		->where('view_id', 3)
		->get();
@endphp

<footer id="footer__container" class="footer__container">
	<div class="service__container font-weight-light">
		<div class="row__container row default__container">
			<div class="social__container padding__collapse col-sm-4 col-md-2 col-lg-4">
				<a target="_blank" href="https://t.me/myriglive" class="item__link">
					<div class="title__container">Telegram</div>
					<div class="icon__container text-center">
						<i class="fa fa-telegram"></i>
					</div>
				</a>

				<a target="_blank" href="https://twitter.com/myrig_com" class="item__link">
					<div class="title__container">Twitter</div>
					<div class="icon__container text-center">
						<i class="fa fa-twitter"></i>
					</div>
				</a>

				<a target="_blank" href="http://youtube.com/#" class="item__link">
					<div class="title__container">Youtube</div>
					<div class="icon__container text-center">
						<i class="fa fa-youtube-play"></i>
					</div>
				</a>
			</div>

			<div class="currency-rates__container text-right padding__collapse col-sm-8 col-md-10 col-lg-8">
				<span class="currency__item">BTC <span class="equal__item">=</span> ${{number_format($courses['BTC/USD'][0]->value, 2, '.', '')}}</span>
				
				<span class="currency__item">BCH <span class="equal__item">=</span> ${{number_format($courses['BCH/USD'][0]->value, 2, '.', '')}}</span>
				
				<span class="currency__item">LTC <span class="equal__item">=</span> ${{number_format($courses['LTC/USD'][0]->value, 2, '.', '')}}</span>
				
				<span class="currency__item">DASH <span class="equal__item">=</span> ${{number_format($courses['DASH/USD'][0]->value, 2, '.', '')}}</span>
				
				<span class="currency__item">ETH <span class="equal__item">=</span> ${{number_format($courses['ETH/USD'][0]->value, 2, '.', '')}}</span>
			</div>
		</div>
	</div>

	<div class="info__container">
		<div class="row__container row default__container">
			<div class="logo__container padding__collapse col-sm-2 col-md-2 col-lg-2">
				<a class="link__item logo-link__item" href="{{ asset('/') }}">
					<img class="logo__icon" src="{{ $preview(asset('uploads/design/logo.png'), 316, 68) }}" alt="logo" style="width: 190px" />
				</a>
					
				<div class="payment-types__container">
					<img src="{{ asset('uploads/design/bitcoin.png') }}" alt="bitcoin" />
					<img src="{{ asset('uploads/design/paypal.png') }}" alt="paypal" />
				</div>
			</div>

			<div class="navigation__list col-sm-10 col-md-7 col-lg-7 margin__collapse padding__collapse row font-weight-light">
				<ul class="list__container margin__collapse padding__collapse col-sm-5">
					<li class="list__item">
						<a href="{{ url($productsPage->link) }}">
							{{ $productsPage->title }}
						</a>
					</li>

					<li class="list__item">
						<a href="https://host.myrig.com/">
							{{ __('default.footer_hosting') }}
						</a>
					</li>

					@foreach ($otherPages as $page)
					<li class="list__item">
						<a href="{{ url($page->link) }}">
							{{ $page->title }}
						</a>
					</li>
					@endforeach

				</ul>
			
				<ul class="list__container margin_links padding__collapse col-sm-7">
					@foreach ($infoPages as $page)
					<li class="list__item">
						<a href="{{ $page->link }}">
							{{ $page->title }}
						</a>
					</li>
					@endforeach
				</ul>
			</div>

			<div class="contacts__container padding__collapse margin__collapse col-sm-12 col-md-3 col-lg-3 row">
				<ul id="footer-contacts__list" class="contacts__list col-md-6 margin__collapse padding__collapse">
				@php
					$contacts = App\Model\Base\Page::whereHas('view', function ($q) {
						$q->where('title', 'Contacts');
					})->first();
									
					$contactsMulti = [];
					if (isset($contacts)) {
						$contactsMulti = App\Model\Base\MultiVariableContent::multiConvert($contacts->view->variables);
					}
				@endphp

				@foreach ($contactsMulti['Contact items'] as $line)
				<li class="list__item @if($line['country'] == 'USA') active @endif">{{ __('common.cont_' . $line['country'] ) }}
					<div class="phone-area__container">
						@if(isset($line['phone']) && $line['phone']) 
							{{ $line['phone'] }} 
						@else 
							support@myrig.com 
						@endif
					</div>
				</li>
				@endforeach
				</ul>

				<div class="col-md-6 connect-button__container padding__collapse text-right">
					<button id="connect__button" class="default__button connect__button text-uppercase">
						{{ __('default.contact_us_button') }}
					</button>
				</div>

				<div class="locales__container">
					<a title="USA" href="https://myrig.com/">
						<img src="{{ asset('uploads/design/us.png') }}" alt="USA">
					</a>

					<a title="UA" href="{{ env('UA_DOMAIN') . '?locale=ua' }}">
						<img src="{{ asset('uploads/design/ua.png') }}" alt="UA">
					</a>

					<a title="RUR" href="{{ env('RU_DOMAIN') . '?locale=ru' }}">
						<img src="{{ asset('uploads/design/ru.png') }}" alt="RU">
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>

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

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<link rel="stylesheet" href="{{ asset('css/' . strtolower($it->view->title) . '.css') }}">
<script type="text/javascript" src="{{ asset('js/' . strtolower($it->view->title) . '.js') }}"></script>
<script type="text/javascript">
	var global = {
		url: "{{ config('app.' . $locale . '_domain') . '/' }}",
		app: {
			connector: "{{ asset('connector') }}"
		}
	};
</script>

<script>
window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("https://assets.zendesk.com/embeddable_framework/main.js","bitmain.zendesk.com");
</script>