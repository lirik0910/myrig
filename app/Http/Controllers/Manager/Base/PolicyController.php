<?php

namespace App\Http\Controllers\Manager\Base;

use App\Model\Base\Policy;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

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
