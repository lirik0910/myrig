<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
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

	public function type()
	{
		return $this->belongsTo(ProductOptionType::class);
	}
}
