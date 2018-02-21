<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

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

	public function get(){
	    $pages = $this->get();
	    return $pages;
    }
}
