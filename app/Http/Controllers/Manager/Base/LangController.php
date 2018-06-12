<?php

namespace App\Http\Controllers\Manager\Base;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class LangController extends Controller
{
	/**
	 * Get json array of all views
	 * @param lluminate\Http\Request $request
	 * @return Illuminate\Http\JsonResponse
	 */
	public function all(Request $request) : JsonResponse
	{
		$a = [];
		$scandir = scandir(resource_path() . '/lang');
		foreach ($scandir as $item) {
			if ($item !== '.' && $item !== '..') {
				$a[] = $item;
			}
		}

		return response()->json($a, 200);
	}
}
