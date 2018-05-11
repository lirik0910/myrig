<?php

namespace App\Http\Controllers\Manager\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\Shop\ExchangeRate;
use App\Model\Base\Setting;
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
		$valueType = Setting::where('title', 'rate.value_type')->first();
		$valueType->value = $request->input('type');
		$valueType->save();

		$valueCustom = Setting::where('title', 'rate.value_custom')->first();
		$valueCustom->value = $request->input('customValue');
		$valueCustom->save();

		$valueSize = Setting::where('title', 'rate.value_size')->first();
		$valueSize->value = $request->input('amount');
		$valueSize->save();

		try {
			$model = ExchangeRate::where('title', 'BTC/USD')->first();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		$model->countCustomRate();
		$model->save();

		return response()->json(['message' => true], 200);
	}
}
