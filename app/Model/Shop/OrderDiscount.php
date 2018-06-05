<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    public function order()
    {
        return $this->hasOne('App\Model\Shop\Order');
    }

    public function promocode()
    {
        return $this->belongsTo('App\Model\Shop\Promocode');
    }
}
