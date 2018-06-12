<?php

namespace App\Model\Shop;

use App\Model\Base\User;
use Illuminate\Database\Eloquent\Model;

class OrderLog extends Model
{
    protected $guarded = [];

    /**
	 * Bind with user
	 * @return boolean
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
