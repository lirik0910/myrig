@extends('layouts.app')

@section('content')

@php
$parent_link = App\Model\Base\Page::select('link')
	->where('id', $it->parent_id)
	->first();

$prev_link = App\Model\Base\Page::select('link')
	->where('parent_id', $it->parent_id)
	->where('id', '<', $it->id)
	->orderBy('id', 'DESC')
	->limit(1)->first();

$next_link = App\Model\Base\Page::select('link')
	->where('parent_id', $it->parent_id)
	->where('id', '>', $it->id)
	->orderBy('id', 'ASC')
	->limit(1)
	->first();

$visits = $it->visits;
if (!$visits) {
	$it->visits()->create(['page_id' => $it->id, 'count' => 1]);
} else {
	$visits->count++;
	$visits->save();
}
//var_dump($parent_link); die;
@endphp

<div id="dark__container" class="dark__container"></div>

<div class="products__container default__container">
	<div class="row row__container product-item__container margin__collapse">
		<div class="d-block col-sm-4 slider__container margin__collapse padding__collapse" style="min-height: 300px">
			<div class="border__container"></div>

			@if($parent_link)
				<a href="{{ url($parent_link->link )}}" class="d-block default__link news-return__link font-weight-light">
					<i class="article-arrow-left__icon"></i>
					{{ __('default.back_to_list') }}
				</a>
			@endif
			
			<h3 class="title__container font-weight-bold news-title__container margin__collapse">
				{{ $it->title }}
			</h3>

			@if($parent_link)
				<div class="news-option__container d-block">
{{--					@php
						echo date('d F', strtotime($it->created_at))
					@endphp--}}
					@php
						$month = date('F', strtotime($it->created_at));
                        $default = 'common.';
                        $translate = $default . strtolower($month);
                        echo date('d', strtotime($it->created_at)) . ' ' . __($translate);
					@endphp
					<i class="fa fa-eye" style="margin-left: 18px"></i>

					@if ($visits)
						{{ $visits->count }}
					@else
						0
					@endif
				</div>
			@endif
		</div>

		<div class="col-sm-8 product-content__container news-content__container margin__collapse">
			<div class="border__container"></div>

			<div class="content__container font-weight-light">
				<p>{!! $it->content !!}</p>
			</div>
		</div>

		@if (isset($prev_link) && isset($next_link))
		<div class="d-block col-sm-4 margin__collapse padding__collapse"></div>
		<div class="d-block col-sm-8 margin__collapse" style="border-top: 1px solid #FFF; padding: 32px;">
			<div class="beside-items__container d-flex">
				@if($prev_link && $parent_link)
				<a href="{{ url($prev_link->link) }}" class="d-block default__link news-return__link font-weight-light" style="position: relative;">
					<i class="article-arrow-left__icon"></i>
					{{ __('default.previous_article') }}
				</a>
				@endif

				@if($next_link && $parent_link)
				<a href="{{ url($next_link->link) }}" class="d-block default__link news-return__link font-weight-light text-right" style="position: relative;">
					<i class="article-arrow-right__icon" style="float: right"></i>
					{{ __('default.next_article') }}
				</a>
				@endif
			</div>
		</div>
		@endif
	</div>
</div>
	
@endsection