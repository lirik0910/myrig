<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class UserAttribute extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'fname', 'lname', 'phone', 'address'
    ];

    /*
     * Bind with User model
     * @return boolean
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
