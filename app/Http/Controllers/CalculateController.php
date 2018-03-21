<?php

namespace App\Http\Controllers;
use App\Model\Base\VariableContent;
use Illuminate\Http\Request;
use App\Model\Base\Setting;
use App\Model\Shop\ExchangeRate;
use App\SimpleHtmlDom as simple_html_dom;
use App\Model\Base\Page;


class CalculateController
{
    public function checkMethod(Request $request)
    {
        //return $this->parse_btc_courses_calc($request);
        $action = $request->post('action');
        switch ($action){
            case 'parse_btc_network_status':
                return $this->parse_btc_network_status($request);
            case 'parse_btc_courses_calc':
                return $this->parse_btc_courses_calc($request);
            case 'parse_others_network_status':
                return $this->parse_others_network_status(0, $request->post('currencyType'), $request);
            case 'update_devices':
                return $this->update_devices($request);
            case 'calc_btc_profit':
        }
        return $this->calc_btc_profit($request);
    }

    /*
     * Parse other crypth courses
     */
    public function parse_btc_courses_calc(Request $request, $die = 1)
    {
        $source = '';//$request->post('src');// $_GET['src'];
        //------------
        $url['USD / UAH'] = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?valcode=USD&date='.date('Ymd').'&json';
        $json = $this->get_data($url['USD / UAH']);
        $decoded  = json_decode($json, true);
        $uah = $decoded[0]['rate'];
        $data['USD / UAH'] = $uah;


        $url['USD / RUR'] = 'https://www.cbr-xml-daily.ru/daily_json.js' ;
        $json = $this->get_data($url['USD / RUR']);
        $decoded  = json_decode($json, true);
        $rur = $decoded['Valute']['USD']['Value'];
        $data['USD / RUR'] = $rur;


        $url['EUR / UAH'] = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?valcode=EUR&date='.date('Ymd').'&json';
        $json = $this->get_data($url['EUR / UAH']);
        $decoded  = json_decode($json, true);
        $euruah = $decoded[0]['rate'];


        $calc = $this->parse_btc_course_calculated();
        $other_crypth = ExchangeRate::whereIn('title', ['BCH/USD', 'LTC/USD', 'DASH/USD'])->get()->groupBy('title');
        if($other_crypth){
            $calcBCH = $other_crypth['BCH/USD'][0]->value;
            $calcLTC = $other_crypth['LTC/USD'][0]->value;
            $calcDASH = $other_crypth['DASH/USD'][0]->value;
        } else{
            $other_crypth = $this->parse_btc_courses_others();

            $calcBCH = $other_crypth['BCH'];
            $calcLTC = $other_crypth['LTC'];
            $calcDASH = $other_crypth['DASH'];
        }

        $data['base']['BTC / USD'] = $calc;
        $data['base']['BTC / EUR'] = $calc / ($euruah / $uah) ;
        $data['base']['BTC / UAH'] = $calc * $uah;
        $data['base']['BTC / RUR'] = $calc * $rur;

        $data['base']['BCH / USD'] = $calcBCH;
        $data['base']['BCH / EUR'] = $calcBCH / ($euruah / $uah) ;
        $data['base']['BCH / UAH'] = $calcBCH * $uah;
        $data['base']['BCH / RUR'] = $calcBCH * $rur;

        $data['base']['LTC / USD'] = $calcLTC;
        $data['base']['LTC / EUR'] = $calcLTC / ($euruah / $uah) ;
        $data['base']['LTC / UAH'] = $calcLTC * $uah;
        $data['base']['LTC / RUR'] = $calcLTC * $rur;

        $data['base']['DASH / USD'] = $calcDASH;
        $data['base']['DASH / EUR'] = $calcDASH / ($euruah / $uah) ;
        $data['base']['DASH / UAH'] = $calcDASH * $uah;
        $data['base']['DASH / RUR'] = $calcDASH * $rur;

        if($source){
            $output = '';
            foreach ($data['base'] as $key => $value) {
                $output .= view('parts/calculator/btc_table_currency_item', ['key' => $key, 'value' => round($value,2)]);
            }
            return $output;
        }

        if ($request->post('action') != 'calc_btc_profit' && $die != 1){
            die();
        } else{
        return $data;
        }
    }

    /*
     * Parse bitcoin network status
     */
    public function parse_btc_network()
    {
        $url  = 'https://chain.api.btc.com/v3/block/latest?_ga=2.243435013.1001709445.1506057444-713996762.1506057444';
        $json = $this->get_data($url );
        $decoded  = json_decode($json, true);

        $network['difficulty'] = $decoded['data']['difficulty'] ;
        $network['reward_block'] = $decoded['data']['reward_block']  ;

        return $network;
    }

    /*
     * Parse network status for other crypths
     */
    public function parse_others_network_status($die, $currency='BCH', $request='')
    {
        $html = new simple_html_dom('');

        if($request){
            if ($request->post('currency'))
                $currency = $request->post('currency');
        }

        switch ($currency) {

            case 'BCH':
                $html = $html->file_get_html( 'https://bitinfocharts.com/ru/bitcoin%20cash/'  );
                break;

            case 'LTC':
                $html = $html->file_get_html( 'https://bitinfocharts.com/ru/litecoin/'  );
                break;

            case 'DASH':
                $html = $html->file_get_html( 'https://bitinfocharts.com/ru/dash/'  );
                break;
        }

        foreach($html->find('#tdid16') as $element) {
            $data['hashrate'] = $element->innertext;
        }
        foreach($html->find('#tdid15') as $element) {
            $data['difficulty'] = $element->innertext;
            $data['difficulty'] = explode(' ', $data['difficulty'])[0];

            $network['difficulty'] = explode(' ', $data['difficulty'])[0];
            $network['difficulty'] = str_replace(',','', $network['difficulty'])/1000000000000;

        }
        foreach($html->find('#tdid32') as $element) {
            $data['mining'] = $element->innertext;
        }

        foreach($html->find('#tdid13') as $element) {
            $data['reward'] = $element->innertext;
            foreach($element->find('abbr[title="block reward"]') as $elements) {

                $network['reward_block'] = $elements->innertext;
            }
        }

        $t = 86400;
        $R = $network['reward_block'];
        $D = $network['difficulty'] ;
        $H = 1;

        $P =  number_format(($t*$R*$H)/($D*(2**32)), 8)  ;

        $TH = 'T';
        $THT = 'EH';
        if ($currency == 'LTC') {
            $calcLTC = $this->parse_btc_courses_others($currency);
            $data['mining'] = trim(explode(' ', $data['mining'])[0]);
            $P = number_format($data['mining']/$calcLTC, 8)  ;
            $network['p'] = $P;
            $TH = 'MH';
            $THT = 'TH';
        }

        if ($currency == 'DASH') {
            $calcDASH = $this->parse_btc_courses_others($currency);
            $data['mining'] = trim(explode(' ', $data['mining'])[0]);
            $P = number_format($data['mining']/$calcDASH, 8)  ;
            $network['p'] = $P;
            $TH = 'GH';
            $THT = 'TH';
        }

        if ($die != 1 && $request->post('action') != 'calc_btc_profit') {
            return view('parts/calculator/network_status', ['data' => $data, 'TH' => $TH, 'P' => $P, 'currency' => $currency]);
        }  else
            return $network;
    }

    /*
     * Update devices for client calculator
     */
    public function update_devices($request) {
        $cur='';
        if ($request->post('currency')) {
            $cur = $request->post('currency');
        }

        $devices = [
            ['currency' => 'BTC,BCH', 'name' => 'ANTMINER S7 4.7Th/s', 'hr' => 4.73, 'en' => 1.43],
            ['currency' => 'BTC,BCH', 'name' => 'ANTMINER R4 8.6Th/s', 'hr' => 8.6, 'en' => 0.93],
            ['currency' => 'BTC,BCH', 'name' => 'ANTMINER T9 12.5Th/s', 'hr' => 12.5, 'en' => 1.73],
            ['currency' => 'BTC,BCH', 'name' => 'ANTMINER S9 11.5Th/s', 'hr' => 11.5, 'en' => 1.24],
            ['currency' => 'BTC,BCH', 'name' => 'ANTMINER S9 12.5Th/s', 'hr' => 12.5, 'en' => 1.34],
            ['currency' => 'BTC,BCH', 'name' => 'ANTMINER S9 13Th/s', 'hr' => 13, 'en' => 1.4],
            ['currency' => 'BTC,BCH', 'name' => 'ANTMINER S9 13.5Th/s', 'hr' => 13.5, 'en' => 1.45],
            ['currency' => 'BTC,BCH', 'name' => 'ANTMINER S9 14Th/s', 'hr' => 14, 'en' => 1.5],
            ['currency' => 'BTC,BCH', 'name' => 'DRAGONMINT T1', 'hr' => 16, 'en' => 1.47],
            ['currency' => 'LTC', 'name' => 'L3+ 504 Mh', 'hr' => 504, 'en' => 0.8],
            ['currency' => 'DASH', 'name' => 'D3 15 GH/s', 'hr' => 15, 'en' => 1.2],
            ['currency' => 'DASH', 'name' => 'D3 17 GH/s', 'hr' => 17, 'en' => 1.2],
            ['currency' => 'DASH', 'name' => 'D3 19.3 GH/s', 'hr' => 19.3, 'en' => 1.2],
        ];
        $allowedDevices = [];
        foreach ($devices as $device){
            $allowed = explode(',', $device['currency']);
            if(!in_array($cur, $allowed)){
                continue;
            }
            $allowedDevices[] = $device;
        }

        return view('parts/calculator/calculator_form_item', ['devices' => $allowedDevices, 'cur' => $cur]);
    }

    /*
     * Parse bitcoin network status
     * @param (integer) $die
     */
    public function parse_btc_network_status(Request $request, $die = 0) {

        $html = new simple_html_dom('');
        $html = $html->file_get_html( 'https://btc.com/'  );

        foreach($html->find('.indexNetworkStats dt') as $element) {
            if ($element->innertext == 'Hashrate')
                $data['hashrate'] = $element->parent()->find('dd', 0)->innertext;

            if ($element->innertext == 'Next Difficulty Estimated') {
                $text = $element->parent()->find('dd', 0)->innertext;
                $data['expected_difficulty_raw'] = $text;
                preg_match('#\((.*?)\)#', $text, $match);

                $data['expected_difficulty'] = (float)$match[1];
                if ( substr($data['expected_difficulty'], 1) == '-' )
                    $data['expected_difficulty'] = $data['expected_difficulty'] * (-1);
            }

            if ($element->innertext == 'Date to Next Difficulty') {
                $text = $element->parent()->find('dd', 0)->innertext;
                $data['expected_difficulty_date'] = $element->parent()->find('dd', 0)->innertext;

            }
        }
        $network = $this->parse_btc_network();

        $t = 86400;
        $R = $network['reward_block']/1000000000;
        $D = $network['difficulty']/10000000000000 ;
        $H = 1;

        $P =  number_format(($t*$R*$H)/($D*(2**32)), 8)  ;

        if ($request->post('action') != 'calc_btc_profit' && $die != 1) {
            return view('parts/calculator/network_status', ['btc' => 1, 'data' => $data, 'TH' => 'T', 'P' => $P, 'D' => $D, 'currency' => 'BTC']);
        }  else
            return $data;
    }


    /*
     * Calculate profit for client
     * @param (object) $request
     * @return
     */
    public function calc_btc_profit($request) {
        //$network = parse_btc_network();
        $network = json_decode(stripslashes( $request->get('network')), 1);
        //$network_status =  parse_btc_network_status();
        $network_status =  json_decode(stripslashes( $request->get('status')), 1);
        //$coursers = parse_btc_courses_calc();
        $coursers =  json_decode(stripslashes( $request->get('calc')), 1);
        $source = 'base';
        $days = $request->get('days') ? $request->get('days') : 1;
        $expected_difficulty = $network_status['expected_difficulty']/100+1;

        $powers = $request->get('powers');
        $placements = $request->get('radio');

        $t = 86400;
        $R = $network['reward_block']/1000000000;
        $D = round(trim($network['difficulty']), 5)/10000000000 ;
        $H = $request->get('hash') / $powers;
//var_dump($D); die;
        $currency = $request->get('currency');
        if ($currency === 'BCH') {
            $network = $this->parse_others_network_status(1, $currency, $request);
            $R = $network['reward_block'] ;
            $D = $network['difficulty']*1000;
            //var_dump($D); die;
        }
        //var_dump($D); die;
        $P = ($t*$R*$H)/($D*(2**32)) * $days;

        if ($currency === 'LTC') {
            $network = $this->parse_others_network_status(1, $currency, $request);
            $calcLTC = $this->parse_btc_courses_others($currency);
            $P = $network['p'] ;
            $TH = 'MH';
            $P =  number_format( $P*$request->get('hash') , 6) * $days;
        }

        if ($currency === 'DASH') {
            $network = $this->parse_others_network_status(1, $currency, $request);
            $calcLTC = $this->parse_btc_courses_others($currency);
            $P = $network['p'] ;
            $TH = 'GH';
            $P =  number_format( $P*$request->get('hash') , 6) * $days;
        }

        if ($placements == 2) {
            $energy = $request->get('energy');
            $energy_costs = $request->get('costs');
            $energy_costs = $energy_costs * 24;

        } else {
            $qty = $request->get('qty') ? $request->get('qty') : 1;

            $hosting = Setting::where('title', 'calculator.hosting')->first()->value;

            //$hosting =  5.2;//get_field('стоимость_хостинга_usd_в_месяц', 2319);
            $energy_costs = $hosting * $qty;
            $energy = 1;
        }

        $costs['BTC'] = $energy * $energy_costs   * $days / $coursers['base']["$currency / USD"] ;
        $costs['USD'] = $energy * $energy_costs   * $days;
        $costs['RUR'] = $energy * $energy_costs   * $coursers['USD / RUR'] * $days;
        $costs['UAH'] = $energy * $energy_costs   * $coursers['USD / UAH'] * $days;


/*        ob_start();
        view('parts/calculator/result', ['request' => $request, 'P' => $P, 'coursers' => $coursers, 'currency' => $currency, 'costs' => $costs]);

        $result = ob_get_contents();
        ob_clean();*/

        return view('parts/calculator/result', ['request' => $request, 'P' => $P, 'coursers' => $coursers, 'currency' => $currency, 'costs' => $costs]);
//var_dump($result); die;
        $P = $labels = array();

        $date = new \DateTime();
        foreach (range(0,20) as $key=>$day) {
            //var_dump($D, $expected_difficulty); die;
            $D = $D * $expected_difficulty;

            $P[$key] =  ($t*$R*$H)/($D*(2**32) ) - $costs['BTC']/$days * 1;

            //var_dump($network_status['expected_difficulty_date']); die;
            $date = $date->modify('+'.$network_status['expected_difficulty_date']);
            $labels[] = $date->format('d.m.y');
        }

        if (!$request->get('hash'))  {
            $result = 0 ;
        }

        echo json_encode(
            array(
                'result' => $result,
                'chart' =>  $P ,
                'chartLabels' =>  $labels
            ));
        die() ;
    }

    public function parse_btc_courses($source='coinbase') {
        $url['coinbase'] = 'https://api.coinbase.com/v2/prices/BTC-USD/spot';
        $url['blockchain'] = 'https://blockchain.info/ru/ticker';
        $url['bitstamp'] = 'https://www.bitstamp.net/api/ticker';
        $coinbase_json = $this->get_data($url[$source]);
        $coinbase_decoded = json_decode($coinbase_json, true);

        if ($source == 'coinbase')
            return $coinbase_decoded['data']['amount'];
        if ($source == 'blockchain')
            return $coinbase_decoded['USD']['last'];
        if ($source == 'bitstamp')
            return $coinbase_decoded['last'];
    }

    /*
     * Parse bitcoin course with calculator changes
     * @return string
     */
    public function parse_btc_course_calculated() {
        $url['coinbase'] = 'https://api.coinbase.com/v2/prices/BTC-USD/spot';
        $url['blockchain'] = 'https://blockchain.info/ru/ticker';
        $url['bitstamp'] = 'https://www.bitstamp.net/api/ticker';

        $result_parsing['coinbase'] = json_decode($this->get_data($url['coinbase']), true);
        $result_parsing['blockchain'] = json_decode($this->get_data($url['blockchain']), true);
        $result_parsing['bitstamp'] = json_decode($this->get_data($url['bitstamp']), true);

        $result['coinbase'] = $result_parsing['coinbase']['data']['amount'];
        $result['blockchain'] = $result_parsing['blockchain']['USD']['last'];
        $result['bitstamp'] = $result_parsing['bitstamp']['last'];

        foreach ($result as $key => $value){
            $item = ExchangeRate::where('title', $key)->first();

            if(!$item){
                ExchangeRate::create([
                    'title' => $key,
                    'value' => $value
                ]);
            } else{
                $item->value = $value;
                $item->save();
            }
        }

        $btc = ExchangeRate::where('title', 'BTC/USD')->first();
        if(!$btc){
            $btc = new ExchangeRate();
            $btc->title = 'BTC/USD';
        }

        $btc->value = $btc->countCustomRate();
        $btc->save();

        return true;
    }


    /**
     * Parse other crypths from external sources
     * @param (String) $cur Currency for parse
     * @return array|string
     */
    public function parse_btc_courses_others($cur='') {
        $url['BCH']  = 'https://api.coinmarketcap.com/v1/ticker/bitcoin-cash/';
        $url['LTC']  = 'https://api.coinmarketcap.com/v1/ticker/litecoin/';
        $url['DASH']  = 'https://api.coinmarketcap.com/v1/ticker/dash/';
        $url['ETH']  = 'https://api.coinmarketcap.com/v1/ticker/ethereum/';

        if($cur){
            $coinbase_json = $this->get_data($url[$cur]);
            $coinbase_decoded = json_decode($coinbase_json, true);
            $result = $coinbase_decoded[0]['price_usd'];

            $rate = ExchangeRate::where('title', $cur . '/USD')->first();

            if(!$rate){
                ExchangeRate::create([
                    'title' => $cur . '/USD',
                    'value' => $result
                ]);
            } else{
                $rate->value = $result;
                $rate->save();
            }
        } else{
            foreach ($url as $key => $val) {
                $coinbase_json = $this->get_data($val);
                $coinbase_decoded = json_decode($coinbase_json, true);
                $result[$key] = $coinbase_decoded[0]['price_usd'];

                $rate = ExchangeRate::where('title', $key . '/USD')->first();
                if(!$rate){
                    ExchangeRate::create([
                        'title' => $key . '/USD',
                        'value' => $result[$key]
                    ]);
                } else{
                    $rate->value = $result[$key];
                    $rate->save();
                }
            }
        }

        return $result;
    }


    /*
     * Getting data from external sources with cURL
     * @param (string) $url Sources url
     */
    public function get_data($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}