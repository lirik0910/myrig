<?php

namespace App\Http\Controllers\Manager\Shop;

use App\Mail\MailClass;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMessageClass;
use App\Model\Shop\OrderLog;
use App\Model\Shop\Order;
use App\Model\Base\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class OrderLogController
{
    /**
     * Create order note
     * @param int $id
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNote(Request $request) : JsonResponse
    {
        //$count = $request->input('count');

        $model = new OrderLog();
        $user_id = Auth::user()->id;
        $post = $request->all();

        $model->fill([
            'order_id' => $post['orderId'],
            'user_id' => $user_id,
            'type' => $post['type'],
            'value' => $post['text']
        ]);

        /** Try save order model
         */
        try {
            $model->save();
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        if($post['type'] === 'message'){
            $order = Order::find($post['orderId']);

            if($order->orderDeliveries){
                $emailTo = $order->orderDeliveries->email;
            } else{
                $user = User::find($user_id);
                $emailTo = $user->email;
            }

            try {
                Mail::to($emailTo)->send(new OrderMessageClass($order->id, $post['text']));
            }
            catch (\Exception $e) {
                logger($e->getMessage());
            }
        }

        return response()->json(['message' => true], 200);
    }
}