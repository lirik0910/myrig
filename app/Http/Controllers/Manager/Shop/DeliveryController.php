<?php

namespace App\Http\Controllers\Manager\Shop;

use Illuminate\Http\Request;
use App\Model\Shop\Delivery;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class DeliveryController extends Controller
{
	/**
	 * Get deliveries
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all() : JsonResponse
	{
		/** Try get all models
		 */
		try {
			$all = Delivery::all();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($all, 200);
	}
}
