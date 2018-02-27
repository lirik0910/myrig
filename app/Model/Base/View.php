<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
	/**
	 * Bind width page model
	 */
	public function page()
	{
		return $this->belongsToMany(Page::class);
	}

	public function viewVariables()
    {
	    return $this->hasMany(ViewVariable::class);
    }
	/**
	 * Bind width variable model
	 */
	public function variable()
	{
		return $this->belongsToMany(Variable::class, 'view_variables', 'view_id', 'variable_id');
	}
}
