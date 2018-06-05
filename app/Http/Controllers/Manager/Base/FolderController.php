<?php

namespace App\Http\Controllers\Manager\Base;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{
	/**
	 * Get folders inside current dir
	 * @param {Request} $request
	 * @return JsonResponse
	 */
	public function get(Request $request) : JsonResponse
	{
		try {
			$request->validate([
				'path' => [
					'max:255',
					'string',
					'regex:/^[^*?"<>|:]*$/'
				]
			]);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try to get paths array
		 */
		try {
			$folders = Storage::disk('uploads')->directories($request->input('path'));
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		foreach ($folders as &$folder) {
			$explode = explode('/', $folder);
			$folder = array_pop($explode);
		}

		return response()->json($folders, 200);
	}

	/**
	 * Rename folder
	 * @param Request $request
	 * @return 
	 */
	public function rename(Request $request) : JsonResponse
	{
		try {
			$request->validate([
				'path' => [
					'max:255',
					'string',
					'regex:/^[^*?"<>|:]*$/'
				],
				'name' => [
					'max:255',
					'string',
					'regex:/^[^*?"<>|:]*$/'
				]
			]);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try to rename folder
		 */
		try {
			Storage::disk('uploads')->move($request->input('path'), $request->input('name'));
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json(['message' => true], 200);
	}

	/**
	 * Delete folder
	 * @param Request $request
	 * @return 
	 */
	public function delete(Request $request) : JsonResponse
	{
		try {
			$request->validate([
				'path' => [
					'max:255',
					'string',
					'regex:/^[^*?"<>|:]*$/'
				]
			]);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try to rename folder
		 */
		try {
			Storage::disk('uploads')->deleteDirectory($request->input('path'));
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json(['message' => true], 200);
	}

	/**
	 * Create new folder
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function create(Request $request) : JsonResponse
	{
		try {
			$request->validate([
				'path' => [
					'max:255',
					'string',
					'regex:/^[^*?"<>|:]*$/'
				]
			]);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		try {
			Storage::disk('uploads')->makeDirectory($request->input('path'));
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json(['message' => true], 200);
	}
}
