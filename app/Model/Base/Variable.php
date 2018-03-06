<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
	public function variableContent()
	{
		return $this->hasMany(VariableContent::class);
	}

	public function pages()
	{
		return $this->belongsToMany(Page::class, 'view_variables');
	}
}
