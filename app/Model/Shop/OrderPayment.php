<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $guarded = [];
	/**
	 * Bind with order
	 * @return boolean
	 */
	public function order()
	{
		return $this->hasOne(Order::class);
	}

}
