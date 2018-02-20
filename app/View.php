<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
	/**
	 * Bind width page model
	 */
	public function page() {
		return $this->belongsToMany(Page::class);
	}
}
