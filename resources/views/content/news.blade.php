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
                $news = App\Model\Base\Page::where('parent_id', 4)->limit(10)->get();
            @endphp
            @foreach($news as $article)
                <div class="article-row row">
                    <div class="col-sm-4">
                        <h2><a href="{{url($article->link)}}" data-wpel-link="internal">{{$article->title}}</a></h2>
                        <div class="date">@php echo date('d F', strtotime($article->created_at)) @endphp<i class="fa fa-eye"></i>0</div>
                    </div>
                    <div class="article-content col-sm-8">
                        <div class="article-text">
                            <p>{{$article->description}}</p>
                            <a href="{{url($article->link)}}" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Читать</a>
                        </div>
                    </div>
                </div>
            @endforeach

            <!--<div class="article-row row">
                <div class="col-sm-4">
                    <h2><a href="https://myrig.com.ua/2018/02/20/spros-na-btc-na-yuzhnokoreyskom-ryinke-uverenno-rastet/" data-wpel-link="internal">Спрос на BTC на южнокорейском рынке уверенно растет</a></h2>
                    <div class="date">20 февраля 2018<i class="fa fa-eye"></i>1</div>
                </div>
                <div class="article-content col-sm-8">
                    <div class="article-text">
                        <p>Как только спрос на цифровые валюты возобновился, южнокорейский рынок вновь стал лидером по объему биржевой торговли. В феврале на криптобиржах Южной Кореи зафиксирован наибольший объем сделок в BTC, а все благодаря тому, что регуляторы опровергли информацию насчет запрета трейдинга криптовалютами. В результате доверие к монетам на внутреннем рынке восстановилось. По наблюдениям южнокорейских СМИ, внутренняя торговля&#8230;</p>
                        <a href="https://myrig.com.ua/2018/02/20/spros-na-btc-na-yuzhnokoreyskom-ryinke-uverenno-rastet/" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Читать</a>
                    </div>
                </div>
            </div>

            <div class="article-row row">
                <div class="col-sm-4">
                    <h2><a href="https://myrig.com.ua/2018/02/19/hidden-wallet-analiz-problem-anonimnosti-v-seti-bitcoin/" data-wpel-link="internal">Hidden Wallet: анализ проблем анонимности в сети Bitcoin</a></h2>
                    <div class="date">19 февраля 2018<i class="fa fa-eye"></i>8</div>
                </div>
                <div class="article-content col-sm-8">
                    <div class="article-text">
                        <p>Создатель Hidden Wallet поделился на своей странице в Twitter информацией о технологиях отслеживания транзакций в сети Bitcoin и стратегиях безопасности. Он также высказал свое мнение о том, как разрабатываемые решения повышают анонимность пользователей. Сегодня существуют различные стратегии, позволяющие реализовать высокий уровень анонимности Bitcoin. Вполне возможно, что скрытые операции в сети станут дешевле. Сейчас компании, работающие&#8230;</p>
                        <a href="https://myrig.com.ua/2018/02/19/hidden-wallet-analiz-problem-anonimnosti-v-seti-bitcoin/" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Читать</a>
                    </div>
                </div>
            </div>

            <div class="article-row row">
                <div class="col-sm-4">
                    <h2><a href="https://myrig.com.ua/2018/02/19/visa-vzimala-udvoennyie-komissii-s-polzovateley-coinbase/" data-wpel-link="internal">Visa взимала удвоенные комиссии с пользователей Coinbase</a></h2>
                    <div class="date">19 февраля 2018<i class="fa fa-eye"></i>6</div>
                </div>
                <div class="article-content col-sm-8">
                    <div class="article-text">
                        <p>Visa признала свою вину за начисление удвоенных комиссий и необоснованное снятие средств с карт пользователей Coinbase. Проблемы у пользователей американской криптобиржи возникли еще на прошлой неделе: многие из них заявляли о необоснованном списании средств с кредитных и дебетовых карт. В результате эти сообщения оказались правдой. Coinbase обвинила в этом Visa, предположив, что это вызвано ошибками&#8230;</p>
                        <a href="https://myrig.com.ua/2018/02/19/visa-vzimala-udvoennyie-komissii-s-polzovateley-coinbase/" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Читать</a>
                    </div>
                </div>
            </div>

            <div class="article-row row">
                <div class="col-sm-4">
                    <h2><a href="https://myrig.com.ua/2018/02/17/tether-vyipustil-eur-i-usd-na-ethereum/" data-wpel-link="internal">Tether выпустил EUR₮ и USD₮ на Ethereum</a></h2>
                    <div class="date">17 февраля 2018<i class="fa fa-eye"></i>16</div>
                </div>
                <div class="article-content col-sm-8">
                    <div class="article-text">
                        <p>Tether выпустил 146 млн. токенов, из которых 86 млн. подкреплены евро (EUR₮), а 60 млн. – американским долларом (USD₮). Этому событию даже не помешали споры с аудитором и не самая лучшая репутация проекта. Новые EUR₮ и USD₮ созданы на основе Ethereum. У каждого из них имеются кошельки, в которых можно ознакомиться с текущим курсом цифровых&#8230;</p>
                        <a href="https://myrig.com.ua/2018/02/17/tether-vyipustil-eur-i-usd-na-ethereum/" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Читать</a>
                    </div>
                </div>
            </div>

            <div class="article-row row">
                <div class="col-sm-4">
                    <h2><a href="https://myrig.com.ua/2018/02/17/kapitalizatsiya-kriptoryinka-vyirosla-do-500-mlrd/" data-wpel-link="internal">Капитализация крипторынка выросла до $500 млрд</a></h2>
                    <div class="date">17 февраля 2018<i class="fa fa-eye"></i>13</div>
                </div>
                <div class="article-content col-sm-8">
                    <div class="article-text">
                        <p>Вместе с ростом курса Bitcoin и других популярных криптовалют возросла общая рыночная капитализация: она вновь преодолела порог в полтриллиона американских долларов. В последний раз аналогичная ситуация наблюдалась на крипторынке несколько недель назад. Однако начало текущего месяца нельзя назвать удачным, поскольку оно ознаменовано множеством новостей, в результате которых крипторынок в какой-то момент значительно просел до $280&#8230;</p>
                        <a href="https://myrig.com.ua/2018/02/17/kapitalizatsiya-kriptoryinka-vyirosla-do-500-mlrd/" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Читать</a>
                    </div>
                </div>
            </div>

            <div class="article-row row">
                <div class="col-sm-4">
                    <h2><a href="https://myrig.com.ua/2018/02/16/hardfork-litecoin-stimuliruet-rost-kursa-kriptovalyutyi/" data-wpel-link="internal">Хардфорк Litecoin стимулирует рост курса криптовалюты</a></h2>
                    <div class="date">16 февраля 2018<i class="fa fa-eye"></i>17</div>
                </div>
                <div class="article-content col-sm-8">
                    <div class="article-text">
                        <p>Чуть больше недели назад курс Litecoin снизился до $105. Более того, он потерял поддержку даже своего создателя Чарли Ли, поскольку тот объявил о продаже собственного Litecoin-состояния в конце 2017 г. Однако сейчас криптовалюта, находящаяся на пятом месте по капитализации, вновь начинает свое восхождение к вершине. С момента серьезного падения курс LTC вырос дна 100% (лишь&#8230;</p>
                        <a href="https://myrig.com.ua/2018/02/16/hardfork-litecoin-stimuliruet-rost-kursa-kriptovalyutyi/" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Читать</a>
                    </div>
                </div>
            </div>

            <div class="article-row row">
                <div class="col-sm-4">
                    <h2><a href="https://myrig.com.ua/2018/02/16/tainstvennomu-pokupatelyu-udalos-povyisit-kurs-btc-do-10-tyis/" data-wpel-link="internal">Таинственному покупателю удалось повысить курс BTC до $10 тыс.</a></h2>
                    <div class="date">16 февраля 2018<i class="fa fa-eye"></i>16</div>
                </div>
                <div class="article-content col-sm-8">
                    <div class="article-text">
                        <p>Этой ночью BTC удалось достичь отметки в $10 тыс., чего не случалось на протяжении нескольких недель. Правда, за этим повышением курса последовала незначительная коррекция. Такой резкий подъем обусловлен масштабной закупкой, которая осуществлялась в течение 4-х дней с одного Bitcoin-адреса. Ни для кого не секрет, что некоторых трейдеров вполне устраивала ситуация с понижением курса BTC, так&#8230;</p>
                        <a href="https://myrig.com.ua/2018/02/16/tainstvennomu-pokupatelyu-udalos-povyisit-kurs-btc-do-10-tyis/" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Читать</a>
                    </div>
                </div>
            </div>

            <div class="article-row row">
                <div class="col-sm-4">
                    <h2><a href="https://myrig.com.ua/2018/02/16/kvebek-privlek-bolee-100-maynerov/" data-wpel-link="internal">Квебек привлек более 100 майнеров</a></h2>
                    <div class="date">16 февраля 2018<i class="fa fa-eye"></i>16</div>
                </div>
                <div class="article-content col-sm-8">
                    <div class="article-text">
                        <p>В СМИ появилась информация о том, что Hydro-Quebec (Канада) намерен повысить тарифы на электричество для майнеров криптовалют, так как за последние месяцы компания получила слишком много заявок. По словам Марка-Антуана Пулио, занимающего должность пресс-секретаря Hydro-Quebec, в компанию обратилось больше 100 криптомайнинговых организаций, а некоторые из них уже обосновались в провинции. При этом для обслуживания отдельных&#8230;</p>
                        <a href="https://myrig.com.ua/2018/02/16/kvebek-privlek-bolee-100-maynerov/" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Читать</a>
                    </div>
                </div>
            </div>

            <div class="article-row row">
                <div class="col-sm-4">
                    <h2><a href="https://myrig.com.ua/2018/02/16/bitmain-razrabatyivaet-asic-mayner-dlya-dobyichi-eth/" data-wpel-link="internal">Bitmain разрабатывает ASIC-майнер для добычи ETH</a></h2>
                    <div class="date">16 февраля 2018<i class="fa fa-eye"></i>18</div>
                </div>
                <div class="article-content col-sm-8">
                    <div class="article-text">
                        <p>Как стало известно IBTimes, компания Bitmain, являющаяся монополистом в сфере Bitcoin-майнинга, разрабатывает ASIC-майнер для добычи Ethereum – Antminer F3. Производитель уже до конца февраля планирует начать выпуск новых чипов (200-220 MH/s). Antminer F3 будет оснащен 3-мя материнскими платами, в каждой из которых предусмотрено 6 плат, а они будут содержать по 32 модуля DDR3 на 1&#8230;</p>
                        <a href="https://myrig.com.ua/2018/02/16/bitmain-razrabatyivaet-asic-mayner-dlya-dobyichi-eth/" class="article-link" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i>Читать</a>
                    </div>
                </div>
            </div>-->

        </div>
            <!--<div class="  text-center"><ul class="pagination text-center"><li ><span aria-current='page' class='page-numbers current'>1</span></li><li ><a class="page-numbers" href="https://myrig.com.ua/news/page/2/" data-wpel-link="internal">2</a></li><li ><span class="page-numbers dots">&hellip;</span></li><li ><a class="page-numbers" href="https://myrig.com.ua/news/page/29/" data-wpel-link="internal">29</a></li><li ><a class="next page-numbers" href="https://myrig.com.ua/news/page/2/" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i></a></li></ul></div>        </div>-->
    </section>
</main>
@endsection
