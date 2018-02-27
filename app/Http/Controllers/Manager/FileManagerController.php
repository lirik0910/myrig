<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Base\FileManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
	/**
	 * Get folders inside current dir
	 * @param {Request} $request
	 * @return JsonResponse
	 */
	public function folder(Request $request) : JsonResponse
	{
		$request->validate([
			'path' => [
				'max:255',
				'string',
				'regex:/^[^*?"<>|:]*$/'
			]
		]);

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
	 * Get folders inside current dir
	 * @param {Request} $request
	 * @return JsonResponse
	 */
	public function file(Request $request) : JsonResponse
	{
		$request->validate([
			'path' => [
				'max:255',
				'string',
				'regex:/^[^*?"<>|:]*$/'
			]
		]);

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
			$files[] = [
				'name' => $file,
				'type' => File::extension($file),
				'url' => Storage::disk('uploads')->url($file)
			];
		}

		return response()->json($files, 200);
	}

	/**
	 * Rename folder
	 * @param Request $request
	 * @return 
	 */
	public function rename(Request $request) : JsonResponse
	{
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
	public function deleteFolder(Request $request) : JsonResponse
	{
		$request->validate([
			'path' => [
				'max:255',
				'string',
				'regex:/^[^*?"<>|:]*$/'
			]
		]);

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
	 * Delete file
	 * @param Request $request
	 * @return 
	 */
	public function deleteFile(Request $request) : JsonResponse
	{
		$request->validate([
			'path' => [
				'max:255',
				'string',
				'regex:/^[^*?"<>|:]*$/'
			]
		]);

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
	 * Create new folder
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function createFolder(Request $request) : JsonResponse
	{
		$request->validate([
			'path' => [
				'max:255',
				'string',
				'regex:/^[^*?"<>|:]*$/'
			]
		]);

		try {
			Storage::disk('uploads')->makeDirectory($request->input('path'));
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
	public function createFile(Request $request) : JsonResponse
	{
		$request->validate([
			'path' => [
				'max:255',
				'string',
				'regex:/^[^*?"<>|:]*$/'
			]
		]);

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
