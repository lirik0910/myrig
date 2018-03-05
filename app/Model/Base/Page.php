<?php

namespace App\Model\Base;

use http\Env\Request;
use App\Model\Shop\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Page extends Model
{
	protected $guarded = [];

	/**
	 * Bind page with context model
	 * @return boolean
	 */
	public function context()
	{
		return $this->belongsTo(Context::class);
	}

	/**
	 * Bind page with view
	 * @return boolean
	 */
	public function view()
	{
		return $this->belongsTo(View::class);
	}

	/** 
	 * Get varuables
	 * @return boolean
	 */
	public function variables()
	{
		return $this->belongsToMany(Variable::class, 'variable_contents')->withPivot('content', 'name');
	}

	/**
	 * Bind with Variable and Variable multi content model
	 * @return boolean
	 */
	public function multivariables()
	{
		return $this->belongsToMany(Variable::class, 'variable_multi_contents')->withPivot('name', 'content', 'content_id');
	}

	/**
	 * Remove all childs of certain page
	 * @param {Int} $id
	 * @return {Boolean}
	 */
	public static function removeChilds(int $id)
	{
		$childs = Page::where('parent_id', $id)->get();
		foreach ($childs as $page) {

			/** Try delete model
			 */
			try {
				$page->delete();
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				throw new \Exception($e->getMessage(), 1);
			}
			Page::removeChilds($page->id);
		}

		return true;
	}
}
