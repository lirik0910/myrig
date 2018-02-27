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

                        <h1>Локальное сервисное обслуживание</h1>

                    </div>
                    <div class="article-content col-sm-8">
                        <div class="article-text">
                            <p>Компания MYRIG является единственным официальным представителем от завода по предоставлению услуг послегарантийного обслуживания оборудования Bitmain. Наша компания предоставляет услуги поддержки и ремонта майнеров и комплектующих по всей территории Украины и России.</p>
                            <p><span style="color: #60a644;"><strong>Наш сервисный центр готов вам помочь в следующих вопросах:</strong></span></p>
                            <ul>
                                <li>Поддержка по программе <strong><a href="https://myrig.ru/wrnt/" data-wpel-link="external" rel="nofollow external noopener noreferrer">расширенной гарантии</a> </strong>от MyRig;</li>
                                <li>Ремонт майнеров Antminer всех моделей и любой сложности;</li>
                                <li>Восстановление блоков питания Bitmain всех моделей;</li>
                                <li>Программное и аппаратное восстановление хешплат и запчастей для Antminer;</li>
                                <li>Техническая консультация.</li>
                            </ul>
                            <p>Получить информацию от нашей службы поддержки очень легко. Для этого пройдите по ссылке ниже и заполните необходимые поля, через короткое время с вами свяжутся наши специалисты.</p>
                            <p>Логистическая поддержка осуществляется нашими партнерами Нова Пошта, СДЭК и Деловые Линии.</p>
                            <p><a class="btn-default reg-c" href="#ticket" data-wpel-link="internal">Создать тикет</a></p>
                            <p> <strong><span style="color: #60a600;">Контакты для связи</span></strong><br />
                                +38 (044) 360-79-58 Украина</p>
                            <p>+7 (499) 918-73-89 Россия</p>
                            <p>Telegram &#8212; <span style="color: #2ba1df;"><a style="color: #2ba1df;" href="http://t.me/myrigservice" data-wpel-link="external" rel="nofollow external noopener noreferrer">@myrigservice</a></span><br />
                                support@myrig.com  </p>
                            <p><strong><span style="color: #60a600;">График работы</span></strong><br />
                                понедельник &#8212; пятница<br />
                                10:00 &#8212; 19:00</p>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection