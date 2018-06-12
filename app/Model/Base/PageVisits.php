<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class PageVisits extends Model
{
    protected $guarded = [];
    /*
     * Bind Page model
     * @return boolean
     */
    public function page(){
        return $this->belongsTo(Page::class);
    }
}
