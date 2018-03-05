<?php

namespace App\Http\Controllers\Manager\Base;

use Illuminate\Http\Request;
use App\Model\Base\Component;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ComponentController extends Controller
{
	/**
	 * Get json array of all views
	 * @return JsonResponse
	 */
	public function all() : JsonResponse
	{
		try {
			$all = Component::all();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json($e->getMessage(), 422);	
		}

		return response()->json(Component::all(), 200);
	}
}
