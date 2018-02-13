<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function product(){
        return $this->hasOne('App\Product');
    }

    public function order(){
        return $this->hasOne('App\Order');
    }
}
