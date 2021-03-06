<meta charset="UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta lang="{{ $locale }}" />

<title>{{ htmlentities($it->title) }}</title>
<meta name="description" content="{{ htmlentities($it->description) }}" />
<base href="{{ asset('/') }}" />

<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="format-detection" content="telephone=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="apple-touch-icon" sizes="57x57" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="60x60" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="72x72" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="76x76" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="114x114" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="120x120" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="144x144" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="152x152" href="/favicon/fav-new.png">
<link rel="apple-touch-icon" sizes="180x180" href="/favicon/fav-new.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/favicon/fav-new.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon/fav-new.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon/fav-new.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon/fav-new.png">
<link rel="manifest" href="/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/favicon/fav-new.png">
<meta name="theme-color" content="#ffffff">

<meta name="google-site-verification" content="YroKW8N1nmTvNHctf_WMuPtVYhPqE4bklPM-o6buvrc" />
<style>@font-face{font-family:Roboto;src:url(/fonts/RobotoRegular.ttf?290793a328775e85f880f7da86503cd2) format("truetype");src:url(/fonts/RobotoRegular.eot?eee713d6454874d4d1d8babd8dd562cf),url(/fonts/RobotoRegular.eot?eee713d6454874d4d1d8babd8dd562cf) format("embedded-opentype"),url(/fonts/RobotoRegular.woff?18b2429ba6e7179daeec5438639ab65f) format("woff");font-weight:400;font-style:normal}@font-face{font-family:Roboto;src:url(/fonts/RobotoBold.eot?cbb753be961007a7e782f57f7eacbc94);src:url(/fonts/RobotoBold.eot?cbb753be961007a7e782f57f7eacbc94) format("embedded-opentype"),url(/fonts/RobotoBold.woff?af01b5037ff63cf05210745f4c248269) format("woff"),url(/fonts/RobotoBold.ttf?b2c24342409e47baaeb690d76cbd7df3) format("truetype");font-weight:700;font-style:normal}@font-face{font-family:Roboto;src:url(/fonts/RobotoMedium.eot?6646320247af520dbd6fd3e9c0192f65);src:url(/fonts/RobotoMedium.eot?6646320247af520dbd6fd3e9c0192f65) format("embedded-opentype"),url(/fonts/RobotoMedium.woff?5ca830617cdc06dbc5e2d46878bba8b1) format("woff"),url(/fonts/RobotoMedium.ttf?9f69ecf8a3c39b994ebd5bed7d284f58) format("truetype");font-weight:600;font-style:normal}@font-face{font-family:Roboto;src:url(/fonts/RobotoLight.eot?fd160a7ab05613cd3a733e0046995d92);src:url(/fonts/RobotoLight.eot?fd160a7ab05613cd3a733e0046995d92) format("embedded-opentype"),url(/fonts/RobotoLight.woff?1d638d89cf0cf96babe6efef7fc4d388) format("woff"),url(/fonts/RobotoLight.ttf?e025164d56e8e3c156d41d989b3cdf1b) format("truetype");font-weight:300;font-style:normal}body,html{margin:0;padding:0;width:100%;height:auto;font-size:16px;overflow-x:hidden;font-family:Roboto,sans-serif!important}button,button:focus,input,input:focus,input[type=submit],select,select:focus,textarea,textarea:focus{resize:none!important;border:none;outline:none!important}input.input__border{border:1px solid #60a645}button,label{cursor:pointer!important}a.default__link{color:#60a645;text-decoration:none}a.default__link:hover,a:hover{color:#000;text-decoration:underline}.d-block-991,.d-inline-block-991{display:none}@media (max-width:991px){.d-none-991{display:none!important}.d-block-991{display:block}.d-inline-block-991{display:inline-block}}.root__container{overflow:hidden}@media (max-width:767px){.default__container{width:100%!important}}@media (min-width:768px){.default__container{width:728px!important;max-width:728px!important}}@media (min-width:992px){.default__container{width:960px!important;max-width:960px!important}}@media (min-width:1250px){.default__container{width:1220px!important;max-width:1220px!important}}.margin__collapse{margin:0!important}.padding__collapse{padding:0!important}.list__container{list-style:none!important}.field__grey,.field__grey:focus,.field__input,.field__input:focus{padding:0;width:100%;height:40px;line-height:1.2;margin:0 0 15px;border-bottom:1px solid #60a645}.field__grey,.field__grey:focus{border-bottom:1px solid #c5c5c5}.dark__container{top:0;right:0;z-index:-1;width:100%;height:100%;position:fixed;background-color:#f2f2f2}</style>