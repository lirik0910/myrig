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
        <section class="content single-article">
            <div class="container">
                @php
                    $parent_link = App\Model\Base\Page::select('link')->where('id', $it->parent_id)->first();
                    $prev_link = App\Model\Base\Page::select('link')->where('parent_id', $it->parent_id)->where('id', '<', $it->id)->orderBy('id', 'DESC')->limit(1)->first();
                    $next_link = App\Model\Base\Page::select('link')->where('parent_id', $it->parent_id)->where('id', '>', $it->id)->orderBy('id', 'ASC')->limit(1)->first();
                @endphp
                <div class="row">
                    <div class="col-sm-4">
                        <a href="{{url($parent_link->link)}}" class="article-link" data-wpel-link="internal"><i class="article-arrow"></i>Back to list</a>
                        <h1>{{$it->title}}</h1>
                        <div class="date">@php echo date('d F', strtotime($it->created_at)) @endphp<i class="fa fa-eye"></i>10</div>
                        <div class="article-social">
                            <div class="a2a_kit">
                                <a class="a2a_button_facebook" data-wpel-link="internal">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a class="a2a_button_twitter" data-wpel-link="internal">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a class="a2a_button_vk" data-wpel-link="internal">
                                    <i class="fa fa-vk"></i>
                                </a>
                                <a class="a2a_button_telegram" data-wpel-link="internal">
                                    <i class="fa fa-send"></i>
                                </a>
                            </div>

                            <!--<script async src="https://static.addtoany.com/menu/page.js"></script>-->
                            <!-- AddToAny END -->
                        </div>
                    </div>
                    <div class="article-content col-sm-8">
                        <div class="article-text">
                            {{$it->content}}
                        </div>
                        <div class="links">
                            @isset($prev_link)<a href="{{url($prev_link->link)}}" class="article-link" data-wpel-link="internal"><i class="article-arrow"></i>Previous article</a>@endisset @isset($next_link)<a href="{{url($next_link->link)}}" class="article-link next-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Next article</a>@endisset
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection