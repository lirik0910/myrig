<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function product()
    {
        return $this->hasOne('App\Model\Shop\Product');
    }

    public function order()
    {
        return $this->hasOne('App\Model\Shop\Order');
    }
}
