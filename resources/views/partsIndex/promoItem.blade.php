<a href="{{ url($item['link']) }}" class="row promo-item__link col-sm-4 padding__collapse margin__collapse">
	<div class="promo-item__about col-sm-8 margin__collapse">
		<div class="title__container text-uppercase font-weight-normal">
			{!! $item['header'] !!}
		</div>

		<div class="content__container font-weight-light">
			{!! $item['content'] !!}
		</div>
	</div>

	<div class="promo-item__icon col-sm-4 padding__collapse margin__collapse" style="background-image: url('{{ asset('uploads/' . $item['icon']) }}');"></div>
</a>