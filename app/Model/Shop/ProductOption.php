<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
