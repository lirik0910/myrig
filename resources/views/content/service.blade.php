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
                <div class="row">
                    <div class="col-sm-4">

                        <h1>{{ __('default.service_title') }}</h1>

                    </div>
                    <div class="article-content col-sm-8">
                        <div class="article-text">
                            <p>{{ __('default.description_service') }}</p>
                            <p><span style="color: #60a644;"><strong>Our service center is ready to help you with the following questions:</strong></span></p>
                            <ul>
                                <li>{{ __('default.first_li') }}</li>
                                <li>{{ __('default.second_li') }}</li>
                                <li>{{ __('default.third_li') }}</li>
                                <li>{{ __('default.fourth_li') }}</li>
                                <li>{{ __('default.fifth_li') }}</li>
                            </ul>
                            <p>{{ __('default.get_information') }}</p>
                            <p><a class="btn-default reg-c" href="#ticket" data-wpel-link="internal">{{ __('default.create_ticket') }}</a></p>
                            <p> <strong><span style="color: #60a600;">{{ __('default.contact_for_communication') }}</span></strong><br />
                                +38 (044) 360-79-58 Ukraine</p>
                            <p>+7 (499) 918-73-89 Russia</p>
                            <p>+1-844-248-62-46 USA</p>
                            <p>Telegram &#8212; <span style="color: #2ba1df;"><a style="color: #2ba1df;" href="http://t.me/myrigservice" data-wpel-link="external" rel="nofollow external noopener noreferrer">@myrigservice</a></span><br />
                                support@myrig.com  </p>
                            <p><strong><span style="color: #60a600;">{{ __('default.schedule') }}</span></strong><br />
                                {{ __('friday_monday') }}<br />
                                10:00 &#8212; 19:00</p>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection