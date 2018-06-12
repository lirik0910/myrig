<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class MultiVariableLine extends Model
{
	protected $guarded = [];

	/**
	 * Bind with Page model
	 * @return boolean
	 */
	public function page()
	{
		return $this->belongsTo(Page::class);
	}

	/**
	 * Bind with Variable model
	 * @return boolean
	 */
	public function variable()
	{
		return $this->belongsTo(Variable::class);
	}

	/**
	 * Get content of multi variables
	 * @return boolean
	 */
	public function content()
	{
		return $this->hasMany(MultiVariableContent::class);
	}
}
