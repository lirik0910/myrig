<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		@include('base.meta')
	</head>

	<body>
		<div id="root__container" class="root__container">
			@include('base.header')
			@yield('content')
			@include('base.footer')
		</div>
	</body>
</html>