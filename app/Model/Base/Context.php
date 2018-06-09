<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class Context extends Model
{
	/**
	 * Bind width page model
	 */
	public function page()
	{
		return $this->belongsToMany(Page::class);
	}
}
