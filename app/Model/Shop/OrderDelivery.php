<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
	/**
	 * Bind with order
	 * @return boolean
	 */
	public function order()
	{
		return $this->hasOne(Order::class);
	}

	/**
	 * Bind with delivery
	 * @return boolean
	 */
	public function delivery()
	{
		return $this->belongsTo(Delivery::class);
	}
}
