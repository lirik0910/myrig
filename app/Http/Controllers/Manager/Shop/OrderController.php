<?php

namespace App\Http\Controllers\Manager\Shop;

use App\Model\Shop\Cart;
use App\Model\Shop\Order;
use App\Model\Shop\Product;
use App\Model\Shop\ExchangeRate;
use App\Model\Shop\OrderDelivery;
use Illuminate\Validation\Rule;
use App\Model\Shop\OrderLog;
use Illuminate\Validation\Validatior;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;

use \Google_Client as Google_Client;
use \Google_Service_Sheets as Google_Service_Sheets;
use \Google_Service_Sheets_ValueRange as Google_Service_Sheets_ValueRange;

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

		if (isset($params['delete_type'])) {
			$c = $c->where('delete', $params['delete_type']);
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
		//$btcRate = ExchangeRate::where('title', 'BTC/USD')->first();
		//$point = 1 / (float) $btcRate->value;

		foreach ($all as $order) {
			$order->status;
			$order->context;
			$order->paymentType;
			if($order->orderDeliveries){
                $order->orderDeliveries->delivery;
            }


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
			try{
                //Mail::to($delivery->email)->send(New OrderStatusMail($model));
            } catch ( \Exception $e)
            {

            }

		}

		$orderData = $request->only([
		    'user_id',
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

	/**
	 * Send order to trash
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function trash(int $id) : JsonResponse
	{
		/** Try get model
		 */
		try {
			$model = Order::find($id);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		if ($model->delete === 1) {
			$model->delete = 0;
		}
		else {
			$model->delete = 1;
		}

		$model->save();
		return response()->json(['message' => true], 200);
	}

	/**
	 * Empty trash
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function emptyTrash() : JsonResponse
	{
		/** Get collection
		 */
		try {
			$all = Order::where('delete', 1)->get();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		foreach ($all as $item) {
			$item->delete();
		}

		return response()->json(['message' => true], 200);
	}

	/*
     * Create new client order
     * @return boolean
     */
    public function create(Request $request){
        $order = new Order();
        $last_order = Order::orderBy('id','desc')->first();

        if(!$last_order){
            $max_id = 1;
            $order_number = $max_id;
        } else {
            $max_id = $last_order->id;
            $order_number = $max_id + 1;
        }
		// $request->validate
		$validator = $request->validate([
			'user_id' => 'required',
			'status_id' => 'required',
			'payment_type_id' => 'required',
			'context_id' => 'required',
			'delivery_id' => 'required'
		]);

		$data = $request->input();
		$dataOrder = $request->only('user_id', 'status_id', 'payment_type_id', 'context_id');
		$delivery = $request->input('delivery_id') ?? NULL;

		$dataOrder = array_merge([
            'number' => $order_number,
            'cost' => 0,
            'prepayment' => 0,
            'paid' => 0
		], $dataOrder);
        $order->fill($dataOrder);

        try {
            $order->save();
        }
        catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        $cart = [];
        if(!empty($data['cart'])){
	        $cart = json_decode($data['cart'], TRUE);
        }

        foreach ($cart as $product){
        	$productId = $product['id'];
        	$count = $product['count'] ?? 1;
        	$discount = $product['discount'] ?? 0;
        	$serial = $product['serials_number'] ?? NULL;
            $product = Product::where('id', $productId)->first();

            if($product->auto_price){
                $btcCost = $product->calcBtcPrice();
                $autoprice_data = $product->calcAutoPrice(true);

                $order->carts()->create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'count' => $count,
                    'discount' => $discount,
                    'serial_number' => $serial,
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
                    'discount' => $discount,
                    'cost' => $cost,
                    'btcCost' => $btcCost
                ]);
            }
        }


        $order->cost = $order->countCost();

        $order->orderDeliveries()->create([
            'order_id' => $order->id,
            'delivery_id' => $delivery,
            'cost' => $order->cost,
            'first_name' => $data['d_first_name'] ?? NULL,
            'last_name' => $data['d_last_name'] ?? NULL,
            'address' => $data['d_address'] ?? NULL,
            'phone' => $data['d_phone'] ?? NULL,
            'email' => $data['d_email'] ?? NULL,
            'city' => $data['d_city'] ?? NULL,
            'country' => $data['d_country'] ?? NULL,
            'state' => $data['d_state'] ?? NULL,
            'comment' => $data['d_comment'] ?? NULL,
            'office' => $data['d_office'] ?? NULL,
            'zendesk' => $data['d_zendesk'] ?? NULL,
            'waybill' => $data['d_waybill'] ?? NULL,
            'warranty' => $data['d_warranty'] ?? NULL,
            'passport' => $data['d_passport'] ?? NULL
        ]);

        $order->orderPayments()->create([
            'order_id' => $order->id,
            'cost' => $order->cost,
            'first_name' => $data['p_first_name'] ?? NULL,
            'last_name' => $data['p_last_name'] ?? NULL,
            'city' => $data['p_city'] ?? NULL,
            'country' => $data['p_country'] ?? NULL,
        ]);	 

        try {
	        $order->save();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		if($data['send'] == true){
            $serials = [];
            $products_info = [];
            foreach ($cart as $key => $product) {
                $serials[] = $product['serial_number'] ?? '';
                $products_info[] = $product['title'] . ' * ' . $product['count'];
            }

            $this->googleTableAppend([
                // A. Исполнитель
                Auth::user()->name,
                // B. Номер заказа
                ''.$order_number,
                // C. Номер тикета с зендеска
                $data['d_zendesk'] ?? '-',
                // D. Дата
                $data['created_at'] ?? '-',
                // E. Имя Фамилия
                ($data['d_first_name'] ?? '') . ($data['d_last_name'] ?? '') ?: '-',
                // F. Номер телефона
                $data['d_phone'] ?? '-',
                // G. Почта
                $data['d_email'] ?? '-',
                // H. Что было сделано
                implode(', ', $products_info),
                // I. Серийные номера
                implode(', ', $serials),
                // J. Количество дней гарантии
                $data['d_warranty'] ?? '-',
                // K. Страна
                $data['d_country'] ?? '-',
                // L. Тип доставки
                $order->orderDeliveries->delivery->title,
                // M. ТТН
                $data['d_waybill'] ?? '-',
                // N. Город
                $data['d_city'] ?? '-',
                // O. Дата и время оплаты
                ''
            ]);
        }

        return response()->json(['success' => true, 'order' => $order], 200);
    }

    protected function googleTableAppend($values = []){

		$client = new Google_Client();
		$client->useApplicationDefaultCredentials();
		$client->setScopes(Google_Service_Sheets::SPREADSHEETS);

		$service = new Google_Service_Sheets($client);
		
		$spreadsheetId = env('SPREADSHEET_ID');
		$range = 'A:O';
		$body = new Google_Service_Sheets_ValueRange(['values' => [$values]]);
		$params = ['valueInputOption' => 'RAW'];

		return $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
    }
}
