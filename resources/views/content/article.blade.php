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
                        <a href="{{asset('/news')}}" class="article-link" data-wpel-link="internal"><i class="article-arrow"></i>Назад к списку</a>
                        <h1>Бутерин планирует запустить шардинг в тестнете Ethereum</h1>
                        <div class="date">24 февраля 2018<i class="fa fa-eye"></i>10</div>
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

                            <script async src="https://static.addtoany.com/menu/page.js"></script>
                            <!-- AddToAny END -->
                        </div>
                    </div>
                    <div class="article-content col-sm-8">
                        <div class="article-text">
                            <p><img class="aligncenter size-large wp-image-5688" src="https://myrig.com.ua/wp-content/uploads/2018/02/1_HNAOhmNuaOY766JIwlIoRQ-1024x682.jpeg" alt="myrig_news_24.02.18(3)" width="960" height="100%" srcset="https://myrig.com.ua/wp-content/uploads/2018/02/1_HNAOhmNuaOY766JIwlIoRQ-1024x682.jpeg 1024w, https://myrig.com.ua/wp-content/uploads/2018/02/1_HNAOhmNuaOY766JIwlIoRQ-300x200.jpeg 300w, https://myrig.com.ua/wp-content/uploads/2018/02/1_HNAOhmNuaOY766JIwlIoRQ-768x512.jpeg 768w, https://myrig.com.ua/wp-content/uploads/2018/02/1_HNAOhmNuaOY766JIwlIoRQ-47x31.jpeg 47w, https://myrig.com.ua/wp-content/uploads/2018/02/1_HNAOhmNuaOY766JIwlIoRQ-190x127.jpeg 190w, https://myrig.com.ua/wp-content/uploads/2018/02/1_HNAOhmNuaOY766JIwlIoRQ.jpeg 1600w" sizes="(max-width: 1024px) 100vw, 1024px" /></p>
                            <p>Сегодня как никогда актуальна тема поиска новых решений для масштабирования блокчейна. Вот и основатель Ethereum Виталик Бутерин при обсуждении криптовалютного скама на просторах соцсети Twitter намекнул на начало тестирования шардинга. При этом он отметил, что Leeroy может стать участником этого эксперимента. В результате последовали комментарии, в одном из которых был задан вопрос насчет возможности верификации Twitter-аккаунтов на блокчейне. Бутерин ответил, что, скорее всего, им представится возможность принять участие в тестнете для шардинга. Правда, ответ впоследствии был скрыт.</p>
                            <p>Основатель Ethereum вместе со старшим разработчиком Ником Джонсоном не раз акцентировали внимание на важности шардинга при переходе сети на PoS для верификации транзакций в Ethereum (сейчас используется алгоритм PoW).</p>
                            <p>Прошлогодней осенью Бутерин озвучивал свое желание в течение трех-пяти лет увеличить объем обработки транзакций в сети Ethereum до уровня Visa (сейчас Ethereum обрабатывает за минуту 10-30 транзакций, а аналогичный показатель Visa составляет 1500). Причем одним из компонентов достижения этой цели, по его мнению, являлся шардинг. Суть данной техники заключается в следующем: сеть разбивается на отдельные сегменты (шарды), каждый из которых содержит свою собственную структуру и историю транзакций. Ее внедрение позволит повысить эффективность обработки транзакций без перегрузки сети. Неясным остается лишь то, сколько займет интеграция Ethereum с протоколом шардинга</p>
                        </div>
                        <div class="links">
                            <a href="https://myrig.com.ua/2018/02/24/bitmain-operedil-nvidia-po-pribyili-za-2017-g/" class="article-link" data-wpel-link="internal"><i class="article-arrow"></i>Предыдущая статья</a>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection