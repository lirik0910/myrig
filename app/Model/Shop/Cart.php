<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Cart extends Model
{
	/**
	 * Get product model
	 * @return boolean
	 */
	public function product()
	{
		return $this->hasOne('App\Model\Shop\Product');
	}

	/**
	 * Get order model
	 * @return boolean
	 */
	public function order()
	{
		return $this->hasOne('App\Model\Shop\Order');
	}

	/**
	 * Get current cart content
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getCartProducts() : Collection
	{

	}
}
