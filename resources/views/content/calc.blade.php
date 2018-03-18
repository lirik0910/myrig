@extends('layouts.app')

@section('content')
    <main>
        <div class="main-back"></div>
        <div class="content single-article">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <!--CALCULATOR BEGIN-->
                        <div class="section-tab">
                            <h1 class="calc_title">Калькулятор доходности</h1>
                            <div class="korpus">
                                <input data-index="1" data-currencyType="BTC" data-updateAction="parse_btc_network_status" type="radio" name="odin" checked="checked" id="vkl1" />
                                <label for="vkl1" class="tab-label label-1 fixborder">BTC</label>
                                <input data-index="2" data-currencyType="BCH" data-updateAction="parse_others_network_status"  type="radio" name="odin" id="vkl11"/>
                                <label for="vkl11" class="tab-label label-11 label-1  ">BCH</label>
                                <input data-index="3" data-currencyType="LTC" data-updateAction="parse_others_network_status"  type="radio" name="odin" id="vkl2"  />
                                <label for="vkl2" class="tab-label label-2 ">LTC</label>
                                <input data-index="4" data-currencyType="DASH" data-updateAction="parse_others_network_status" type="radio" name="odin" id="vkl3"   />
                                <label for="vkl3" class="tab-label label-3">DASH</label>
                                <input type="radio" name="odin" id="vkl4" disabled="disabled"  />
                                <label for="vkl4" class="tab-label label-4 disabled">ETH</label>
                                <!--tabs_item begin-->
                                <div class="tabs_item tab-1">

                                    <form class="calculator-form" action="#" method="post">
                                        <div class="miners">
                                            <div class="calculator-form--item">
                                                <div class="width-60">
                                                    <select id="device" name="device" class="calc-select">
                                                        <option value="hide" >Устройство</option>
                                                        <option value="" data-hr="0">Ручной ввод</option>
                                                        <option  data-currency="BTC,BCH" data-hr="4.73" data-en="1.43" value="ANTMINER S7 4.7Th/s">ANTMINER S7 4.7Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="8.6" data-en="0.93" value="ANTMINER R4 8.6Th/s">ANTMINER R4 8.6Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="12.5" data-en="1.73" value="ANTMINER T9 12.5Th/s">ANTMINER T9 12.5Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="11.5" data-en="1.24" value="ANTMINER S9 11.5Th/s">ANTMINER S9 11.5Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="12.5" data-en="1.34" value="ANTMINER S9 12.5Th/s">ANTMINER S9 12.5Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="13" data-en="1.4" value="ANTMINER S9 13Th/s">ANTMINER S9 13Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="13.5" data-en="1.45" value="ANTMINER S9 13.5Th/s">ANTMINER S9 13.5Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="14" data-en="1.50" value="ANTMINER S9 14Th/s">ANTMINER S9 14Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="16" data-en="1.47" value="DRAGONMINT T1">DRAGONMINT T1</option>

                                                    </select>
                                                </div>

                                                <!--<span class="input-number  width-33  quantity-center">
                                                    <input placeholder="1 шт" min="1" step="1" type="text" name="qty" value="1" class="form-control form-number count" readonly/>
                                                    <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
                                                    <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
                                                </span>-->

                                                <input type="number"  step="1" class="quantity width-33 quantity-center" id="quantity" name="qty" placeholder="1 шт" min="1" readonly>
                                            </div>

                                            <div class="calculator-form--item cur-LTC">
                                                <input type="number" step="0.01" class="quantity width-60 hash" name="hash" placeholder="Введите хешрейт"  >

                                                <div class="width-33 cur-LTC-ul">
                                                    <select id="ghs" name="powers" class="calc-select">

                                                        <option  value="0.001" selected >TH/s</option>



                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="calculator-form--item kvtch">
                                            <input type="number"  step="0.01" class="quantity width-60 energy" name="energy" placeholder="Энергопотребление"   >
                                            <div class="width-33">
                                                <select  disabled class="calc-select">
                                                    <option value="hide" >кВт/ч</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="radio-buttons calculator-form--item">
                                            <input type="radio" name="radio" class="radio" id="radio1"   value="1">
                                            <label for="radio1" class="hosting-label">Хостинг	<b class="tooltip">i<span class="tooltiptext">Размещение оборудования в дата центре MyRig</span></b></label>

                                            <input type="radio" name="radio" class="radio" id="radio2" value="2" checked>
                                            <label for="radio2">Локальное размещение	<b class="tooltip">i<span class="tooltiptext">Локальное размещение устройств</span></b></label>
                                        </div>

                                        <div class="calculator-form--item">

                                            <input type="number" step="0.01" class="quantity width-60 quantity-center qw costs" name="costs"  placeholder="0.1 $"   >
                                        </div>

                                        <div class="calculator-form--item">

                                            <div class="">
                                                <select id="rialto" name="days" class="calc-select">
                                                    <option value="hide">Расчетный период</option>
                                                    <option value="1" selected>1 день</option>
                                                    <option value="31" >1 месяц</option>
                                                    <option value="365" >1 год</option>



                                                </select>
                                            </div>
                                        </div>

                                        <input type="submit" class="button-green" value="Рассчитать">
                                        <input type="hidden" value="calc_btc_profit" name="action">
                                        <input type="hidden" value="BTC" class="currencyType" name="currency">
                                    </form>							</div>
                                <!--tabs_item end-->
                                <div class="tab-2"> </div>
                                <div class="tab-3"></div>
                                <div class="tab-4"></div>
                            </div>


                        </div>
                        <!--CALCULATOR END-->

                    </div>

                    <div class="article-content col-sm-8">
                        <div class="article-text">

                            <!--NETWORK STATUS BEGIN-->
                            <div class="">
                                <div class="network-status bg-white">

                                    <div class="network-status--title ">Статус сети</div>

                                    <div class="network-status--parent">
                                        <div class="network-status--inner">
                                            <div>Хэшрейт</div>
                                            <div><i class="fa fa-cog fa-spin"></i></div>
                                        </div>

                                        <div class="network-status--inner">
                                            <div>Сложность</div>
                                            <div><i class="fa fa-cog fa-spin"></i></div>
                                        </div>

                                        <div class="network-status--inner network-delimiter">
                                            <div>Добыча</div>
                                            <div><i class="fa fa-cog fa-spin"></i></div>
                                        </div>

                                        <div class="network-status--inner">
                                            <div>Ожидаемая следующая сложность</div>
                                            <div><i class="fa fa-cog fa-spin"></i></div>
                                        </div>

                                        <div class="network-status--inner">
                                            <div>Дата следующей сложности</div>
                                            <div><i class="fa fa-cog fa-spin"></i></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--NETWORK STATUS END-->

                            <!--INCOME TABLE BEGIN-->
                            <div class="">
                                <div class="table--responsive income-table bg-white">

                                    <div class="income-table__inner">
                                        <div class="income-days-title ">Расчет</div>
                                    </div>

                                    <div class="income-table__title">
                                        <div class="income-table__title--item">
                                            <div class="income-icon income-icon-1">BTC</div>
                                            <div class="income-icon income-icon-2">USD</div>
                                            <div class="income-icon income-icon-3">RUB</div>
                                            <div class="income-icon income-icon-4">UAH &#8372;</div>
                                        </div>
                                    </div>

                                    <div class="income-table__inner">
                                        <div class="income-table__inner-title">Доход</div>
                                        <div class="income-table__item">
                                            <div class="income-icon income-icon-1">BTC</div>
                                            <div class="income-number">-</div>
                                            <div class="income-icon income-icon-2">USD</div>
                                            <div class="income-number">-</div>
                                            <div class="income-icon income-icon-3">RUB</div>
                                            <div class="income-number">-</div>
                                            <div class="income-icon income-icon-4">UAH</div>
                                            <div class="income-number">-</div>
                                        </div>
                                    </div>

                                    <div class="income-table__inner">
                                        <div class="income-table__inner-title">Затраты</div>
                                        <div class="income-table__item">
                                            <div class="income-icon income-icon-1">BTC</div>
                                            <div class="income-number">-</div>
                                            <div class="income-icon income-icon-2">USD</div>
                                            <div class="income-number">-</div>
                                            <div class="income-icon income-icon-3">RUB</div>
                                            <div class="income-number">-</div>
                                            <div class="income-icon income-icon-4">UAH</div>
                                            <div class="income-number">-</div>
                                        </div>
                                    </div>

                                    <div class="income-table__inner">
                                        <div class="income-table__inner-title">Прибыль</div>
                                        <div class="income-table__item">
                                            <div class="income-icon income-icon-1">BTC</div>
                                            <div class="income-number">-</div>
                                            <div class="income-icon income-icon-2">USD</div>
                                            <div class="income-number">-</div>
                                            <div class="income-icon income-icon-3">RUB</div>
                                            <div class="income-number">-</div>
                                            <div class="income-icon income-icon-4">UAH</div>
                                            <div class="income-number">-</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--INCOME TABLE END-->

                            <!--CALCULATOR TEXT BEGIN-->
                            <div>
                                <!-- График -->

                                <div class="calculator-text">

                                    <p>Современный мир криптовалют отличается надежностью, защищенностью и перспективностью. Высокий уровень ее защиты обусловлен децентрализацией учетной системы и эмиссии, а также функционированием в распределенной компьютерной сети. Зарабатывать крипту можно посредством специализированных устройств – ASIC-майнеров и GPU-ферм. Их основное назначение – расчет алгоритмов: SHA-256, X11, Scrypt и т. д.</p>
                                    <p>Приобретение нового оборудования для майнинга выполняется на основе расчетов будущей прибыли и расходов на затрачиваемую электроэнергию. Подобные расчеты считаются довольно трудоемкими, в частности, когда требуется сравнить несколько видов устройств. На сайте каждый пользователь сможет воспользоваться уникальным инструментом для автоматических операций расчета прибыли майнеров и уровнем потребления электроэнергии.</p>
                                    <h2>Калькулятор криптографических валют: удобство использования</h2>
                                    <p>Пользоваться калькулятором крипотвалют (Bitcoin, Litecoin, Etherium, Dash) достаточно просто. Для этого из выпадающего меню следует выбрать подходящий ASIC-майнер/ GPU-ферму либо ввести хешрейт оборудования и нажать клавишу «Раccчитать». В результате, калькулятор предоставит полную информацию о потреблении майнера, а также всех сведений о заработке криптовалюты с автоматической ее конвертацией в доллары, рубли, гривны и т.д. При этом данный инструмент не ограничивается общими данными, он предоставляет таблицы, в которых структурирована информация о суточном, недельном, месячном заработке в любой желаемой валюте, а также о расходе электроэнергии в аналогичных временных диапазонах.</p>
                                    <p>Калькулятор крипловалют способен значительно упростить процессы выбора требуемого оборудования для майнинга за счет экономии времени на подсчетах. Как было отмечено ранее, в калькуляторе присутствует выпадающий список с майнерами. Все они представлены в магазине, следовательно, выполнив быстрый расчет, можно сразу же при обрести оптимальный вариант ASIC-майнера, после чего заняться майнингом криптовалюты.</p>
                                    <p><span style="color: #999999;"><em>*Абсолютная точность обменных курсов, представленных в криптокалькуляторе, не гарантируется (в этом даже не помогает ежеминутная синхронизация с крупнейшими криптовалютными биржами). Именно поэтому перед совершением определенных транзакций пользователям следует сверить обменный курс во избежание непредвиденных ситуаций. Следует отметить, что курс обмена криптовалюты определяется данными, полученными онлайн из API бирж. Такие обменные курсы несут в себе информационный характер, поэтому они могут изменяться спонтанно, то есть без предварительного уведомления. Кстати, из-за постоянных колебаний курса мы не несет ответственность за транзакции, совершенные по предоставленным данным. Вся отображаемая информация по обменным курсам не предназначена для использования в инвестиционных операциях.</em></span></p>

                                </div>
                            </div>
                            <!--CALCULATOR TEXT END-->

                        </div>

                    </div>
                </div>
            </div>
        </div>


    </main>
@endsection