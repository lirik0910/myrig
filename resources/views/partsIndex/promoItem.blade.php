<a href="{{ url($item['link']) }}" class="promo-item__link col-sm-4 font-weight-light">
	<div class="promo-item__about">
		<div class="title__container">
			{!! $item['header'] !!}
		</div>

		<div class="content__container">
			{!! $item['content'] !!}
		</div>
	</div>

	<div class="promo-item__icon" style="background-image: url('{{ asset('uploads/' . $item['icon']) }}');"></div>
</a>