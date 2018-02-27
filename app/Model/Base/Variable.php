<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    /**
	 * Bind width ViewVariable model
	 */
	public function viewVariable()
	{
		return $this->belongsToMany(ViewVariable::class);
	}
}
