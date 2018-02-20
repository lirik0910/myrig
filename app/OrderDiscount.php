<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    public function order(){
        return $this->hasOne('App\Order');
    }

    public function promocode(){
        return $this->belongsTo('App\Promocode');
    }
}
