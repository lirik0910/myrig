<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	/**
	 * Bind page width context
	 *
	 */
	public function context() {
		return $this->belongsTo(Context::class);
	}

	/**
	 * Bind page width view
	 *
	 */
	public function view() {
		return $this->belongsTo(View::class);
	}
}
