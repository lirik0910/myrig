<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function product(){
        return $this->belongsTo('App\Model\Shop\Product');
    }
}
