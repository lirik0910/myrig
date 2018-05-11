<?php

namespace App\Http\Controllers\Manager\Base;

use App\Model\Base\Context;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ContextController extends Controller
{
	/**
	 * Get all contexts
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all() : JsonResponse
	{
		try {
			$all = Context::all();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($all, 200);
	}
}
