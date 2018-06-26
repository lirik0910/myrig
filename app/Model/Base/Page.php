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
	protected $dates = [
	    'created_at',
        'updated_at',
        'published_at'
    ];

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

	/*
	 * Bind with PageVisits model
	 * @return boolean
	 */
	public function visits()
    {
	    return $this->hasOne(PageVisits::class);
    }

    /*
     * Bind with Product model
     * @return boolean
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }



	/*
	 * Convert multivariables collection object to array
	 * @param object $mvs Multivariables object
	 * @return array
	 */
	public static function convertMVs($mvs) : array
	{
		$migx = [];
		foreach ($mvs as $mv){
			$migx[$mv->title][$mv->pivot->content_id][$mv->pivot->name] = $mv->pivot->content;
		}
		return $migx;
	}

	/**
	 * Bind with Variable and Variable multi content model
	 * @return boolean
	 */
	public function multiVariableLines()
	{
		return $this->hasMany(MultiVariableLine::class);
	}

	public function variableContents()
    {
        return $this->hasMany(VariableContent::class);
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
