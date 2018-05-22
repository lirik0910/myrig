<?php

namespace App\Http\Controllers\Manager\Base;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
	/**
	 * Get files
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

		/** Try to get files array
		 */
		try {
			$all = Storage::disk('uploads')->files($request->input('path'));
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		$files = [];
		foreach ($all as $file) {
			$base = Storage::disk('uploads')->url('/');
			$url = Storage::disk('uploads')->url($file);

			$link = str_replace($base, '', $url);

			$files[] = [
				'url' => $url,
				'link' => $link,
				'name' => File::basename($file),
				'type' => File::extension($file),
			];
		}

		return response()->json($files, 200);
	}

	/**
	 * Rename file
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
	 * Delete file
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
			Storage::disk('uploads')->delete($request->input('path'));
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json(['message' => true], 200);
	}

	/**
	 * Create new file
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

		foreach ($request->file('file') as $file) {
			try {
				$file->store($request->input('path'), 'uploads');
			}
			catch (\Exception $e) {
				logger($e->getMessage());

				return response()->json(['message' => $e->getMessage()], 422);
			}
		}

		return response()->json(['message' => true], 200);
	}
}
