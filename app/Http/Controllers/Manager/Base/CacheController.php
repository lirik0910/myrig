<?php

namespace App\Http\Controllers\Manager\Base;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CacheController extends Controller
{
	public function delete() : JsonResponse
	{
		/** Try delete previews images
		 */
		try {
			Storage::disk('public')->deleteDirectory('preview/', true);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try delete laravel cache
		 */
		try {
			Artisan::call('cache:clear');
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json(['message' => true], 200);
	}
}
