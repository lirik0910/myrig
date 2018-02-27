<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class VariableContent extends Model
{
    public function page(){
        return $this->belongsTo(Page::class);
    }
}
