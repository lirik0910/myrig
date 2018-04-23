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
                            <h1 class="calc_title">{{__('default.yield_calculator')}}</h1>
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
                                            @php
                                                $vars = App\Model\Base\Variable::where('title', 'calculatorDevices')->first()->multiVariableLines;
//var_dump(count($vars)); die;
                                                if(count($vars) > 0){
                                                    $i = 0;
                                                    foreach ($vars as $var){
                                                        foreach ($var->content as $content){
                                                            $Devices[$i][] = $content->content;
                                                        }
                                                        $i++;
                                                    }

                                                    $cur = 'BTC';
                                                    $allowedDevices = [];
                                                    foreach ($Devices as $device){
                                                        $allowed = explode(',', $device[3]);
                                                        if(!in_array($cur, $allowed)){
                                                            continue;
                                                        }
                                                        $allowedDevices[] = $device;
                                                    }
                                                }
                                            //var_dump($allowedDevices); die;
                                            @endphp
                                            <div class="calculator-form--item">
                                                <div class="width-60">
                                                    <select id="device" name="device" class="calc-select">
                                                        <option value="hide" >{{__('default.device')}}</option>
                                                        <option value="" data-hr="0">{{__('default.manual_input')}}</option>
                                                        @isset($allowedDevices)
                                                            @foreach($allowedDevices as $device)
                                                                <option data-currency="{{$device[3]}}" data-hr="{{$device[1]}}" data-en="{{$device[2]}}" value="{{$device[0]}}">{{$device[0]}}</option>
                                                            @endforeach
                                                        @endisset
                                                        <!--<option  data-currency="BTC,BCH" data-hr="4.73" data-en="1.43" value="ANTMINER S7 4.7Th/s">ANTMINER S7 4.7Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="8.6" data-en="0.93" value="ANTMINER R4 8.6Th/s">ANTMINER R4 8.6Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="12.5" data-en="1.73" value="ANTMINER T9 12.5Th/s">ANTMINER T9 12.5Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="11.5" data-en="1.24" value="ANTMINER S9 11.5Th/s">ANTMINER S9 11.5Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="12.5" data-en="1.34" value="ANTMINER S9 12.5Th/s">ANTMINER S9 12.5Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="13" data-en="1.4" value="ANTMINER S9 13Th/s">ANTMINER S9 13Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="13.5" data-en="1.45" value="ANTMINER S9 13.5Th/s">ANTMINER S9 13.5Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="14" data-en="1.50" value="ANTMINER S9 14Th/s">ANTMINER S9 14Th/s</option>
                                                        <option  data-currency="BTC,BCH" data-hr="16" data-en="1.47" value="DRAGONMINT T1">DRAGONMINT T1</option>-->
                                                    </select>
                                                </div>
                                                <!--<span class="input-number  width-33  quantity-center">
                                                    <input placeholder="1 шт" min="1" step="1" type="text" name="qty" value="1" class="form-control form-number count" readonly/>
                                                    <div class="btn-count btn-count-plus"><i class="fa fa-plus"></i></div>
                                                    <div class="btn-count btn-count-minus"><i class="fa fa-minus"></i></div>
                                                </span>-->
                                                <input type="number"  step="1" class="quantity width-33 quantity-center" id="quantity" name="qty" placeholder="1" min="1" value="1" readonly>
                                            </div>
                                            <div class="calculator-form--item cur-LTC">
                                                <input type="number" step="0.01" class="quantity width-60 hash" name="hash" placeholder="{{ __('default.input_hashrate') }}"  >
                                                <div class="width-33 cur-LTC-ul">
                                                    <select id="ghs" name="powers" class="calc-select">
                                                        <option  value="0.001" selected >TH/s</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="calculator-form--item kvtch">
                                            <input type="number"  step="0.01" class="quantity width-60 energy" name="energy" placeholder="{{__('default.energy_consumption')}}">
                                            <div class="width-33">
                                                <select  disabled class="calc-select">
                                                    <option value="hide" >{{__('default.kwh')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="radio-buttons calculator-form--item">
                                            <input type="radio" name="radio" class="radio" id="radio1"   value="1">
                                            <label for="radio1" class="hosting-label">{{ __('default.hosting_title') }}<b class="tooltip">i<span class="tooltiptext">{{__('default.equipment_placement_desk')}}</span></b></label>

                                            <input type="radio" name="radio" class="radio" id="radio2" value="2" checked>
                                            <label for="radio2">{{__('default.local_placement')}}<b class="tooltip">i<span class="tooltiptext">{{__('default.local_device_placement')}}</span></b></label>
                                        </div>
                                        <div class="calculator-form--item">
                                            <input type="number" step="0.01" class="quantity width-60 quantity-center qw costs" name="costs"  placeholder="0.1 $"  value="0.1">
                                        </div>
                                        <div class="calculator-form--item">
                                            <div class="">
                                                <select id="rialto" name="days" class="calc-select">
                                                    <option value="hide">{{ __('default.billing_period') }}</option>
                                                    <option value="1" selected>{{ __('default.one_day') }}</option>
                                                    <option value="31" >{{ __('default.one_month') }}</option>
                                                    <option value="365" >{{ __('default.one_year') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="submit" class="button-green" value="{{__('default.calculate')}}">
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
                                    <div class="network-status--title ">{{ __('default.network_status') }}</div>
                                    <div class="network-status--parent">
                                        <div class="network-status--inner">
                                            <div>{{ __('default.hashrate') }}</div>
                                            <div><i class="fa fa-cog fa-spin"></i></div>
                                        </div>

                                        <div class="network-status--inner">
                                            <div>{{ __('default.difficulty') }}</div>
                                            <div><i class="fa fa-cog fa-spin"></i></div>
                                        </div>

                                        <div class="network-status--inner network-delimiter">
                                            <div>{{ __('default.mining') }}</div>
                                            <div><i class="fa fa-cog fa-spin"></i></div>
                                        </div>

                                        <div class="network-status--inner">
                                            <div>{{ __('default.next_difficulty') }}</div>
                                            <div><i class="fa fa-cog fa-spin"></i></div>
                                        </div>

                                        <div class="network-status--inner">
                                            <div>{{ __('default.next_difficulty_date') }}</div>
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
                                        <div class="income-days-title ">{{ __('default.calculation') }}</div>
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
                                        <div class="income-table__inner-title">{{ __('default.income') }}</div>
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
                                        <div class="income-table__inner-title">{{ __('default.expenses') }}</div>
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
                                        <div class="income-table__inner-title">{{ __('default.profit') }}</div>
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
                                {!! $it->content !!}
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