<?php

namespace App\Http\Controllers\Manager\Shop;

use App\Model\Shop\Cart;
use App\Model\Shop\Order;
use App\Model\Shop\ExchangeRate;
use App\Model\Shop\OrderDelivery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
	/**
	 * Add conditions before query
	 * @param object $c
	 * @param array $param
	 * @return object
	 */
	protected function setParamsBeforeQuery($c, array $params)
	{
		/** Filter by search text query
		 */
		if (isset($params['search'])) {
			$c = $c->where('id', 'like', '%'. $params['search'] .'%')
				->orWhere('number', 'like', '%'. $params['search'] .'%')
				->orWhereHas('orderDeliveries', function ($q) use ($params) {
					$q->where('first_name', 'like', '%'. $params['search'] .'%')
						->orWhere('last_name', 'like', '%'. $params['search'] .'%')
						->orWhere('phone', 'like', '%'. $params['search'] .'%')
						->orWhere('email', 'like', '%'. $params['search'] .'%')
						->orWhere('city', 'like', '%'. $params['search'] .'%')
						->orWhere('address', 'like', '%'. $params['search'] .'%')
						->orWhere('country', 'like', '%'. $params['search'] .'%');
				})
				->orWhereHas('products', function ($q) use ($params) {
					$q->where('title', 'like', '%'. $params['search'] .'%');
				});
		}

		/** Filter by delivery_id
		 */
		if (isset($params['delivery_id'])) {
			$c = $c->whereHas('orderDeliveries', function ($q) use ($params) {
				$q->where('delivery_id', $params['delivery_id']);
			});
		}

		/** Filter by context_id
		 */
		if (isset($params['context_id'])) {
			$c = $c->where('context_id', $params['context_id']);
		}

		/** Filter by status_id
		 */
		if (isset($params['status_id'])) {
			$c = $c->where('status_id', $params['status_id']);
		}

		/** Filter by payment_type_id
		 */
		if (isset($params['payment_type_id'])) {
			$c = $c->where('payment_type_id', $params['payment_type_id']);
		}

		/** Filter by created_at from
		 */
		if (isset($params['created_at_from'])) {
			$from = new \DateTime($params['created_at_from']);
			$c = $c->where('created_at', '>=', $from->format('Y-m-d H:i:s'));
		}

		/** Filter by created_at to
		 */
		if (isset($params['created_at_to'])) {
			$to = new \DateTime($params['created_at_to']);
			$to->modify('+1 day');
			$c = $c->where('created_at', '<', $to->format('Y-m-d H:i:s'));
		}

		return $c;
	}

	/**
	 * Pagination query
	 * @param object $c
	 * @param array $param
	 * @return object
	 */
	protected function setPaginationQuery($c, array $params)
	{
		if (isset($params['start']) && isset($params['limit'])) {
			$c = $c->forPage($params['start'], $params['limit']);
		}

		return $c;
	}

	/**
	 * Get all orders
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all(Request $request) : JsonResponse
	{
		/** Try set params to query
		 */
		try {
			$all = Order::select();
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
				$order->btc_price += $cart->btcCost;
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

	/**
	 * Delete order
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(int $id) : JsonResponse
	{
		/** Try get model
		 */
		try {
			$model = Order::find($id);
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try delete model
		 */
		try {
			$model->delete();
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json([
			'message' => true
		], 200);
	}

	/**
	 * Update order
	 * @param int $id
	 * @param Illuminate\Http\Request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(int $id, Request $request) : JsonResponse
	{
		$count = $request->input('count');

		/** Get current order model
		 */
		try {
			$model = Order::find($id);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Set products to cart
		 */
		if (isset($count) && is_array($count)) {
			$cart_positions = Cart::where('order_id', $id)->get();

            $products_update = array_keys($count);
			foreach ($cart_positions as $cart){


			    if(in_array($cart->product_id, $products_update)){
			        foreach ($count as $key => $item){
			            if($cart->product_id == $key){
                            $cart->count = $item;

                            try {
                                $cart->save();
                            }
                            catch (\Exseption $e) {
                                logger($e->getMessage());
                                return response()->json(['message' => $e->getMessage()], 422);
                            }
                        }
                    }
                } else{
                    $cart->delete();
                    //Cart::where('order_id', $id)->where('product_id', $cart->product_id)->delete();
                }
            }
		}

		/** Get delivery model
		 */
		try {
			$delivery = OrderDelivery::where('order_id', $id)->first();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		$deliveryData = $request->only([
			'delivery_id',
			'first_name',
			'last_name',
			'phone',
			'email',
			'city',
			'country',
			'state',
			'address',
			'comment'
		]);

		$delivery->fill($deliveryData);
		$delivery->save();

		/** Change order status
		 */
		//var_dump($model->status_id, $request->input('status_id')); die;
		if ($model->status_id != $request->input('status_id')) {
			$model->changeStatus($request->input('status_id'));
		}

		$orderData = $request->only([
			'payment_type_id',
			'context_id',
		]);

		/** Fill order data
		 */
		$model->fill($orderData);

		/** Count order cost
		 */
		$model->countCost();

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
