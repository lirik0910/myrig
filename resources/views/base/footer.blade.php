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
					<span class="current">BTC <span class="h-m">=</span>$11535.02</span>
					<span class="current">BCH <span class="h-m">=</span> $1565.11</span>
					<span class="current">LTC <span class="h-m">=</span> $247.98</span>
					<span class="current">DASH <span class="h-m">=</span> $733.01</span>
					<span class="current">ETH <span class="h-m">=</span> $960.25</span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="middle-row">
		<div class="container">
			<div class="row">
				<div class="col-sm-2 col-md-2 col-lg-2 logo">
					<a href="https://myrig.com.ua" data-wpel-link="internal">
						<img src="https://myrig.com.ua/wp-content/themes/bitmain/img/l.png" alt=""/>
					</a>
					
					<div class="payment">
						<img src="https://myrig.com.ua/wp-content/themes/bitmain/img/bitcoin.png" alt=""/>
						<img src="https://myrig.com.ua/wp-content/themes/bitmain/img/paypal.png" alt=""/>
					</div>
				</div>
				
				<div class="col-sm-10 col-md-7 col-lg-7 footer-menu">
					<ul id="menu-footer-menu-1" class="">
						<li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144">
							<a href="{{url('/shop')}}" data-wpel-link="internal">Товары</a>
						</li>
						
						<li id="menu-item-38" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-38">
							<a href="https://myrig.com.ua/hosting/" data-wpel-link="internal">Хостинг</a>
						</li>
						
						<li id="menu-item-40" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-40">
							<a href="{{url('/service')}}" data-wpel-link="internal">Сервис</a>
						</li>
						
						<li id="menu-item-150" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-150">
							<a href="{{url('/news')}}" data-wpel-link="internal">Новости</a>
						</li>
					</ul>

					<ul id="menu-footer-menu-2" class="">
						<li id="menu-item-820" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-820">
							<a href="https://myrig.com.ua/dostavka-otgruzka/" data-wpel-link="internal">Доставка и отгрузка</a>
						</li>
						
						<li id="menu-item-730" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-730">
							<a href="https://myrig.com.ua/wrnt/" data-wpel-link="internal">Расширенная гарантия</a>
						</li>
						
						<li id="menu-item-4714" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4714">
							<a href="https://myrig.com.ua/how-to-repair/" data-wpel-link="internal">Упаковка отправлений</a>
						</li>
					</ul>
				</div>
				
				<div class="col-sm-12 col-md-3 col-lg-3">
					<div class="contacts">
						<ul>
						@isset($page)
						@foreach($page->variables as $variable)
							@if($variable->title == 'contactPhone')
								<li class="@if($variable->pivot->name == 'USA') active @endif">{{$variable->pivot->name}}
									<div class="phone-area">
										{{$variable->pivot->content}}
									</div>
								</li>
							@endif
						@endforeach
						@endisset
						</ul>
					</div>

					<a href="#call" class="btn-default reg-c" data-wpel-link="internal">Обратный звонок</a>
					<div class="locale-switcher">
						<a title="USA" href="https://myrig.com?locale=US" data-wpel-link="external" rel="nofollow external noopener noreferrer">
							<img src="https://myrig.com.ua/wp-content/themes/bitmain/img/us.png"  alt="">
						</a>
						
						<a title="UKR" href="https://myrig.com.ua?locale=UA" data-wpel-link="internal">
							<img src="https://myrig.com.ua/wp-content/themes/bitmain/img/ua.png"  alt="">
						</a>
						
						<a title="RUS" href="https://myrig.ru?locale=RU" data-wpel-link="external" rel="nofollow external noopener noreferrer">
							<img src="https://myrig.com.ua/wp-content/themes/bitmain/img/ru.png"  alt="">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<div style="display:none">
	<div id="reg">
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
	</div>

	<a class="regsuccess" href="#regsuccess" data-wpel-link="internal"></a>
	<div id="regsuccess" class="popup-success">
		<div class="modal-header success-header">
			СПАСИБО<br/> ЗА РЕГИСТРАЦИЮ
		</div>
		<div class="modal-body">
			Пароль отправлен на указанную вами электронную почту!
		</div>
		<div class="modal-footer">
			<button data-fancybox-close>Закрыть</button>
		</div>
	</div>
	<a class="callsuccess" href="#callsuccess" data-wpel-link="internal"></a>
	<div id="callsuccess" class="popup-success">
		<div class="modal-header success-header">
			СПАСИБО<br/> ЗА ЗАЯВКУ        </div>
		<div class="modal-body">
			Мененджер свяжется с вами в ближайшее время.        </div>
		<div class="modal-footer">
			<button data-fancybox-close>Закрыть</button>
		</div>
	</div>
	<div id="call">
		<div class="modal-header">
			<ul class="reg-links">
				<li class="active" data-target="#enter-field"><a href="" data-wpel-link="internal">Обратный звонок</a></li>

			</ul>
		</div>
		<div class="modal-body">
			<div id="call-field">
				<form id="callback" action="/back_call">
					{{csrf_field()}}
					<div class="form-group">
						<input id="name" type="text" name="name" class="form-control" placeholder="Имя" required="required" data-bv-message=" " data-bv-remote-message="Email уже занят"/></div>
					<div class="form-group">
						<input type="tel" name="tel" class="form-control" required="required" data-bv-message=" " placeholder="Телефон"/></div>
					<div class="form-group">
						<input type="submit" name="submit" value="Заказать звонок" class="btn-default btn-subscribe"/>
					</div>
					<input type="hidden" name="action" value="formcall_ajax_request">
					<input type="hidden" name="subject" value="Заказать звонок - Bitmain">
				</form>
				<div class="result">
					<div class="success-header">СПАСИБО<br/> ЗА ЗАЯВКУ</div>
					<div class="result-body">Мененджер свяжется с вами в ближайшее время.</div>
					<button data-fancybox-close>Закрыть</button>
				</div>
			</div>

		</div>
	</div>

	<div id="ticket">
		<div class="modal-header">
			<ul class="reg-links">
				<li data-target="#enter-field"><a href="" data-wpel-link="internal">Новый тикет</a></li>
			</ul>
		</div>
		<div class="modal-body">
			<div id="ticket-field">
				<form id="ticketback" action="/service_ticket">
					{{csrf_field()}}
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="Электронная почта" required="required" data-bv-message=" " data-bv-remote-message="Email уже занят"/></div>
					<div class="form-group">
						<input type="text" name="topic" class="form-control" required="required" data-bv-message=" " placeholder="Тема"/></div>

					<div class="form-group">
						<textarea name="message" class="form-control" placeholder="Описание" required="required" data-bv-message=" "></textarea></div>
					<div class="form-group">
						<span class="filename"></span>
						<label for="fileName"><i class="fa fa-paperclip"></i> Прикрепить файл</label>
						<input id="fileName" type="file" name="file" class="form-control" data-bv-message=" "></div>

					<input type="hidden" name="action" value="ticket_ajax_request">
					<input type="hidden" name="subject" value="Тикет - Bitmain">
					<div class="form-group">
						<input type="submit" name="submit" value="Отправить" class="btn-default btn-subscribe"/>
					</div>

				</form>
				<div class="result">
					<div class="success-header">СПАСИБО<br/> ЗА ЗАЯВКУ</div>
					<div class="result-body">Мененджер свяжется с вами в ближайшее время.</div>
					<button data-fancybox-close>Закрыть</button>
				</div>
			</div>

		</div>
	</div>

</div>
<script>
	/*<![CDATA[*/
	window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("https://assets.zendesk.com/embeddable_framework/main.js","bitmain.zendesk.com");/*]]>*/
</script>
<!-- End of Zendesk Widget script -->
<script type='text/javascript'>
	var wpcf7 = {"apiSettings":{"root":"https:\/\/myrig.com.ua\/wp-json\/contact-form-7\/v1","namespace":"contact-form-7\/v1"},"recaptcha":{"messages":{"empty":"\u041f\u043e\u0436\u0430\u043b\u0443\u0439\u0441\u0442\u0430, \u043f\u043e\u0434\u0442\u0432\u0435\u0440\u0434\u0438\u0442\u0435, \u0447\u0442\u043e \u0432\u044b \u043d\u0435 \u0440\u043e\u0431\u043e\u0442."}}};
	/* ]]> */
</script>
<script type='text/javascript' src='https://myrig.com.ua/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=5.0'></script>
<script type='text/javascript' src='https://myrig.com.ua/wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js?ver=2.70'></script>
<script type='text/javascript' src='https://myrig.com.ua/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min.js?ver=2.1.4'></script>
<script type='text/javascript' src='https://myrig.com.ua/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min.js?ver=3.2.6'></script>
<script type='text/javascript' src='https://myrig.com.ua/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js?ver=3.2.6'></script>
<script type='text/javascript' src="{{URL::asset('js/owl.carousel2.min.js?ver=1.12')}}"></script>
<script type='text/javascript' src="{{URL::asset('js/intlTelInput.min.js?ver=1.12')}}"></script>
<script type='text/javascript' src="{{URL::asset('js/jquery.fancybox.min.js?ver=1.12')}}"></script>
<script type='text/javascript' src="{{URL::asset('js/bootstrapValidator.js?ver=1.12')}}"></script>
<script type='text/javascript' src="{{URL::asset('js/script.js?ver=1.12')}}"></script>
<script type='text/javascript' src="{{URL::asset('js/Chart.min.js?ver=1.12')}}"></script>
<script type='text/javascript' src="{{URL::asset('js/actions.js?ver=1.12')}}"></script>
<script type='text/javascript' src="{{URL::asset('js/calc.js?ver=1.12')}}"></script>
<script type='text/javascript'>
	var global = {"url":"{{env('APP_URL')}}"};
</script>
<script type='text/javascript' src='https://myrig.com.ua/wp-includes/js/wp-embed.min.js?ver=4.9.4'></script>