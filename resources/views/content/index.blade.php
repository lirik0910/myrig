@extends('layouts.app')

@section('content')

<main>
    <div class="main-back"></div>
    <script>
        var width = $(window).width();
        var cont = $('.container').outerWidth();
        var margin = (width - cont) / 2;
        var wM = cont * 33.333333 / 100 + margin;
        if (width >767) {
            $('.main-back').css('left', wM +'px');
        }
        else {
            $('.main-back').css('left', '0px');
        }
    </script>
    <section class="slider">
        <div class="container-fluid">
            <div class="row">
                @php
                    $products = App\Model\Shop\Product::where('category_id', 1)->where('active', 1)->orderBy('price', 'DESC')->with('options')->limit(4)->get();
                @endphp
                <div class="main-slider owl-carousel owl-theme" id="mainSlider">
                    @if(isset($products))
                        @foreach($products as $product)
                            <div class="main-slide" data-dot="<span><p class='dashnav-progress'></p></span>">
                                <div class="container">
                                    <div class="slide-text">
                                        <div class="title"><!--:ru-->{{ $product->title }}<!--:--></div>
                                        <div class="subtitle"><!--:ru-->@foreach($product->options as $option) @if($option->name == 'introtext') {{$option->value}} @endif @endforeach<!--:--></div>
                                        <a href="{{url('/shop')}}" class="btn-default" data-wpel-link="internal">Подробнее</a>
                                    </div>
                                    <div class="slide-img" style="background-image: url({{asset($product->icon)}})"></div>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
    </section>

    <section class="banners">
        <div class="container">
            <div class="row">
                <a href="{{url('/news')}}" class="banner col-sm-4" data-wpel-link="internal">
                    <div class="banner-text">
                        <div class="title"><!--:ru-->News<!--:--></div>
                        <div class="subtitle"><!--:ru-->Actual information about the world of cryptocurrency<!--:--></div>
                    </div>
                    <div class="banner-back" style="background-image: url({{URL::asset('images/icon_Anton-02.svg')}})  ;    top: 37px ; width: 80px;
    right: 54px; left: 300px;"></div>
                </a>
                <a class="banner col-sm-4" data-wpel-link="internal">
                    <div class="banner-text">
                        <div class="title"><!--:ru-->Calculator<!--:--></div>
                        <div class="subtitle"><!--:ru-->Correct calculation of profit from mining<!--:--></div>
                    </div>
                    <div class="banner-back" style="background-image: url({{URL::asset('images/calc.svg')}})  ;    top: 37px ; width: 80px;
    right: 54px; left: 300px;"></div>
                </a>
                <a href="{{url('/info')}}" class="banner col-sm-4" data-wpel-link="internal">
                    <div class="banner-text">
                        <div class="title"><!--:ru-->Articles<!--:--></div>
                        <div class="subtitle"><!--:ru-->Analytics, equipment reviews<!--:--></div>
                    </div>
                    <div class="banner-back" style="background-image: url({{URL::asset('images/articles.svg')}})  ;    top: 37px ; width: 80px;
    right: 54px; left: 300px;"></div>
                </a>

            </div>
        </div>
    </section>
</main>
@endsection