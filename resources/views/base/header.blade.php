@extends('layouts.app')

@section('header')
<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
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
    <link rel="stylesheet" href="{{URL::asset('css/style.css')}}"></link>
    <link rel='stylesheet' id='dashicons-css'  href="{{URL::asset('css/dashicons.min.css?ver=4.9.4')}}" type='text/css' media='all' />
<!--<link rel="stylesheet" href="{{URL::asset('css/magnific-popup.css')}}"></link>
    <link rel="stylesheet" href="{{URL::asset('css/owl.theme.css')}}"></link>-->

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
@endsection