<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel='dns-prefetch' href='//ajax.googleapis.com' />
    <link rel='dns-prefetch' href='//maxcdn.bootstrapcdn.com' />
    <link rel='dns-prefetch' href='//s.w.org' />
    <link rel="stylesheet" href="{{URL::asset('css/jquery.fancybox.min.css')}}"></link>
    <link rel="stylesheet" href="{{URL::asset('css/animate.css')}}"></link>
    <link rel="stylesheet" href="{{URL::asset('css/owl.carousel.min.css')}}"></link>
    <link rel="stylesheet" href="{{URL::asset('css/owl.theme.default.min.css')}}"></link>
    <link rel="stylesheet" href="{{URL::asset('css/bootstrapvalidator.css')}}"></link>
    <link rel="stylesheet" href="{{URL::asset('css/intlTelInput.css')}}"></link>
    <link rel="stylesheet" href="{{URL::asset('css/calc.css')}}"></link>
    <link rel='stylesheet' id='font-awesome-css'  href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css?ver=2.2.0' type='text/css' media='all' />
    <link rel="stylesheet" href="{{URL::asset('css/style.css?ver=1.55')}}"></link>
    <link rel='stylesheet' id='dashicons-css'  href="{{URL::asset('css/dashicons.min.css?ver=4.9.4')}}" type='text/css' media='all' />

    <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script type="text/javascript">
        window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.4\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.4\/svg\/","svgExt":".svg","source":{"concatemoji":"https:\/\/myrig.com.ua\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.9.4"}};
        !function(a,b,c){function d(a,b){var c=String.fromCharCode;l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,a),0,0);var d=k.toDataURL();l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,b),0,0);var e=k.toDataURL();return d===e}function e(a){var b;if(!l||!l.fillText)return!1;switch(l.textBaseline="top",l.font="600 32px Arial",a){case"flag":return!(b=d([55356,56826,55356,56819],[55356,56826,8203,55356,56819]))&&(b=d([55356,57332,56128,56423,56128,56418,56128,56421,56128,56430,56128,56423,56128,56447],[55356,57332,8203,56128,56423,8203,56128,56418,8203,56128,56421,8203,56128,56430,8203,56128,56423,8203,56128,56447]),!b);case"emoji":return b=d([55357,56692,8205,9792,65039],[55357,56692,8203,9792,65039]),!b}return!1}function f(a){var c=b.createElement("script");c.src=a,c.defer=c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var g,h,i,j,k=b.createElement("canvas"),l=k.getContext&&k.getContext("2d");for(j=Array("flag","emoji"),c.supports={everything:!0,everythingExceptFlag:!0},i=0;i<j.length;i++)c.supports[j[i]]=e(j[i]),c.supports.everything=c.supports.everything&&c.supports[j[i]],"flag"!==j[i]&&(c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&c.supports[j[i]]);c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&!c.supports.flag,c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.everything||(h=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",h,!1),a.addEventListener("load",h,!1)):(a.attachEvent("onload",h),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),g=c.source||{},g.concatemoji?f(g.concatemoji):g.wpemoji&&g.twemoji&&(f(g.twemoji),f(g.wpemoji)))}(window,document,window._wpemojiSettings);
    </script>
    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 .07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<meta name="google-site-verification" content="YroKW8N1nmTvNHctf_WMuPtVYhPqE4bklPM-o6buvrc" />

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-103386645-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-103386645-1');
</script>
</head>
<body class="home">
<div id="canvas">
    <nav id="myNavmenu" class="navmenu navmenu-default" role="navigation">
        <ul id="menu-main-menu" class="nav"><li id="menu-item-31" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-31"><a href="{{url('/shop')}}" data-wpel-link="internal">Товары</a></li>
            <li id="menu-item-26" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-26"><a href="https://myrig.com.ua/hosting/" data-wpel-link="internal">Хостинг</a></li>
            <li id="menu-item-29" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-29"><a href="{{url('/service')}}" data-wpel-link="internal">Сервис</a></li>
            <li id="menu-item-27" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-27"><a href="{{url('/news')}}" data-wpel-link="internal">Новости</a></li>
            <li id="menu-item-30" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-30"><a href="{{url('/contacts')}}" data-wpel-link="internal">Контакты</a></li>
        </ul>        </nav>
</div>
<header class="header">
    <nav class="navbar">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{env('APP_URL')}}" data-wpel-link="internal"><img src="{{asset('images/l.png')}}" alt=""/></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul id="menu-main-menu-1" class="nav navbar-nav"><li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-31"><a href="{{url('/shop')}}" data-wpel-link="internal">Товары</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-26"><a href="https://myrig.com.ua/hosting/" data-wpel-link="internal">Хостинг</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-29"><a href="{{url('/service')}}" data-wpel-link="internal">Сервис</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-27"><a href="{{url('/news')}}" data-wpel-link="internal">Новости</a></li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-30"><a href="{{url('/contacts')}}" data-wpel-link="internal">Контакты</a></li>
                    </ul>
                </div>
                <div class="user-panel">
                    <a href="https://myrig.com.ua/sso-login/" class="reg-f0" data-wpel-link="internal"><img src="https://myrig.com.ua/wp-content/themes/bitmain/img/icons-07.svg" alt=""/></a>

                    <!-- <a href="#reg" class="reg-f" data-wpel-link="internal"><img src="https://myrig.com.ua/wp-content/themes/bitmain/img/icons-07.svg" alt=""/></a>  -->
                    <a href="{{url('/cart')}}" data-wpel-link="internal"><img src="https://myrig.com.ua/wp-content/themes/bitmain/img/icons-02.svg" alt=""/><div class="label">0</div></a>
                </div>
            </div>
        </div>
    </nav>
</header>
@yield('content')
<footer class="footer">
    <div class="top-row">
        <div class="container">
            <div class="row">
                <div class="social col-sm-4 col-md-2 col-lg-4">


                    <a target="_blank" href="http://facebook.com/#" data-wpel-link="external" rel="nofollow external noopener noreferrer"><div class="social-title">Facebook</div><div class="hidden-icon"><i class="fa fa-facebook"></i></div></a>

                    <a target="_blank" href="https://twitter.com/myrig_com" data-wpel-link="external" rel="nofollow external noopener noreferrer"><div class="social-title">Twitter</div><div class="hidden-icon"><i class="fa fa-twitter"></i></div></a>

                    <a target="_blank" href="http://youtube.com/#" data-wpel-link="external" rel="nofollow external noopener noreferrer"><div class="social-title">Youtube</div><div class="hidden-icon"><i class="fa fa-youtube-play"></i></div></a>


                </div>
                <div class="exchange col-sm-8 col-md-10 col-lg-8  ">

                    <span class="current">BTC <span class="h-m">=</span> $11535.02	             </span>

                    <span class="current">BCH <span class="h-m">=</span> $1565.11
	             </span>
                    <span class="current">LTC <span class="h-m">=</span> $247.98
	             </span>
                    <span class="current">DASH <span class="h-m">=</span> $733.01
	             </span>
                    <span class="current">ETH <span class="h-m">=</span> $960.25
	             </span>




                </div>


            </div>
        </div>
    </div>
    <div class="middle-row">
        <div class="container">
            <div class="row">
                <div class="col-sm-2 col-md-2 col-lg-2 logo">
                    <a href="https://myrig.com.ua" data-wpel-link="internal">
                        <img src="https://myrig.com.ua/wp-content/themes/bitmain/img/l.png" alt=""/></a>
                    <div class="payment">
                        <img src="https://myrig.com.ua/wp-content/themes/bitmain/img/bitcoin.png" alt=""/>
                        <img src="https://myrig.com.ua/wp-content/themes/bitmain/img/paypal.png" alt=""/>
                    </div>
                </div>
                <div class="col-sm-10 col-md-7 col-lg-7 footer-menu">
                    <ul id="menu-footer-menu-1" class=""><li id="menu-item-144" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-144"><a href="{{url('/shop')}}" data-wpel-link="internal">Товары</a></li>
                        <li id="menu-item-38" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-38"><a href="https://myrig.com.ua/hosting/" data-wpel-link="internal">Хостинг</a></li>
                        <li id="menu-item-40" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-40"><a href="{{url('/service')}}" data-wpel-link="internal">Сервис</a></li>
                        <li id="menu-item-150" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-150"><a href="{{url('/news')}}" data-wpel-link="internal">Новости</a></li>
                    </ul>                    <ul id="menu-footer-menu-2" class=""><li id="menu-item-820" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-820"><a href="https://myrig.com.ua/dostavka-otgruzka/" data-wpel-link="internal">Доставка и отгрузка</a></li>
                        <li id="menu-item-730" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-730"><a href="https://myrig.com.ua/wrnt/" data-wpel-link="internal">Расширенная гарантия</a></li>
                        <li id="menu-item-4714" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4714"><a href="https://myrig.com.ua/how-to-repair/" data-wpel-link="internal">Упаковка отправлений</a></li>
                    </ul>                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="contacts">
                        <ul>
                            @isset($page)
                                @foreach($page->variables as $variable)
                                    @if($variable->title == 'contactPhone')
                                        <li class="@if($variable->pivot->name == 'USA') active @endif">{{$variable->pivot->name}}
                                            <div class="phone-area">
                                                {{$variable->pivot->content}}                                </div>
                                        </li>
                                    @endif
                                @endforeach
                            @endisset
                        </ul>

                    </div>

                    <a href="#call" class="btn-default reg-c" data-wpel-link="internal">Обратный звонок</a>
                    <div class="locale-switcher">
                        <a title="USA" href="https://myrig.com?locale=US" data-wpel-link="external" rel="nofollow external noopener noreferrer"><img src="https://myrig.com.ua/wp-content/themes/bitmain/img/us.png"  alt=""></a>
                        <a title="UKR" href="https://myrig.com.ua?locale=UA" data-wpel-link="internal"><img src="https://myrig.com.ua/wp-content/themes/bitmain/img/ua.png"  alt=""></a>
                        <a title="RUS" href="https://myrig.ru?locale=RU" data-wpel-link="external" rel="nofollow external noopener noreferrer"><img src="https://myrig.com.ua/wp-content/themes/bitmain/img/ru.png"  alt=""></a>
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
                            <input type="hidden" id="woocommerce-login-nonce" name="woocommerce-login-nonce" value="c6b529870e" /><input type="hidden" name="_wp_http_referer" value="/" />				<input type="submit" class="btn-default btn-subscribe" name="login" value="Авторизация" />

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
    /* <![CDATA[ */
    var wpcf7 = {"apiSettings":{"root":"https:\/\/myrig.com.ua\/wp-json\/contact-form-7\/v1","namespace":"contact-form-7\/v1"},"recaptcha":{"messages":{"empty":"\u041f\u043e\u0436\u0430\u043b\u0443\u0439\u0441\u0442\u0430, \u043f\u043e\u0434\u0442\u0432\u0435\u0440\u0434\u0438\u0442\u0435, \u0447\u0442\u043e \u0432\u044b \u043d\u0435 \u0440\u043e\u0431\u043e\u0442."}}};
    /* ]]> */
</script>
<script type='text/javascript' src='https://myrig.com.ua/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=5.0'></script>
<script type='text/javascript' src='https://myrig.com.ua/wp-content/plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js?ver=2.70'></script>
<script type='text/javascript' src='https://myrig.com.ua/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min.js?ver=2.1.4'></script>
<!--<script type='text/javascript'>
    /* <![CDATA[ */
    var woocommerce_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","wc_ajax_url":"https:\/\/myrig.com.ua\/?wc-ajax=%%endpoint%%"};
    /* ]]> */
</script>-->
<script type='text/javascript' src='https://myrig.com.ua/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min.js?ver=3.2.6'></script>
<!--<script type='text/javascript'>
    /* <![CDATA[ */
    var wc_cart_fragments_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","wc_ajax_url":"https:\/\/myrig.com.ua\/?wc-ajax=%%endpoint%%","fragment_name":"wc_fragments_f87a1255d268f06a03038114b3ca3c9b"};
    /* ]]> */
</script>-->
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
            var global = {"url":"{{env('APP_URL')}}"};
    /* ]]> */
</script>
<script type='text/javascript' src='https://myrig.com.ua/wp-includes/js/wp-embed.min.js?ver=4.9.4'></script>
</body>
</html>