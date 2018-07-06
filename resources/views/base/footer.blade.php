@php
	$context = $select('App\Model\Base\Context')->where('title', $locale)->first();

	$productsPage = $select('App\Model\Base\Page')
		->where('parent_id', 0)
		->where('context_id', $context->id)
		->where('view_id', 3)
		->first();

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
		->where('view_id', 10)
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

				@if (isset($contactsMulti['Contact items']))
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
				@endif
				</ul>

				<div class="col-md-6 connect-button__container padding__collapse text-right">
					<button id="connect__button" class="default__button connect__button text-uppercase">
						{{ __('default.contact_us_button') }}
					</button>
				</div>

				<div class="locales__container">
					<a title="USA" href="{{ config('app.en_domain') . '?locale=en' }}">
						<img src="{{ asset('uploads/design/us.png') }}" alt="USA">
					</a>

					<a title="UA" href="{{ config('app.ua_domain') . '?locale=ua' }}">
						<img src="{{ asset('uploads/design/ua.png') }}" alt="UA">
					</a>

					<a title="RUR" href="{{ config('app.ru_domain') . '?locale=ru' }}">
						<img src="{{ asset('uploads/design/ru.png') }}" alt="RU">
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>

@include('partsDialogs.ticketDialog')
@include('partsDialogs.callbackDialog')
@include('partsDialogs.availabilityDialog')

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

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
   (function (d, w, c) {
       (w[c] = w[c] || []).push(function() {
           try {
               w.yaCounter49480066 = new Ya.Metrika2({
                   id:49480066,
                   clickmap:true,
                   trackLinks:true,
                   accurateTrackBounce:true
               });
           } catch(e) { }
       });

       var n = d.getElementsByTagName("script")[0],
           s = d.createElement("script"),
           f = function () { n.parentNode.insertBefore(s, n); };
       s.type = 'text/javascript';
       s.async = true;
       s.src = 'https://mc.yandex.ru/metrika/tag.js';

       if (w.opera == "[object Opera]") {
           d.addEventListener('DOMContentLoaded', f, false);
       } else { f(); }
   })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/49480066
https://mc.yandex.ru/watch/49480066" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src='https://www.googletagmanager.com/gtag/js?id=UA-103386645-1'></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());

 gtag('config', 'UA-103386645-1');
</script>

<script>
window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("https://assets.zendesk.com/embeddable_framework/main.js","bitmain.zendesk.com");
</script>