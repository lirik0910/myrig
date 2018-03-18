@extends('layouts.app')

@section('content')
<main>
    <div class="main-back"  ></div>
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
    <section class="content list">
        <div class="container">
            @php
                $page_limit = 10;
                $page_no = $request->get('page');
                if(isset($page_no)){
                    $news = App\Model\Base\Page::where('parent_id', $it->id)->offset($page_limit * ($page_no - 1))->orderBy('created_at', 'DESC')->paginate($page_limit);
                } else{
                    $news = App\Model\Base\Page::where('parent_id', $it->id)->orderBy('created_at', 'DESC')->paginate($page_limit);
                }

            @endphp
            @foreach($news as $article)
                <div class="article-row row">
                    <div class="col-sm-4">
                        <h2 style="word-wrap: break-word"><a href="{{url($article->link)}}" data-wpel-link="internal">{{$article->title}}</a></h2>
                        <div class="date">@php echo date('d F', strtotime($article->created_at)) @endphp<i class="fa fa-eye"></i>0</div>
                    </div>
                    <div class="article-content col-sm-8">
                        <div class="article-text">
                            @if (empty($article->introtext))
                                @php
                                    $introtext = substr(strip_tags($article->content), 0, 400);
                                    $introtext = rtrim($introtext, '!,.-');
                                    $introtext = substr($introtext, 0, strrpos($introtext, ' '));
                                @endphp

                                {{ $introtext . '...' }}
                            @else
                                <p>{!! $article->introtext !!}</p>
                            @endif
                            <a href="{{url($article->link)}}" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Read</a>
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
