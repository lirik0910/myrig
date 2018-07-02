@php
	if (env('LOCAL_SPACE') === 'dev') {
		$js = 'http://localhost:3000/static/js/bundle.js';
		$config = 'http://localhost:3000/config.js';
	}

	else {
		$currentPage = explode('/', URL::current());

		if (end($currentPage) === 'orders') {
			$js = URL::asset('js/manager/static/js/managerBundle.js');
		}
		else {
			$js = URL::asset('static/js/' . $js);
		}
		$config = URL::asset('js/manager/config.js');
	}
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}">

	@if ((env('LOCAL_SPACE') !== 'dev'))
	<link rel="stylesheet" href="{{ URL::asset('static/css/' . $css) }}" />
	@endif
	<link rel='stylesheet' href='/css/woocommerce.css?ver=3.2.6' type='text/css' media='all' />
	<title>Manager</title>

	<script type="text/javascript">
		var global = {
			app: {
				baseUrl: "{{ URL::asset('/') }}",
				uploadsUrl: "{{ URL::asset('uploads/') }}",
				managerUrl: "{{ URL::asset('/xlle76n10f') }}",
				managerApiUrl: "{{ URL::asset('/xlle76n10f/api') }}",
			}
		}
	</script>

	<style>.mark:before {font-family: WooCommerce;speak: none;margin-right: 6px;}.mark.cancelled:before {content: '\e013';}.mark.neworder:before {content: "\e016";}.mark.inalocalwarehouse:before,.mark.shippedbythefactory:before {content: '\e033';}.mark.processing:before {content: '\e011';}		.mark.waitingforpayment:before {content: '\e012';}.mark.completed:before {content: '\e015';}.mark.returned:before {content: '\e014';}.mark.hasbeenpaid:before {content: "\e604";}</style>
</head>

<body style="margin: 0; padding: 0; height: 100%">
	<a id="blank-default-link" target="_blank" style="display: none"></a>
	<div id="root" style="overflow-x: hidden; height: 100%"></div>
	<script type="text/javascript" src="{{ $config }}"></script>
	<script type="text/javascript" src="{{ $js }}"></script>
</body>
</html>