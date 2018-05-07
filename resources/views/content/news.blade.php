@extends('layouts.app')

@section('content')
<main style="width: 100%">
    <div class="main-back" style="position: absolute;"></div>
    <section class="content list">
        <div class="container">
            @php
                $page_limit = 10;
                $page_no = $request->get('page');

                $ua_parent_page = \App\Model\Base\Page::where('link', $it->link)->where('context_id', 2)->first();
                $ru_parent_page = \App\Model\Base\Page::where('link', $it->link)->where('context_id', 3)->first();

                if(isset($page_no)){
                    $news = App\Model\Base\Page::where('parent_id', $ua_parent_page->id)->orWhere('parent_id', $ua_parent_page)->offset($page_limit * ($page_no - 1))->orderBy('created_at', 'DESC')->paginate($page_limit);
                } else{
                    $news = App\Model\Base\Page::where('parent_id', $ua_parent_page->id)->orWhere('parent_id', $ru_parent_page->id)->orderBy('created_at', 'DESC')->paginate($page_limit);
                }
            @endphp
            @foreach($news as $article)
                <div class="article-row row">
                    <div class="col-sm-4">
                        <h2 style="word-wrap: break-word"><a href="{{url($article->link)}}" data-wpel-link="internal">{{$article->title}}</a></h2>
                        <div class="date">@php echo date('d F', strtotime($article->created_at)) @endphp<i class="fa fa-eye"></i>@if($article->visits){{$article->visits->count}}@else 0 @endif</div>
                    </div>
                    <div class="article-content col-sm-8">
                        <div class="article-text" style="word-wrap: break-word;">
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
                            <a href="{{url($article->link)}}" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>{{ __('default.read') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
            @isset($news)
                {{$news->links()}}
            @endisset
        </div>
            <!--<div class="  text-center"><ul class="pagination text-center"><li ><span aria-current='page' class='page-numbers current'>1</span></li><li ><a class="page-numbers" href="https://myrig.com.ua/news/page/2/" data-wpel-link="internal">2</a></li><li ><span class="page-numbers dots">&hellip;</span></li><li ><a class="page-numbers" href="https://myrig.com.ua/news/page/29/" data-wpel-link="internal">29</a></li><li ><a class="next page-numbers" href="https://myrig.com.ua/news/page/2/" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i></a></li></ul></div>        </div>-->
    </section>
</main>
@endsection
