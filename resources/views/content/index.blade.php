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

                <div class="main-slider owl-carousel owl-theme" id="mainSlider">
                    @foreach($products as $product)
                        <div class="main-slide" data-dot="<span><p class='dashnav-progress'></p></span>">
                            <div class="container">
                                <div class="slide-text">
                                    <div class="title"><!--:ru-->{{ $product->title }}<!--:--></div>
                                    <div class="subtitle"><!--:ru-->{{ $product->options[0]->value }}<!--:--></div>
                                    <a href="{{url('/shop')}}" class="btn-default" data-wpel-link="internal">Подробнее</a>
                                </div>
                                <div class="slide-img" style="background-image: url({{asset($product->icon)}})"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    <!-- ========popup======= -->

    <div class="container_black animated fadeIn" style="width: 100%; height: 100%;background: rgba(0,0,0,.4);
display: none; justify-content: center; align-content: center; top: 0; position: absolute; z-index: 99999; padding-top: 100px;" >

        <div class="contain" style="width: 310px; height: 395px; display: flex; flex-direction: column; border-bottom: 4px solid #60a645; background: #fff;">
            <header style="height: 55px; display: flex; justify-content: space-between; border-bottom: 2px solid #f2f2f2; align-items: center;">
                <h2 style="width: 80%; margin: 0; padding-left: 20px; font-size: 20px; color: #000; font-weight: bold;">Единые номера</h2>
                <span class="close_pop" style="width: 20%; height: 100%; background: #60a645; color: #fff; background-image: url({{URL::asset('images/close_popup.png')}}); background-repeat: no-repeat; background-position: center center;"></span>
            </header>

            <section style="display: flex; flex-direction: column; align-content: center; padding-left: 20px; margin-top: 20px;">




                <a href="tel:+380443607958" target="_blank" class="country" style="
                    /*border: 1px solid #000; */
                    display: flex;
                    height: 50px;
                    align-content: center;
                    align-items: center;
                    text-decoration: none;
                    margin-bottom: 10px;
                    " data-wpel-link="internal">

                    <div class="icon" style="width: 40px; height: 40px; background: #60a645;  border-radius: 30px; ">

                        <i class="fa fa-phone" aria-hidden="true" style="font-size: 25px; color: #fff; padding: 8px 10px;"></i>
                    </div>

                    <div class="text" style="padding-left: 10px;">
                        <h3 style="margin: 0; color: #000; font-size: 20px; font-weight: bold;">+38 044 360-79-58</h3>
                        <p style="margin: 0; color: #999999; font-weight: 200;">Украина</p>
                    </div>
                </a>

                <a href="tel:+74999187389" target="_blank" class="country" style="
                    /*border: 1px solid #000; */
                    display: flex;
                    height: 50px;
                    align-content: center;
                    align-items: center;
                    text-decoration: none;
                    margin-bottom: 10px;
                    " data-wpel-link="internal">

                    <div class="icon" style="width: 40px; height: 40px; background: #60a645;  border-radius: 30px; ">

                        <i class="fa fa-phone" aria-hidden="true" style="font-size: 25px; color: #fff; padding: 8px 10px;"></i>
                    </div>

                    <div class="text" style="padding-left: 10px;">
                        <h3 style="margin: 0; color: #000; font-size: 20px; font-weight: bold;">+7 499 918-73-89</h3>
                        <p style="margin: 0; color: #999999; font-weight: 200;">Россия</p>
                    </div>




                </a>

                <a href="https://t.me/myrigsales" target="_blank" class="country" style="
                    /*border: 1px solid #000; */
                    display: flex;
                    height: 50px;
                    align-content: center;
                    align-items: center;
                    text-decoration: none;
                    margin-bottom: 10px;
                    " data-wpel-link="external" rel="nofollow external noopener noreferrer">

                    <div class="icon" style="width: 40px; height: 40px; background: #2498d4;  border-radius: 30px; ">

                        <i class="fa fa-paper-plane" aria-hidden="true" style="font-size: 20px; color: #fff; padding: 10px 8px;"></i>
                    </div>

                    <div class="text" style="padding-left: 10px;">
                        <h3 style="margin: 0; color: #2498d4; font-size: 20px; font-weight: bold; text-transform: capitalize;">Продажа</h3>
                    </div>
                </a>

                <a href="https://t.me/myrighosting" target="_blank" class="country" style="
                    /*border: 1px solid #000; */
                    display: flex;
                    height: 50px;
                    align-content: center;
                    align-items: center;
                    text-decoration: none;
                    margin-bottom: 10px;
                    " data-wpel-link="external" rel="nofollow external noopener noreferrer">

                    <div class="icon" style="width: 40px; height: 40px; background: #2498d4;  border-radius: 30px; ">

                        <i class="fa fa-paper-plane" aria-hidden="true" style="font-size: 20px; color: #fff; padding: 10px 8px;"></i>
                    </div>

                    <div class="text" style="padding-left: 10px;">
                        <h3 style="margin: 0; color: #2498d4; font-size: 20px; font-weight: bold; text-transform: capitalize;">Хостинг</h3>
                    </div>
                </a>

                <a href="https://t.me/myrigservice" target="_blank" class="country" style="
                    /*border: 1px solid #000; */
                    display: flex;
                    height: 50px;
                    align-content: center;
                    align-items: center;
                    text-decoration: none;
                    margin-bottom: 10px;
                    " data-wpel-link="external" rel="nofollow external noopener noreferrer">

                    <div class="icon" style="width: 40px; height: 40px; background: #2498d4;  border-radius: 30px; ">

                        <i class="fa fa-paper-plane" aria-hidden="true" style="font-size: 20px; color: #fff; padding: 10px 8px;"></i>
                    </div>

                    <div class="text" style="padding-left: 10px;">
                        <h3 style="margin: 0; color: #2498d4; font-size: 20px; font-weight: bold; text-transform: capitalize;">Сервис</h3>
                    </div>
                </a>

                <a href="https://myrig.com.ua/article/vnimaniyu-klientov-myrig-informatsiya-o-reorganizatsii-svyazi/" target="_blank" class="pop_about" style="background: #60a645;
    text-decoration: none;
    color: #fff;
    display: block;
    width: 110px;
    height: 41px;
    text-align: center;
    line-height: 38px;
    margin: 0 auto 20px;
	margin-left: 80px;" data-wpel-link="internal">Подробнее</a>
            </section>
        </div>

    </div>

    <script>
        var modal = document.querySelector('.container_black');
        var close = document.querySelector('.close_pop');

        setTimeout(function open() {
            modal.style.display = "flex";
        }, 1000);

        close.onclick = function () {
            modal.style.display = "none";
        }
    </script>

    <!-- ========end popup========= -->
    <section class="banners">
        <div class="container">
            <div class="row">
                <a href="{{url('/news')}}" class="banner col-sm-4" data-wpel-link="internal">
                    <div class="banner-text">
                        <div class="title"><!--:ru-->НОВОСТИ<!--:--></div>
                        <div class="subtitle"><!--:ru-->Последние события мира криптовалют<!--:--></div>
                    </div>
                    <div class="banner-back" style="background-image: url({{URL::asset('images/icon_Anton-02.svg')}})  ;    top: 37px ; width: 80px;
    right: 54px; left: 300px;"></div>
                </a>
                <a href="{{url('/calculator')}}" class="banner col-sm-4" data-wpel-link="internal">
                    <div class="banner-text">
                        <div class="title"><!--:ru-->КАЛЬКУЛЯТОР<!--:--></div>
                        <div class="subtitle"><!--:ru-->Правильный расчет прибыли от майнинга<!--:--></div>
                    </div>
                    <div class="banner-back" style="background-image: url({{URL::asset('images/calc.svg')}})  ;    top: 37px ; width: 80px;
    right: 54px; left: 300px;"></div>
                </a>
                <a href="{{url('/info')}}" class="banner col-sm-4" data-wpel-link="internal">
                    <div class="banner-text">
                        <div class="title"><!--:ru-->ИНФОРМАЦИЯ<!--:--></div>
                        <div class="subtitle"><!--:ru-->Полезная информация и новости компании<!--:--></div>
                    </div>
                    <div class="banner-back" style="background-image: url({{URL::asset('images/articles.svg')}})  ;    top: 37px ; width: 80px;
    right: 54px; left: 300px;"></div>
                </a>

            </div>
        </div>
    </section>
</main>
@endsection