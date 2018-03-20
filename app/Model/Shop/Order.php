<?php

namespace App\Model\Shop;

use App\Model\Base\User;
use App\Model\Base\Context;
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
	 * Get order products
	 * @return boolean
	 */
	public function products()
	{
		return $this->belongsToMany(Product::class, 'carts', 'order_id', 'product_id')->withPivot('count');
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

            if($item->product->auto_price){
                $price = number_format($item->product->calcAutoPrice(), 2, '.', '');
            } else{
                $price = number_format($item->product->price, 2, '.', '');
            }
			//$price = $item->product->price;
			$count = $item->count;

			$cost += ($count * $price);
		}
		$this->cost = $cost;

		return $cost;
	}

	/**
	 * Change order status
	 * @return boolean
	 */
	public function changeStatus()
	{

	}

	public function addProduct()
	{
		
	}
}
