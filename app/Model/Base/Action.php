<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
	/**
	 * Belong width policy model
	 * @return boolean
	 */
	public function policies()
	{
		return $this->belongsToMany(Policy::class, 'policy_actions');
	}
}
