@php 
$menu = $select('App\Model\Base\Page')
	->where('parent_id', 0)
	->where(function ($q) {
		return $q
			->where('view_id', 3)
			->orWhere('view_id', 6)
			->orWhere('view_id', 7)
			->orWhere('view_id', 4);
	})->get();
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
					<a href="{{ asset('/') }}" data-wpel-link="internal">
						<img src="{{ asset('design/images/logo.png') }}" alt="logo"/>
					</a>
					
					<div class="payment">
						<img src="{{ asset('design/images/bitcoin.png') }}" alt="bitcoin"/>
						<img src="{{ asset('design/images/paypal.png') }}" alt="paypal"/>
					</div>
				</div>
				
				<div class="col-sm-10 col-md-7 col-lg-7 footer-menu">
					<ul id="menu-footer-menu-1" class="">
						@foreach ($menu as $item)
						<li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144">
							<a href="{{ url($item->link) }}" data-wpel-link="internal">
								{{ $item->title }}
							</a>
						</li>
						@endforeach
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
                            @php
                                $contactItems = App\Model\Base\VariableMultiContent::where('variable_id', 2)->where('name', 'country')->orWhere('name', 'phone')->get()->groupBy('content_id');
                                //var_dump($contactItems); die;
                            @endphp
						@isset($contactItems)
                                @foreach($contactItems as $item)
                                    <li class="@if($item[0]->content == 'USA') active @endif">{{$item[0]->content}}
                                        <div class="phone-area">
                                            @if(isset($item[1])) {{$item[1]->content}} @else support@myrig.com @endif
                                        </div>
                                    </li>
                                @endforeach
						@endisset
						</ul>
					</div>

					<a href="#call" class="btn-default reg-c" data-wpel-link="internal">Обратный звонок</a>
					<div class="locale-switcher">
						<a title="USA" href="{{ url('/') }}" data-wpel-link="external" rel="nofollow external noopener noreferrer">
							<img src="{{ asset('design/images/us.png') }}" alt="">
						</a>
						
						<a title="UKR" href="{{ url('/') }}" data-wpel-link="internal">
							<img src="{{ asset('design/images/ua.png') }}" alt="">
						</a>
						
						<a title="RUS" href="{{ url('/') }}" data-wpel-link="external" rel="nofollow external noopener noreferrer">
							<img src="{{ asset('design/images/ru.png') }}" alt="ru">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<script type="text/javascript">
	var global = {
		app: {
			connector: "{{ asset('connector') }}",
			csrf: "{{ csrf_token() }}"
		}
	}
</script>

<link rel="stylesheet" href="{{URL::asset('css/bootstrapvalidator.css')}}">
<link rel="stylesheet" href="{{URL::asset('css/intlTelInput.css')}}">
<link rel="stylesheet" href="{{URL::asset('css/calc.css')}}">
<link rel='stylesheet' id='font-awesome-css'  href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css?ver=2.2.0' type='text/css' media='all' />

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
    /* <![CDATA[ */
    var global = {
        url: '{{env('APP_URL')}}',
        app: {
            connector: "{{ asset('connector') }}",
            csrf: "{{ csrf_token() }}"
        }
    };
    var calc = {};
    /* ]]> */
</script>
<script type="text/javascript" src="{{ asset('design/build/js/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('design/build/js/shop.js') }}"></script>

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