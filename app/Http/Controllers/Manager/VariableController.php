<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\Base\View;

class VariableController extends Controller
{
	/**
	 * Get all additional fields by view id
	 * @param int $id View id
	 * @return JsonResponse
	 */
	public function all(int $id)
	{
		try {
			$views = View::find($id)->variable()->get();
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}
		
		return response()->json($views, 200);
	}
}
