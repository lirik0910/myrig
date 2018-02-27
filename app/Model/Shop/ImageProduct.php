<?php

namespace App;

use App\Model\Shop\Product;
use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function image(){
        return $this->belongsTo(Image::class);
    }
}
