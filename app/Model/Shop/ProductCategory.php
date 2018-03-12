<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ProductCategory extends Model
{
	/**
	 * Bind products model
	 * @return boolean
	 */
	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
