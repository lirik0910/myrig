<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Cart extends Model
{
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
		return $this->hasOne(Order::class);
	}

	/**
	 * Get current cart content
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getCartProducts() : Collection
	{

	}

	/**
	 *
	 */
	public function calculateCartCost()
	{

	}
}
