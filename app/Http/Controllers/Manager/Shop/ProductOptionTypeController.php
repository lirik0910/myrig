<?php

namespace App\Http\Controllers\Manager\Shop;

use Illuminate\Http\Request;
use App\Model\Shop\ProductOptionType;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProductOptionTypeController extends Controller
{
	/**
	 * Get all options
	 * @return Illuminate\Http\JsonResponse;
	 */
	public function all() : JsonResponse
	{
		try {
			$all = ProductOptionType::all();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($all, 200);
	}
}
