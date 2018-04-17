<?php

namespace App\Http\Controllers;
use App\Model\Shop\Product;
use Illuminate\Http\Request;
use App\Model\Base\User;
use App\Model\Base\Context;
use App\Model\Shop\Order;
use App\Model\Shop\Delivery;
use App\Model\Shop\PaymentType;
use Illuminate\Support\Facades\App;
use App\Model\Shop\OrderDelivery;
use App\Model\Shop\Cart;

class OrderController extends Controller
{
    /*
     * Create new client order
     * @return boolean
     */
    public function create(Request $request){
        if (!session()->get('client')){
            return response()->json(['success' => false, 'session' => false]);//redirect()->to('sso-login');
        }

        $data = $request->post();
        $user = User::where('email', session()->get('client'))->first();

        $locale = App::getLocale();
        $contexts = Context::all();

        $locale_context_id = 1;
        foreach ($contexts as $context){
            if(trim(strtolower($context->title)) == $locale){
                $locale_context_id = $context->id;
            }
        }

        if(!$user){
            return response()->json(['success' => false, 'message' => 'User is not exist']);
        }

        $delivery = Delivery::where('id', $data['delivery'])->where('active', 1)->first();

        if(!$delivery){
            return response()->json(['success' => false, 'message' => 'Delivery with this ID is not exist']);
        }

        $paymentType = PaymentType::where('id', $data['payment_method'])->where('active', 1)->first();

        if(!$paymentType){
            return response()->json(['success' => false, 'message' => 'Payment type with this ID is not exist']);
        }

        $order = new Order();

        $numbersArray = str_split((string)time() - 2000000, 3);
        $order_number = 0;
        foreach($numbersArray as $number){
            $order_number += (int)$number;
        }

        $order->fill([
            'number' => $order_number,
            'user_id' => $user->id,
            'cost' => 0,
            'prepayment' => 0,
            'status_id' => 1,
            'paid' => 0,
            'payment_type_id' => $paymentType->id,
            'context_id' => $locale_context_id
        ]);

        try {
            $order->save();
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        $order->orderDeliveries()->create([
            'order_id' => $order->id,
            'delivery_id' => $delivery->id,
            'cost' => 0,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'city' => $data['city'],
            'country' => $data['country'],
            'state' => $data['state'],
            'comment' => $data['comment']
        ]);

        $cart = json_decode(session()->get('cart'), true);
        foreach ($cart as $productId => $count){
            $product = Product::where('id', $productId)->first();
            if($product->auto_price){
                $cost = $product->calcAutoPrice();
            } else{
                $cost = $product->price;
            }

            $btcCost = $product->calcBtcPrice();

            $order->carts()->create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'count' => $count,
                'cost' => $cost,
                'btcCost' => $btcCost
            ]);
        }

        $order->cost = $order->countCost();
        $order->save();

        session()->forget('cart');
        return response()->json(['success' => true, 'order' => $order], 200);
    }

    public function invoice($number){
        $html = view('layouts.pdf', ['number' => $number]);
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper(array(0, 0, 895.28, 765.89), 'landscape');
        return $pdf->download('invoice');
    }
}