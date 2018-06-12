<?php

namespace App\Http\Controllers\Manager\Shop;

use App\Model\Shop\OrderLog;
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
        $post = $request->post();
        //var_dump($request->post()); die;

        $model->fill([
            'order_id' => $post['orderId'],
            'user_id' => $user_id,
            'type' => 'note',
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

        return response()->json(['message' => true], 200);
    }
}