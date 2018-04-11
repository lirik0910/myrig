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
                            <p>MYRIG is the only official representative from the plant to provide post-warranty services for Bitmain equipment. Our company provides support and repair services for miners and components throughout Ukraine and Russia.</p>
                            <p><span style="color: #60a644;"><strong>Our service center is ready to help you with the following questions:</strong></span></p>
                            <ul>
                                <li>Support for the extended warranty program from MyRig;</li>
                                <li>Repair of Antminer miners of all models and any complexity;</li>
                                <li>Restore all Bitmain power supplies;</li>
                                <li>Software and hardware recovery of hashtas and spare parts for Antminer;</li>
                                <li>Technical consultation.</li>
                            </ul>
                            <p>Get information from our support team very easily. To do this, follow the link below and fill in the required fields, in a short time our specialists will contact you.</p>
                            <p><a class="btn-default reg-c" href="#ticket" data-wpel-link="internal">Create ticket</a></p>
                            <p> <strong><span style="color: #60a600;">Contacts for communication</span></strong><br />
                                +38 (044) 360-79-58 Ukraine</p>
                            <p>+7 (499) 918-73-89 Russia</p>
                            <p>+1-844-248-62-46 USA</p>
                            <p>Telegram &#8212; <span style="color: #2ba1df;"><a style="color: #2ba1df;" href="http://t.me/myrigservice" data-wpel-link="external" rel="nofollow external noopener noreferrer">@myrigservice</a></span><br />
                                support@myrig.com  </p>
                            <p><strong><span style="color: #60a600;">Schedule</span></strong><br />
                                Monday &#8212; Friday<br />
                                10:00 &#8212; 19:00</p>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection