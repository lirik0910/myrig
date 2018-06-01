<meta charset="UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta lang="{{ $locale }}" />

<title>{{ htmlentities($it->title) }}</title>
<meta name="description" content="{{ htmlentities($it->description) }}" />
<base href="{{ asset('/') }}" />

<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="format-detection" content="telephone=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="google-site-verification" content="YroKW8N1nmTvNHctf_WMuPtVYhPqE4bklPM-o6buvrc" />
<link rel="stylesheet" href="{{ asset('css/critical.css') }}">