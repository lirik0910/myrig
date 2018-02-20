<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    public function order(){
        return $this->hasOne('App\Order');
    }

    public function delivery(){
        return $this->belongsTo('App\Delivery');
    }
}
