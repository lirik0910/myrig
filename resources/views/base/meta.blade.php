<meta charset="UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

<title>@if(isset($it)){{ htmlentities($it->title) }}@endif</title>
@if(isset($it))
<meta name="description" content="{{ htmlentities($it->description) }}" />
@endif
<base href="{{ asset('/') }}" />

<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="format-detection" content="telephone=no" />

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel='dns-prefetch' href='//ajax.googleapis.com' />
<link rel='dns-prefetch' href='//maxcdn.bootstrapcdn.com' />
<link rel='dns-prefetch' href='//s.w.org' />
<link rel='stylesheet' href="{{ URL::asset('css/woocommerce-layout.css?ver=3.2.6') }}" type='text/css' media='all' />
<link rel='stylesheet' href="{{ URL::asset('css/woocommerce-smallscreen.css?ver=3.2.6') }}" type='text/css' media='only screen and (max-width: 768px)' />
<link rel='stylesheet' href='{{ URL::asset('css/woocommerce.css?ver=3.2.6') }}' type='text/css' media='all' />
<link rel="stylesheet" href="{{ URL::asset('css/jquery.fancybox.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/animate.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/select2.css?ver=3.2.6') }}">
<link rel="stylesheet" href="{{ URL::asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/bootstrapvalidator.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/intlTelInput.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/calc.css') }}">
<link rel="stylesheet" id="font-awesome-css"  href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css?ver=2.2.0" type="text/css" media="all" />
<link rel="stylesheet" href="{{ URL::asset('css/bitmain.css?ver=1.55') }}">
<link rel="stylesheet" href="{{ URL::asset('css/style.css?ver=1.55') }}">
<link rel="stylesheet" id="dashicons-css"  href="{{ URL::asset('css/dashicons.min.css?ver=4.9.4') }}" type="text/css" media="all" />

<script type="text/javascript" src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
<script type="text/javascript">
    window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.4\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/2.4\/svg\/","svgExt":".svg","source":{"concatemoji":"https:\/\/myrig.com.ua\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.9.4"}};
    !function(a,b,c){function d(a,b){var c=String.fromCharCode;l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,a),0,0);var d=k.toDataURL();l.clearRect(0,0,k.width,k.height),l.fillText(c.apply(this,b),0,0);var e=k.toDataURL();return d===e}function e(a){var b;if(!l||!l.fillText)return!1;switch(l.textBaseline="top",l.font="600 32px Arial",a){case"flag":return!(b=d([55356,56826,55356,56819],[55356,56826,8203,55356,56819]))&&(b=d([55356,57332,56128,56423,56128,56418,56128,56421,56128,56430,56128,56423,56128,56447],[55356,57332,8203,56128,56423,8203,56128,56418,8203,56128,56421,8203,56128,56430,8203,56128,56423,8203,56128,56447]),!b);case"emoji":return b=d([55357,56692,8205,9792,65039],[55357,56692,8203,9792,65039]),!b}return!1}function f(a){var c=b.createElement("script");c.src=a,c.defer=c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var g,h,i,j,k=b.createElement("canvas"),l=k.getContext&&k.getContext("2d");for(j=Array("flag","emoji"),c.supports={everything:!0,everythingExceptFlag:!0},i=0;i<j.length;i++)c.supports[j[i]]=e(j[i]),c.supports.everything=c.supports.everything&&c.supports[j[i]],"flag"!==j[i]&&(c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&c.supports[j[i]]);c.supports.everythingExceptFlag=c.supports.everythingExceptFlag&&!c.supports.flag,c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.everything||(h=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",h,!1),a.addEventListener("load",h,!1)):(a.attachEvent("onload",h),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),g=c.source||{},g.concatemoji?f(g.concatemoji):g.wpemoji&&g.twemoji&&(f(g.twemoji),f(g.wpemoji)))}(window,document,window._wpemojiSettings);
</script>




