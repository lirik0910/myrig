<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 04.04.2018
 * Time: 19:24
 */

namespace App\Http\Controllers\Manager\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\Shop\Report;
use App\Model\Shop\ExchangeRate;
use App\Http\Controllers\Controller;


class ReportController extends Controller
{
    /**
     * Get all reports
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request) : JsonResponse
    {
        /** Try set params to query
         */
        try {
            $all = Report::select();
            $all = $this->setParamsBeforeQuery($all, $request->all());
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        /** Try count all models
         */
        try {
            $total = $all->count();
        }
        catch(\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        /** Add pagination and get
         */
        try {
            $all = $this->setPaginationQuery($all, $request->all());
            $all = $all->orderBy('id', 'desc')->get();
        }
        catch(\Exception $e) {
            logger($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 422);
        }

        /** Get BTC rate
         */
        $btcRate = ExchangeRate::where('title', 'BTC/USD')->first();
        $point = 1 / (float) $btcRate->value;

        foreach ($all as $order) {
            $order->status;
            $order->context;
            $order->paymentType;
            $order->orderDeliveries->delivery;

            //$order->btc_price = ($order->cost * $point) / 1;

            foreach ($order->carts as $cart) {
                $cart->product->images;
                $order->btc_price += $cart->btcCost * $cart->count;
            }

            foreach ($order->logs as $log) {
                $log->user;
            }
        }

        return response()->json([
            'total' => $total,
            'data' => $all
        ], 200);
    }
}