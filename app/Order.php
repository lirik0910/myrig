<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function status(){
        return $this->belongsTo('App\OrderStatus');
    }

    public function paymentType(){
        return $this->belongsTo('App\PaymentType');
    }

    public function orderDeliveries(){
        return $this->hasOne('App\OrderDelivery');
    }
}
