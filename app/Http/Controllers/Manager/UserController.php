<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Requests\EditUserRequest;
use App\Http\Controllers\Controller;
use App\Model\Base\User;
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
		try {
			$request->validate([
				'start' => 'numeric',
				'limit' => 'numeric',
				'search' => 'max:255|min:1',
			]);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try get all models
		 */
		try {
			if ($request->input('search')) {
				$all = User::where('id', $request->input('search'))
						->orWhere('name', 'like', '%'. $request->input('search') .'%')
						->orWhere('email', 'like', '%'. $request->input('search') .'%')
						->get();
				$all = $all->forPage($request->get('start'), $request->get('limit'));
			}
			
			else $all = User::all()->forPage($request->get('start'), $request->get('limit'));
		}
		catch (\Exception $e) {
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

	/**
	 * Get certain user
	 * @param int $id User ID
	 * @return JsonResponse 
	 */
	public function get(int $id) : JsonResponse
	{
		/** Try get model
		 */
		try {
			$model = User::find($id);
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($model, 200);
	}

	/**
	 * Update user data
	 * @param int $id
	 * @param EditUserRequest $request
	 * @return JsonResponse
	 */
	public function edit(int $id, EditUserRequest $request) : JsonResponse
	{
		/** Try get model
		 */
		try {
			$model = User::find($id);
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try fill new data
		 */
		try {
			$model->fill($request->only([
				'name',
				'email',
				'policy_id'
			]));
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** If isset fields new_password and confirm_password and they are the same
		 * then try to set new password
		 */
		if ($request->input('new_password') && $request->input('confirm_password')) {
			if ($request->get('new_password') !== $request->get('confirm_password')) {
				return response()->json(['message' => 'Passwords do not match'], 422);
			}

			$model->password = bcrypt($request->get('new_password'));
		}

		/** Try safe model
		 */
		try {
			$model->save();
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($model, 200);
	}
}
