<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
	/**
	 * Get variable content
	 * @return boolean
	 */
	public function variableContent()
	{
		return $this->hasMany(VariableContent::class);
	}

	/**
	 * Get multi variables data lines
	 * @return boolean
	 */
	public function multiVariableLines()
	{
		return $this->hasMany(MultiVariableLine::class);
	}

	/**
	 * Get multi variable fields
	 * @return boolean
	 */
	public function columns()
	{
		return $this->hasMany(MultiVariable::class);
	}
}
