<?php

namespace App\Http\Controllers\Manager\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\Shop\ExchangeRate;
use App\Http\Controllers\Controller;

class ExchangeRateController extends Controller
{
	/**
	 * Get properties
	 * @return Illuminate\Http\JsonResponse
	 */
	public function one() : JsonResponse
	{
		try {
			$all = ExchangeRate::where('title', 'coinbase')
				->orWhere('title', 'blockchain')
				->orWhere('title', 'bitstamp')
				->orWhere('title', 'BTC/USD')
				->get();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($all, 200);
	}

	/** 
	 * Update btc rates
	 * @param Illuminate\Http\Request
	 * @return Illuminate\Http\JsonResponse
	 */
	public function update(Request $request) : JsonResponse
	{
		try {
			$model = ExchangeRate::where('title', 'BTC/USD')->first();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		$model->value = $request->input('result');
		$model->save();

		return response()->json(['message' => true], 200);
	}
}
