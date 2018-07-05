<?php

namespace App\Model\Shop;

use App\Model\Base\User;
use App\Model\Base\Context;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $guarded = [];

	
	/**
	 * Get order status
	 * @return boolean
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Get order context
	 * @return boolean
	 */
	public function context()
	{
		return $this->belongsTo(Context::class);
	}

	/**
	 * Get order status
	 * @return boolean
	 */
	public function status()
	{
		return $this->belongsTo(OrderStatus::class);
	}

	/**
	 * Get order payment type
	 * @return boolean
	 */
	public function paymentType()
	{
		return $this->belongsTo(PaymentType::class);
	}

	/**
	 * Get order delivery
	 * @return boolean
	 */
	public function orderDeliveries()
	{
		return $this->hasOne(OrderDelivery::class);
	}

	/**
	 * Get order delivery
	 * @return boolean
	 */
	public function orderPayments()
	{
		return $this->hasOne(OrderPayment::class);
	}


	/**
	 * Get order products
	 * @return boolean
	 */
	public function products()
	{
		return $this->belongsToMany(Product::class, 'carts', 'order_id', 'product_id')->withPivot('count', 'cost', 'btcCost');
	}

	/**
	 * Get order products
	 * @return boolean
	 */
	public function carts()
	{
		return $this->hasMany(Cart::class);
	}

	/**
	 * Get order logs
	 * @return boolean
	 */
	public function logs()
	{
		return $this->hasMany(OrderLog::class);
	}

	/**
	 * Generate and set number to order model
	 * @return int
	 */
	public function setNumber()
	{
		/*$time = time();

		$number = 0;
		foreach (str_split($time) as $int) {
			$number += (int) $int;
		}*/
		$this->number = $this->id + 17;
		
		return $number;
	}

	/**
	 * Count order cost
	 * @return float
	 */
	public function countCost()
	{
		$cart = Cart::where('order_id', $this->id)->get();
		
		$cost = 0;
		foreach ($cart as $item) {
			$price = $item->cost;
			$count = $item->count;

			$discount = $item->discount;

			$cost += ($count * ($price - $discount));
		}
		$this->cost = $cost;

		return $cost;
	}

	/**
	 * Change order status
	 * @param int $statusID
	 * @return boolean
	 */
	public function changeStatus(int $statusID)
	{
		$status = OrderStatus::find($statusID);

		$log = new OrderLog;

		$log->order_id = $this->id;
		$log->user_id = Auth::user()->id;

		$log->type = 'status';
		$log->value = $status->title;
		$log->save();
		
		$this->status_id = $statusID;
		$this->save();
	}

	/*
	 * Count BTC cost for order
	 * @param (int) $id Order ID
	 * @return string|float
	 */
	public function countBtcCost()
    {
       // $btc = ExchangeRate::where('title', 'BTC/USD')->first()->value;
        $items = $this->carts()->get();
        $btcCost = 0;
        foreach ($items as $item){
            $btcCost += $item->btcCost * $item->count;
        }

        return number_format($btcCost, 4, '.', '');
    }

	public function addProduct()
	{
		
	}

	/**
	 * Send email by smtp
	 */
	public function sendEmail()
	{

	}
}
