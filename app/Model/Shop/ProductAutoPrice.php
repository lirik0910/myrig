<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductAutoPrice extends Model
{
	protected $guarded = [];
	
	/**
	 * Get currency
	 * @return boolean
	 */
	public function currency()
	{
		return $this->belongsTo(Currency::class);
	}
}
