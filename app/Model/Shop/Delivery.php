<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public function orderDeliveries()
    {
        return $this->hasMany('App\Model\Shop\OrderDelivery');
    }
}
