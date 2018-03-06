@extends('layouts.app')

@section('content')
<main>

<div class="main-back"></div>
<script>
	var width = $(window).width();
	var cont = $('.container').outerWidth();
	var margin = (width - cont) / 2;
	var wM = cont * 33.333333 / 100 + margin;
	
	if (width > 767) {
		$('.main-back').css('left', wM +'px');
	}
	else {
		$('.main-back').css('left', '0px');
	}
</script>
	
<section class="content item">
	<div class="container">
	</div>
</section>


</main>
@endsection