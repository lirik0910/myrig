<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public function products()
    {
        return $this->hasMany('App\Model\Shop\Product');
    }
}
