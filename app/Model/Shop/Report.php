<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /*
     * Bind with Report products model
     */
    public function products()
    {
        return $this->hasMany(ReportProducts::class);
    }
}
