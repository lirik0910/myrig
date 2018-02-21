<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function status()
    {
        return $this->belongsTo('App\Model\Shop\OrderStatus');
    }

    public function paymentType()
    {
        return $this->belongsTo('App\Model\Shop\PaymentType');
    }

    public function orderDeliveries()
    {
        return $this->hasOne('App\Model\Shop\OrderDelivery');
    }
}
