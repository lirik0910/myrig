<?php

namespace App\Http\Controllers\Manager\Shop;

use Illuminate\Http\Request;
use App\Model\Shop\PaymentType;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class PaymentTypeController extends Controller
{
	/**
	 * Get payments
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all() : JsonResponse
	{
		/** Try get all models
		 */
		try {
			$all = PaymentType::all();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($all, 200);
	}
}
