<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
	public function variables()
	{
		return $this->belongsToMany(Variable::class, 'view_variables', 'view_id');
	}
}
