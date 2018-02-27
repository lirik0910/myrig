<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Base\VariableContent;
use Illuminate\Http\JsonResponse;

class VariableContentController extends Controller
{
	/**
	 * Get all variable data by page id
	 * @param int $id Page ID
	 */
	public function all(int $id)
	{
		try {
			$data = VariableContent::where('page_id', $id)->get();
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($data, 200);
	}
}
