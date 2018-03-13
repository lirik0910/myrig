<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Base\User;
use App\Model\Base\Context;
use App\Model\Shop\Order;
use App\Model\Shop\Delivery;
use App\Model\Shop\PaymentType;
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
            return response()->json(['success' => false, 'message' => 'Please login for continue']);
        }

        $data = $request->post();
        //var_dump($data); die;
        $user = User::where('email', session()->get('client'))->first();
        $context = Context::where('title', 'Base')->first();

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

        //var_dump(Cart::calculateCartCost()); die;

        $order = new Order();
        $order->fill([
            'number' => time() - 2000000,
            'user_id' => $user->id,
            'cost' => Cart::calculateCartCost(),
            'prepayment' => 0,
            'status_id' => 1,
            'paid' => 0,
            'payment_type_id' => $paymentType->id,
            'context_id' => $context->id
        ]);

        try {
            $order->save();
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
//var_dump($order); die;
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

        session()->forget('cart');
        return response()->json(['success' => true, 'order' => $order], 200);
        //var_dump($order->orderDeliveries()); die;
        //var_dump($request->post()); die;
    }


}