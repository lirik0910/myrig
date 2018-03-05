<?php

namespace App\Model\Shop;

use App\Model\Base\User;
use App\Model\Base\Context;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
}
