<?php

namespace App\Http\Controllers\Manager\Shop;

use Illuminate\Http\Request;
use App\Model\Shop\Currency;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
	/**
	 * Get all currencies
	 * @return Illuminate\Http\JsonResponse;
	 */
	public function all() : JsonResponse
	{
		try {
			$all = Currency::all();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($all, 200);
	}
}
