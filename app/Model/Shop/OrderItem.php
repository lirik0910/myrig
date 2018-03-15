<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];
    /**
     * Get order
     * @return boolean
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get product
     * @return boolean
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
