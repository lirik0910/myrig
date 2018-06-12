<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class MultiVariable extends Model
{
	/**
	 * Bind page with variable
	 * @return boolean
	 */
	public function variable()
	{
		return $this->belongsTo(Variable::class);
	}
}
