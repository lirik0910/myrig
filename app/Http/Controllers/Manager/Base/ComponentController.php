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
	 * @param lluminate\Http\Request $request
	 * @return JsonResponse
	 */
	public function all(Request $request) : JsonResponse
	{
		try {
			$all = Component::select();
			foreach ($request->input('allow_list') as $link) {
				$all = $all->orWhere('link', $link);
			}
			$all = $all->get();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json($e->getMessage(), 422);	
		}

		return response()->json($all, 200);
	}
}
