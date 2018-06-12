<?php

namespace App\Http\Controllers\Manager\Shop;

use Illuminate\Http\Request;
use App\Model\Shop\ProductStatus;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProductStatusController extends Controller
{
    /**
	 * Get all statuses
	 * @return Illuminate\Http\JsonResponse;
	 */
	public function all() : JsonResponse
	{
		try {
			$all = ProductStatus::all();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($all, 200);
	}
}
