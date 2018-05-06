@extends('layouts.app')

@section('content')
    <main>
        <div class="main-back"></div>
        <section class="content single-article">
            <div class="container">
                @php
                    $parent_link = App\Model\Base\Page::select('link')->where('id', $it->parent_id)->first();
                    $prev_link = App\Model\Base\Page::select('link')->where('parent_id', $it->parent_id)->where('id', '<', $it->id)->orderBy('id', 'DESC')->limit(1)->first();
                    $next_link = App\Model\Base\Page::select('link')->where('parent_id', $it->parent_id)->where('id', '>', $it->id)->orderBy('id', 'ASC')->limit(1)->first();

                    $visits = $it->visits;
                    if(!$visits){
                        $it->visits()->create(['page_id' => $it->id, 'count' => 1]);
                    } else{
                        $visits->count++;
                        $visits->save();
                    }
                @endphp
                <div class="row">
                    <div class="col-sm-4">
                        <a href="{{url($parent_link->link)}}" class="article-link" data-wpel-link="internal"><i class="article-arrow"></i>{{ __('default.back_to_list') }}</a>
                        <h1 style="word-wrap: break-word">{{$it->title}}</h1>
                        <div class="date">@php echo date('d F', strtotime($it->created_at)) @endphp<i class="fa fa-eye"></i>@if($visits){{$visits->count}}@else 1 @endif</div>
					</div>
					<div class="article-content col-sm-8">
						<div class="article-text">
							{!! $it->content !!}
						</div>
						<div class="links">
							@isset($prev_link)<a href="{{url($prev_link->link)}}" class="article-link" data-wpel-link="internal"><i class="article-arrow"></i>{{__('default.previous_article')}}</a>@endisset @isset($next_link)<a href="{{url($next_link->link)}}" class="article-link next-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>{{__('next_article')}}</a>@endisset
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
@endsection