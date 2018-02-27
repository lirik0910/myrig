<?php

namespace App\Model\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class Page extends Model
{
	protected $guarded = [];
	
	/**
	 * Bind page width context
	 * @return boolean
	 */
	public function context()
	{
		return $this->belongsTo(Context::class);
	}

	/**
	 * Bind page width view
	 * @return boolean
	 */
	public function view()
	{
		return $this->belongsTo(View::class);
	}

	/**
	 * Build tree pages array with childs
	 * @return array
	 */
	public static function getPagesTree() : array
	{
		$pages = Page::all()->keyBy('id');
		$a = [];

		foreach ($pages as $key => $page) {
			$a[$key] = $page->toArray();
			$a[$key]['childs'] = Page::findPageChildsByArray($key, $pages);

			if ($page->parent_id !== 0) {
				unset($a[$key]);
			}
		}
		return $a;
	}

	/**
	 * Find childs of certain page from all pages collaction
	 * @param {Int} $id Current page ID
	 * @param {Collection} $pages Pages colleaction
	 * @return {Array}
	 */
	public static function findPageChildsByArray(int $id, Collection $pages) : array
	{
		$array = [];
		foreach ($pages as $page) {
			if ($page->parent_id == $id) {
				unset($pages[$page->id]);
				$array[$page->id] = $page->toArray();
				$array[$page->id]['childs'] = Page::findPageChildsByArray($page->id, $pages);
			}
		}
		return $array;
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
