<?php


namespace App\Model\Base;
use Illuminate\Database\Eloquent\Model;

class VariableMultiContent extends Model
{
    /*
     * Bind with Page model
     * return boolean
     */
    public function page(){
        return $this->belongsTo(Page::class);
    }

}