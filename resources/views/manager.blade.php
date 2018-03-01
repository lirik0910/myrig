<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{URL::asset('static/css/' . $css)}}" />
	<title>Manager</title>
</head>

<body>
	<div id="root"></div>
	<script src="{{URL::asset('static/js/' . $js)}}"></script>
	<script type="text/javascript">
		window.site = {
			uploads_url: "{{URL::asset('uploads/')}}",
		}
	</script>
</body>
</html>