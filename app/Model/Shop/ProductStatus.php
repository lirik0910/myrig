<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    public function product()
    {
    	return $this->hasOne(Product::class);
    }
}
