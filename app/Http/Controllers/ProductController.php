<?php

namespace App\Http\Controllers;

use App\Model\Base\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\CalculateController as Calculator;
use App\Model\Shop\Product;
use App\Model\Shop\ExchangeRate;

class ProductController extends Controller
{
    /*
     * Get content for product page
     * @param (Int) $id Current Product ID
     * return boolean
     */
    public function getContent($id){
        $product = Product::where('id', $id)->with('options')->firstorFail();
        $options = $product::convertOptions($product->options);

        return view('content/product', ['product' => $product, 'options' => $options]);
    }

    /*
     * Calculate payback
     * @param (int) $id Product ID
     * @return integer|boolean
     */
    public function calcPayback($id)
    {
        $product = Product::where('id', $id)->first();

        if($product->auto_price){
            $price = number_format($product->calcAutoPrice(), 2, '.', '');
        } else{
            $price = number_format($product->price, 2, '.', '');
        }

        /*
         * default values
         */
        $hashrate = 0;
        $currency = '';

        foreach ($product->options as $option){
            if(strnatcasecmp(trim($option->name), 'Hashrate') === 0 || strnatcasecmp(trim($option->name), 'Хешрейт') === 0){
                $hashrate = (float)$option->value;
            } elseif (strnatcasecmp(trim($option->name), 'Currency') === 0 || strnatcasecmp(trim($option->name), 'Валюта') === 0){
                $currency = explode(',', $option->value)[0];
            }
        }
//        var_dump($hashrate, $currency); die;

        if(!$hashrate || !$currency){
            return false;
        }

        $course = ExchangeRate::where('title', $currency . '/USD')->first()->value;

        $calculate = new Calculator();
        $network = $calculate->parse_btc_network();

        if($network['difficulty']){
            Setting::where('title', 'calculator.btc_network')->update(['value' => json_encode($network)]);
        } else{
            $network = json_decode(Setting::where('title', 'calculator.btc_network')->first()->value);
        }

        if ($currency == 'LTC' || $currency == 'DASH') {
            $network = $calculate->parse_others_network_status(1, $currency);
            $Ps = $network['p'];
            $P = $price / (number_format($Ps * $hashrate, 6) * $course);
        } else {
            $t = 86400;
            if(!is_array($network)){
                $R = $network->reward_block;
                $D = $network->difficulty / 10000;
            } else{
                $R = $network['reward_block'];
                $D = $network['difficulty'] / 10000;
            }

            try{
                $P = $price / (number_format(($t * $R * $hashrate) / ($D * (2 ** 32)), 7) * $course);
            } catch(\Exception $e){
                return true;
            }
        }

        return (int)$P;
    }

    /*
     * Get all products for report availability
     * @return string
     */
    public function all(){
        try {
            $all = Product::where('active', 1)->get();
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $output = [];
        $i = 0;
        foreach ($all as $item){
            $output[$i]['id'] = $item->id;
            $output[$i]['title'] = $item->title;
            $i++;
        }

        return response()->json($output, 200);
    }
}
