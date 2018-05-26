<?php

namespace App\Http\Controllers\Manager\Shop;

use Illuminate\Http\Request;
use App\Model\Shop\Category;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
	 * Get all categories
	 * @return Illuminate\Http\JsonResponse;
	 */
	public function all() : JsonResponse
	{
		try {
			$all = Category::all();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($all, 200);
	}

	/**
	 * Get product data
	 * @return boolean
	 */
	public function products()
	{
		return $this->belongsToMany(Product::class, 'product_categories');
	}
}
