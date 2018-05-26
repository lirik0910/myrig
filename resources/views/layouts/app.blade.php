<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
	<head>
		@include('base.meta')
	</head>

	<body class="home">
		@include('base.header')
		@yield('content')
		@include('base.footer')
	</body>
</html>