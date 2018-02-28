<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Base\Policy;
use Illuminate\Http\JsonResponse;

class PolicyController extends Controller
{
	/**
	 * Get list of all access policies
	 * @return 
	 */
	public function all() : JsonResponse
	{
		try {
			$all = Policy::all();
		}
		catch (\Exception $e) {
			logger($e);
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($all, 200);
	}
}
