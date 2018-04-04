<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class ReportProducts extends Model
{
    /*
    * Bind with Report model
    */
    public function report()
    {
        return $this->belongsTo(ReportProducts::class);
    }

    /*
    * Bind with Product model
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
