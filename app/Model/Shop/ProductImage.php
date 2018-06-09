<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
	protected $guarded = [];
	
	/**
	 * Bind with product
	 * @return boolean
	 */
	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
