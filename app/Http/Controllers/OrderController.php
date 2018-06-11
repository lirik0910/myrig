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
use App\Mail\MailClass;
use Illuminate\Support\Facades\Mail;
use App\Model\Shop\ProductAutoPrice;

class OrderController extends Controller
{
    /*
     * Create new client order
     * @return boolean
     */
    public function create(Request $request){

        if (!isset($_SESSION['client'])) {
            //return redirect()->to('sso-login');
            return response()->json(['success' => false, 'session' => false]);
        }

        $data = $request->post();
        $user = User::where('email', $_SESSION['client'])->first();

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
//var_dump($data); die;
        if(!isset($data['delivery'])){
            $delivery = Delivery::where('title', 'Without delivery')->first();
        } else{
            $delivery = Delivery::where('id', $data['delivery'])->where('active', 1)->first();
        }

        if(!$delivery){
            return response()->json(['success' => false, 'message' => 'Delivery with this ID is not exist']);
        }

        $paymentType = PaymentType::where('id', $data['payment_method'])->where('active', 1)->first();

        if(!$paymentType){
            return response()->json(['success' => false, 'message' => 'Payment type with this ID is not exist']);
        }

        $order = new Order();
        $last_order = Order::orderBy('id','desc')->first();
        if(!$last_order){
            $max_id = 1;
            $order_number = $max_id;
        } else{
            $max_id = $last_order->id;
            $order_number = $max_id + 1;
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

        $cart = $_SESSION['cart'];

        foreach ($cart as $productId => $count){
            $product = Product::where('id', $productId)->first();

            if($product->auto_price){
                $btcCost = $product->calcBtcPrice();
                $autoprice_data = $product->calcAutoPrice(true);

                $order->carts()->create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'count' => $count,
                    'cost' => $autoprice_data['total'],
                    'btcCost' => $btcCost,
                    'fes' => $autoprice_data['fes'],
                    'warranty' => $autoprice_data['warranty'],
                    'prime_cost' => $autoprice_data['prime'],
                    'delivery_cost' => $autoprice_data['delivery'],
                    'profit' => $autoprice_data['profit'],
                ]);

            } else{
                $cost = $product->price;
            
                $btcCost = $product->calcBtcPrice();

                $order->carts()->create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'count' => $count,
                    'cost' => $cost,
                    'btcCost' => $btcCost
                ]);
            }
        }

        $order->cost = $order->countCost();
        //var_dump($order->cost); die;
        $order->save();
       

        $number = $order_number;
       // try{
            //Mail::to($data['email'])->send(new MailClass($number));
        //} catch (\Exception $e){

       // }

        unset($_SESSION['cart']);
        //session()->forget('cart');
        return response()->json(['success' => true, 'order' => $order], 200);
    }

    public function invoice(Request $request, $number){
        switch ($request->getSchemeAndHttpHost()) {
            case config('app.ua_domain'):
                $locale = 'ua';
                break;

            case config('app.ru_domain'):
                $locale = 'ru';
                break;

            case config('app.en_domain'):
                $locale = 'en';
                break;

            default:
                $locale = 'ua';
                break;
        }
        App::setLocale($locale);
        //var_dump($locale); die;
        $html = view('layouts.pdf', ['number' => $number]);
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html)->setPaper(array(0, 0, 595.28, 861.89), 'portrait');
        return $pdf->download('invoice');
        //return view('layouts.pdf2', ['number' => $number]);
        //"a4" => array(0, 0, 595.28, 841.89)
        //dpi = 96
    }
}