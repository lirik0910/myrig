<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ProductCategory extends Model
{
	/**
	 * Bind products model
	 * @return boolean
	 */
	public function products()
	{
		return $this->hasMany(Product::class);
	}

	/**
	 * Build tree product categories array with childs
	 * @return array
	 */
	public static function getProductCategoriesTree() : array
	{
		try {
			$categories = ProductCategory::all()->keyBy('id');
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			throw new \Exception($e->getMessage(), 1);

			return [];
		}
		
		$a = [];
		foreach ($categories as $key => $item) {
			$a[$key] = $item->toArray();
			$a[$key]['childs'] = ProductCategory::findCategoryChildsByArray($key, $categories);

			if ($item->parent_id !== 0) {
				unset($a[$key]);
			}
		}
		return $a;
	}

	/**
	 * Find childs of certain category from all categories collaction
	 * @param {Int} $id Current category ID
	 * @param {Collection} $data Categories colleaction
	 * @return {Array}
	 */
	public static function findCategoryChildsByArray(int $id, Collection $data) : array
	{
		$a = [];
		foreach ($data as $item) {
			if ($item->parent_id == $id) {
				unset($data[$item->id]);
				
				$a[$item->id] = $item->toArray();
				$a[$item->id]['childs'] = ProductCategory::findCategoryChildsByArray($item->id, $data);
			}
		}
		return $a;
	} 
}
