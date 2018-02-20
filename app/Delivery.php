<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public function orderDeliveries(){
        return $this->hasMany('App\OrderDelivery');
    }
}
