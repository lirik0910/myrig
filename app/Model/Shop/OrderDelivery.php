<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    public function order()
    {
        return $this->hasOne('App\Model\Shop\Order');
    }

    public function delivery()
    {
        return $this->belongsTo('App\Model\Shop\Delivery');
    }
}
