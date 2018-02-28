<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->hasOne('App\Model\Shop\Category');
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function options(){
        return $this->hasMany(ProductOption::class);
    }
}
