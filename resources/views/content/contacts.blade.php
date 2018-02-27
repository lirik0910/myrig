@extends('layouts.app')

@section('content')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0VFdy6lo9DhNk0aeq0XlsShrLa_5jf9k" defer=""></script>
    <main class="contact-map">

        <div class="main-back">
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
            <div id="mapField" data-img="https://myrig.com.ua/wp-content/themes/bitmain/img/contact_logo.png?v=1" data-lat="39.768294" data-lng="-104.90209679999998"></div>
        </div>
        <section class="content contact">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="contact-item head-contact-item" data-lat="39.768294" data-lng="-104.90209679999998">
                            <p><!--:ru--></p>
                            <div class="country">USA</div>
                            <div class="service">Full Service</div>
                            <div class="add-info"></div>
                            <div class="address">3700 Quebec Street, Unit 100-239<br />
                                Denver, Colorado 80207</div>
                            <div class="phones">
                                <a href="tel:8442486246" data-wpel-link="internal">+1-844-248-62-46</a>
                            </div>
                            <p><!--:--></p>
                        </div>
                        <div class="contact-item " data-lat="55.755826" data-lng="37.617299900000035">
                            <p><!--:ru--></p>
                            <div class="country">RUSSIA</div>
                            <div class="service">Limited Service</div>
                            <div class="add-info"></div>
                            <div class="phones">
                                <a href="tel:+74999187389" data-wpel-link="internal">+7 499 918-73-89</a><br />
                                Telegram channel<br />
                                <a href="http://http://t.me/myrigservice" style="color: #2ba1df;" data-wpel-link="external" rel="nofollow external noopener noreferrer">@myrigsales</a></p></div>
                            <p><!--:--></p>
                        </div>
                        <div class="contact-item " data-lat="50.4501" data-lng="30.523400000000038">
                            <p><!--:ru--></p>
                            <div class="country">UKRAINE</div>
                            <div class="service">Limited Service</div>
                            <p></p>
                            <div class="phones">
                                <a href="tel:+380443607958" data-wpel-link="internal">+38 044 360-7958</a><br />
                                Telegram channel<br />
                                <a href="http://http://t.me/myrigservice" style="color: #2ba1df;" data-wpel-link="external" rel="nofollow external noopener noreferrer">@myrigsales</a></p></div>
                            <p><!--:--></p>
                        </div>
                        <div class="contact-item " data-lat="43.745711849705884" data-lng="142.38409996032715">
                            <p><!--:ru--></p>
                            <div class="country">Japan</div>
                            <div class="service">Limited Service </div>
                            <p></p>
                            <div class="address">Minami 9 Jo Dori 26 chome 589-57<br />
                                Asahikawa, Hokkaido 078-8339<br />
                                Japan</div>
                            <div class="add-info"> </div>
                            <div class="phones"></div>
                            <p><!--:--></p>
                        </div>
                        <div class="contact-item " data-lat="10.5072463" data-lng="-66.87855919999998">
                            <p><!--:ru--></p>
                            <div class="country">VENEZUELA</div>
                            <div class="service"> Very Limited Service</div>
                            <div class="add-info"></div>
                            <div class="phones">
                                <a href="tel:+5802127202127" data-wpel-link="internal">+58 0212 720-21-27</a>
                            </div>
                            <p><!--:--></p>
                        </div>


                    </div>
                    <div class="article-content col-sm-8">
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection