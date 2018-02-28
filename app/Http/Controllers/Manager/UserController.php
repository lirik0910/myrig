<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
	/**
	 * Get users
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function all(Request $request) : JsonResponse
	{
		$request->validate([
			'start' => 'numeric',
			'limit' => 'numeric',
		]);

		/** Try get all models
		 */
		try {
			$all = User::all()->forPage($request->get('start'), $request->get('limit'));
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try count all models
		 */
		try {
			$total = User::all()->count();
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}
		
		return response()->json(['total' => $total, 'data' => $all], 200);
	}

	/**
	 * Delete users
	 * @param Request $request
	 * @return JsonResponse 
	 */
	public function delete(Request $request) : JsonResponse
	{
		try {
			$users = json_decode($request->input('users'), true);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		foreach ($users as $id) {
			try {
				User::find($id)->delete();
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return response()->json(['message' => $e->getMessage()], 422);
			}
		}
		return response()->json(['message' => true], 200);
	}
}
