<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Model\Shop\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
	/**
	 * Get all products
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all(Request $request) : JsonResponse
	{
		/** Try count all models
		 */
		try {
			$total = Product::all()->count();
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try get all models
		 */
		try {
			if ($request->input('search')) {
				$all = Product::where('id', $request->input('search'))
						->orWhere('title', 'like', '%'. $request->input('search') .'%')
						->get();
				$all = $all->forPage($request->get('start'), $request->get('limit'));
			}
			
			else $all = Product::all()->forPage($request->get('start'), $request->get('limit'));
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json(['total' => $total, 'data' => $all], 200);
	}
}
