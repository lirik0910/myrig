<div class="row row__container product-item__container margin__collapse">
	<div class="col-sm-4 row slider__container margin__collapse padding__collapse">
		<div class="border__container"></div>

		<h3 class="title__container font-weight-bold news-title__container margin__collapse">
			<a href="{{ asset($article->link) }}" class="default__link">{{ $article->title }}</a>
		</h3>

		<div class="news-option__container d-block">
			@php
				$month = date('F', strtotime($article->created_at));
				$default = 'common.';
				$translate = $default . strtolower($month);
				echo date('d', strtotime($article->created_at)) . ' ' . __($translate);
			@endphp
			<i class="fa fa-eye" style="margin-left: 18px"></i>

			@if ($article->visits)
				{{ $article->visits->count }}
			@else 
				0
			@endif
		</div>
	</div>

	<div class="col-sm-8 product-content__container news-content__container margin__collapse">
		<div class="border__container"></div>

		<div class="content__container font-weight-light">
			@if (empty($article->introtext))
				@php
					$introtext = substr(strip_tags($article->content), 0, 450);
					$introtext = rtrim($introtext, '!,.-');
					$introtext = substr($introtext, 0, strrpos($introtext, ' '));
				@endphp

				{!! $introtext . '...' !!}
			@else
				<p>{!! $article->introtext !!}</p>
			@endif

			<a href="{{ url($article->link )}}" class="default__link">
				<i class=""></i>
				{{ __('default.read') }}
			</a>
		</div>
	</div>
</div>