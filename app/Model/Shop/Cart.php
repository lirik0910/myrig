<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Cart extends Model
{
    protected $guarded = [];
	/**
	 * Bind product model
	 * @return boolean
	 */
	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	/**
	 * Get order model
	 * @return boolean
	 */
	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
