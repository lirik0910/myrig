<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    public function orders()
    {
        return $this->hasMany('App\Model\Shop\Order');
    }
}
