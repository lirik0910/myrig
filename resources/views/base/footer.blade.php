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
@endphp

<footer class="footer">
	<div class="top-row">
		<div class="container">
			<div class="row">
				<div class="social col-sm-4 col-md-2 col-lg-4">
					
					<a target="_blank" href="http://facebook.com/#" data-wpel-link="external" rel="nofollow external noopener noreferrer">
						<div class="social-title">Facebook</div>
						<div class="hidden-icon">
							<i class="fa fa-facebook"></i>
						</div>
					</a>

					<a target="_blank" href="https://twitter.com/myrig_com" data-wpel-link="external" rel="nofollow external noopener noreferrer">
						<div class="social-title">Twitter</div>
						<div class="hidden-icon">
							<i class="fa fa-twitter"></i>
						</div>
					</a>

					<a target="_blank" href="http://youtube.com/#" data-wpel-link="external" rel="nofollow external noopener noreferrer">
						<div class="social-title">Youtube</div>
						<div class="hidden-icon">
							<i class="fa fa-youtube-play"></i>
						</div>
					</a>
				</div>
				
				<div class="exchange col-sm-8 col-md-10 col-lg-8">
					<span class="current">BTC <span class="h-m">=</span> ${{number_format($courses['BTC/USD'][0]->value, 2, '.', '')}}</span>
					<span class="current">BCH <span class="h-m">=</span> ${{number_format($courses['BCH/USD'][0]->value, 2, '.', '')}}</span>
					<span class="current">LTC <span class="h-m">=</span> ${{number_format($courses['LTC/USD'][0]->value, 2, '.', '')}}</span>
					<span class="current">DASH <span class="h-m">=</span> ${{number_format($courses['DASH/USD'][0]->value, 2, '.', '')}}</span>
					<span class="current">ETH <span class="h-m">=</span> ${{number_format($courses['ETH/USD'][0]->value, 2, '.', '')}}</span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="middle-row">
		<div class="container">
			<div class="row">
				<div class="col-sm-2 col-md-2 col-lg-2 logo">
					<a href="{{ asset('/') }}" data-wpel-link="internal">
						<img src="{{ $preview(asset('uploads/design/logo.png'), 162, 35) }}" alt="logo"/>
					</a>
					
					<div class="payment">
						<img src="{{ asset('uploads/design/bitcoin.png') }}" alt="bitcoin"/>
						<img src="{{ asset('uploads/design/paypal.png') }}" alt="paypal"/>
					</div>
				</div>
				
				<div class="col-sm-10 col-md-7 col-lg-7 footer-menu">
					<ul id="menu-footer-menu-1" class="">
						<li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144">
							<a href="{{ url($productsPage->link) }}" data-wpel-link="internal">
								{{ $productsPage->title }}
							</a>
						</li>
						<li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144">
							<a href="https://host.myrig.com/" data-wpel-link="internal">
								{{ __('default.footer_hosting') }}
							</a>
						</li>
						@foreach ($otherPages as $page)
						<li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144">
							<a href="{{ url($page->link) }}" data-wpel-link="internal">
								{{ $page->title }}
							</a>
						</li>
						@endforeach
					</ul>

					<!--<ul id="menu-footer-menu-2" class="">
						<li id="menu-item-820" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-820">
							<a href="https://myrig.com.ua/dostavka-otgruzka/" data-wpel-link="internal">Shipping and shipment</a>
						</li>
						
						<li id="menu-item-730" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-730">
							<a href="https://myrig.com.ua/wrnt/" data-wpel-link="internal">Extended warranty</a>
						</li>
						
						<li id="menu-item-4714" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4714">
							<a href="https://myrig.com.ua/how-to-repair/" data-wpel-link="internal">Packing of items</a>
						</li>
					</ul>-->
				</div>
				
				<div class="col-sm-12 col-md-3 col-lg-3">
					<div class="contacts">
						<ul>
							@php
								$contacts = App\Model\Base\Page::whereHas('view', function ($q) {
									$q->where('title', 'Contacts');
								})->first();
								
								$contactsMulti = [];
								if (isset($contacts)) {
									$contactsMulti = App\Model\Base\MultiVariableContent::multiConvert($contacts->view->variables);
								}
							@endphp

							@isset($contactsMulti['Contact items'])
								@foreach ($contactsMulti['Contact items'] as $line)
									<li class="@if($line['country'] == 'USA') active @endif">{{ __('common.cont_' . $line['country'] ) }}
										<div class="phone-area">
											@if(isset($line['phone']) && $line['phone']) {{ $line['phone'] }} @else support@myrig.com @endif
										</div>
									</li>
								@endforeach
							@endisset
						</ul>
					</div>
					<a href="#call" class="btn-default reg-c" data-wpel-link="internal">{{ __('default.contact_us_button') }}</a>
					<div class="locale-switcher">
						<a title="USA" href="{{ env('EN_DOMAIN') . '?locale=en' }}" data-wpel-link="external" rel="nofollow external noopener noreferrer">
							<img src="{{ asset('uploads/design/us.png') }}" alt="">
						</a>
						<a title="UKR" href="{{ env('UA_DOMAIN') . '?locale=ua' }}" data-wpel-link="internal">
							<img src="{{ asset('uploads/design/ua.png') }}" alt="">
						</a>
						<a title="RUS" href="{{ env('RU_DOMAIN') . '?locale=ru' }}" data-wpel-link="external" rel="nofollow external noopener noreferrer">
							<img src="{{ asset('uploads/design/ru.png') }}" alt="ru">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<div style="display:none">
	<div id="callsuccess" class="popup-success">
		<div class="modal-header success-header">
			{{ __('default.thank_you') }}</div>
		<div class="modal-body">
			{{ __('default.manager_contact') }}
       </div>
		<div class="modal-footer">
			<button data-fancybox-close>{{ __('default.close') }}</button>
		</div>
	</div>
	<div id="call">
		<div class="modal-header">
			<ul class="reg-links">
				<li class="active" data-target="#enter-field"><a href="" data-wpel-link="internal">{{ __('default.contact_us_button') }}</a></li>
			</ul>
		</div>
		<div class="modal-body">
			<div id="call-field">
				<form id="callback" action="/back_call">
					{{csrf_field()}}
					<div class="form-group">
						<input id="name" type="text" name="name" class="form-control" placeholder="{{ __('default.name') }}" required="required" data-bv-message=" " data-bv-remote-message="Email уже занят"/></div>
					<div class="form-group">
						<input type="email" name="email" value="callback@myrig.com" hidden="hidden"/></div>
					<div class="form-group">
						<input type="tel" name="tel" class="form-control" required="required" data-bv-message=" " placeholder="{{ __('default.phone') }}"/></div>
						{{-- <div class="faspin"><i class="fa fa-cog fa-spin" hidden="hidden"></i></div> --}}
					<div class="form-group">
						{{-- <input type="submit" name="submit" value="{{ __('default.request_a_call') }}" class="btn-default btn-subscribe"/> --}}
						<button type="submit" name="submit" class="btn-default btn-subscribe">{{ __('default.request_a_call') }}<span class="faspin"><i class="fa fa-cog fa-spin" hidden="hidden"></i></span></button>
					</div>
					<input type="hidden" name="action" value="formcall_ajax_request">
					<input type="hidden" name="subject" value="Заказать звонок - Bitmain">
				</form>
				<div class="result">
					<div class="success-header">{{ __('default.thank_you') }}!</div>
					<div class="result-body">{{ __('default.manager_contact') }}.</div>
					<button data-fancybox-close>{{ __('default.close') }}</button>
				</div>
			</div>

		</div>
	</div>

	<div id="ticket">
		<div class="modal-header">
			<ul class="reg-links">
				<li data-target="#enter-field"><a href="" data-wpel-link="internal">{{ __('default.create_ticket_button') }}</a></li>
			</ul>
		</div>
		<div class="modal-body">
			<div id="ticket-field">
				<form id="ticketback">
					{{csrf_field()}}
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="E-mail" required="required" data-bv-message=" " data-bv-remote-message="Email уже занят"/></div>
					<div class="form-group">
						<input type="text" name="topic" class="form-control" required="required" data-bv-message=" " placeholder="{{ __('default.topic') }}"/></div>

					<div class="form-group">
						<textarea name="message" class="form-control" placeholder="{{ __('default.description') }}" required="required" data-bv-message=""></textarea></div>
					<div class="form-group">
						<span class="filename"></span>
						<label for="fileName"><i class="fa fa-paperclip"></i> {{ __('default.attach_file') }}</label>
						<input id="fileName" type="file" name="file" class="form-control" data-bv-message=" "></div>

					<input type="hidden" name="action" value="ticket_ajax_request">
					<input type="hidden" name="subject" value="Тикет - Bitmain">
					<div class="form-group">
						{{-- <input type="submit" name="submit"/> --}}
						<button type="submit" name="submit" class="btn-default btn-subscribe">{{ __('default.send') }}<span class="faspin"><i class="fa fa-cog fa-spin" hidden="hidden"></i></span></button>
					</div>
				</form>
				<div class="result">
					<div class="success-header">{{ __('default.thank_you') }}!</div>
					<div class="result-body">{{ __('default.manager_contact') }}.</div>
					<button data-fancybox-close>{{ __('default.close') }}</button>
				</div>
			</div>

		</div>
	</div>
	<!--<div id="reg">
		<div class="modal-header">
			<ul class="reg-links">
				<li class="active" data-target="#enter-field"><a href="" data-wpel-link="internal">Вход</a></li>
				<li data-target="#reg-field"><a href="" data-wpel-link="internal">Регистрация</a></li>
			</ul>
		</div>
		<div class="modal-body">
			<div id="reg-field">
				<form id="registration" action="#">
					<div class="form-group">
						<input id="user_email" type="email" name="user_email" class="form-control" placeholder="Эл. почта" required="required" data-bv-message=" " data-bv-remote-message="Email уже занят"/></div>
					<div class="form-group">
						<input type="tel" name="billing_phone" class="form-control billing_phone-reg" required="required"  data-bv-digits="true"   data-bv-message=" " placeholder="Телефон"/></div>

					<div class="form-group">
						<input type="submit" name="submit" value="Зарегистрироваться" class="btn-default btn-subscribe"/>
					</div>
					<input type="hidden" name="action" value="bitmain_account_register">
					<input type="hidden" name="register" value="1">
					<input type="hidden" name="subject" value="Регистрация пользователя - Bitmain">
				</form>
				<p class="result" data-text="Регистрация успешная! Пароль отправлен вам на email"></p>
			</div>
			<div id="enter-field">

				<div class="woocommerce">
					<form  id="enter" class="woocomerce-form woocommerce-form-login login " method="post">
						<div class="form-group">
							<input type="text" class="form-control" name="username" id="username" placeholder="Логин" value="" />
						</div>
						<div class="form-group">
							<input class="form-control" type="password" name="password" id="password" placeholder="Пароль"/>
						</div>
						<p class="form-row">
							<input type="hidden" id="woocommerce-login-nonce" name="woocommerce-login-nonce" value="c6b529870e" /><input type="hidden" name="_wp_http_referer" value="/" />             <input type="submit" class="btn-default btn-subscribe" name="login" value="Авторизация" />

						</p>
						<div class="more-wrapper"><a href="/wp-login.php?action=lostpassword" class="btn-recover" data-wpel-link="internal">Напомнить</a></div>
					</form>
				</div>
			</div>
		</div>
	</div>-->
</div>

<div id="response-message" class="modal-body result" style="display: none">
    <div class="success-header">{{ __('default.order_create') }}!</div>
    <div class="result-body">{{ __('default.manager_contact') }}.</div>
    <button id="order_success_close" data-fancybox-close>{{ __('default.okay') }}</button>
</div>

<script type="text/javascript">
	var global = {
		url: "{{ config('app.' . $locale . '_domain') . '/' }}",
		app: {
			connector: "{{ asset('connector') }}",
			csrf: "{{ csrf_token() }}"
		}
	};
	var calc = {};
	var products = {};
</script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
		async defer>
</script>


<!-- <script type="text/javascript" src='https://myrig.com.ua/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js?ver=3.2.6'></script> -->
<script type="text/javascript" src="{{ asset('js/owl.carousel.min.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/intlTelInput.min.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.fancybox.min.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrapValidator.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/script.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/Chart.min.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/actions.js?ver=1.12') }}"></script>
<script type="text/javascript" src="{{ asset('js/calc.js?ver=1.12') }}"></script>

<script type="text/javascript" src="{{ asset('js/selectWoo.full.min.js?ver=1.0.1') }}"></script>
<script type="text/javascript" src="{{ asset('js/country-select.min.js?ver=3.2.6') }}"></script>
<script type="text/javascript">
var wc_country_select_params = {
	"countries": "[]",
	"i18n_select_state_text": "",
	"i18n_no_matches": "{{ __('default.no_matches') }}",
	"i18n_ajax_error": "",
	"i18n_input_too_short_1": "",
	"i18n_input_too_short_n": "",
	"i18n_input_too_long_1": "",
	"i18n_input_too_long_n": "",
	"i18n_selection_too_long_1": "",
	"i18n_selection_too_long_n": "",
	"i18n_load_more": "",
	"i18n_searching": ""
};
</script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-103386645-1"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-103386645-1');
</script>

<script>
window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("https://assets.zendesk.com/embeddable_framework/main.js","bitmain.zendesk.com");/*]]>*/
</script>
<!-- End of Zendesk Widget script -->
