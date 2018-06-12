<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
	/**
	 * Belong width action model
	 * @return boolean
	 */
	public function actions()
	{
		return $this->belongsToMany(Action::class, 'policy_actions');
	}
}
