<?php

namespace App\Model\Base;

use App\Model\Shop\Order;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'policy_id', 'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * Bind width policy model
	 * @return boolean
	 */
	public function policy()
	{
		return $this->belongsTo(Policy::class);
	}

	/*
	 * Bind with user attributes model
	 * @return boolean
	 */
	public function attributes()
	{
		return $this->hasOne(UserAttribute::class);
	}

    /*
    * Get user orders
    * @return boolean
    */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
