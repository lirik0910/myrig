<?php

namespace App\Http\Controllers\Manager\Base;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class LexiconController extends Controller
{
	/**
	 * Get certain langs array
	 * @param lluminate\Http\Request $request
	 * @return Illuminate\Http\JsonResponse
	 */
	public function one(string $lang, Request $request) : JsonResponse
	{
		$part = $request->input('part');
		if (!$part) {
			$part = 'manager';
		}

		\App::setLocale($lang);
		return response()->json(\Lang::get($part), 200);
	}
}
