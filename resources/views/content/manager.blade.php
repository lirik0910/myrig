<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{URL::asset('static/css/' . $css)}}" />
	<link rel='stylesheet' href='/css/woocommerce.css?ver=3.2.6' type='text/css' media='all' />
	<title>Manager</title>

	<script type="text/javascript">
		var global = {
			app: {
				baseUrl: "{{URL::asset('/')}}",
				uploadsUrl: "{{URL::asset('uploads/')}}",
				managerUrl: "{{URL::asset('/manager')}}",
				managerApiUrl: "{{URL::asset('/manager/api')}}",
			}
		}
	</script>
</head>

<body>
	<div id="root"></div>
	<script src="{{URL::asset('static/js/' . $js)}}"></script>
</body>
</html>