<?php

namespace App\Http\Controllers\Manager\Base;

use App\Model\Base\User;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	/**
	 * Add conditions before query
	 * @param object $c
	 * @param array $param
	 * @return object
	 */
	protected function setParamsBeforeQuery($c, array $params)
	{
		/** Filter by search text query
		 */
		if (isset($params['search'])) {
			$c = $c->where('id', $params['search'])
					->orWhereHas('attributes', function ($q) use ($params) {
						$q->where(DB::raw('concat(user_attributes.fname," ",user_attributes.lname)'), 'like', '%' . $params['search'] . '%');
					})
					->orWhere('name', 'like', '%'. $params['search'] .'%')
					->orWhere('email', 'like', '%'. $params['search'] .'%')//;
					->with('attributes');
		}

		$c = $c->with('attributes');

		return $c;
	}

	/**
	 * Pagination query
	 * @param object $c
	 * @param array $param
	 * @return object
	 */
	protected function setPaginationQuery($c, array $params)
	{
		if (isset($params['start']) && isset($params['limit'])) {
			$c = $c->forPage($params['start'], $params['limit']);
		}

		return $c;
	}

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

		/** Try set params to query
		 */
		try {
			$all = User::select();
			$all = $this->setParamsBeforeQuery($all, $request->all());
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}
		/** Try count all models
		 */
		try {
			$total = $all->count();
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Add pagination and get
		 */
		try {
			$all = $this->setPaginationQuery($all, $request->all());
			$all = $all->get();

		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		$usersCount = 0;
		$attrsCount = 0;
		foreach($all as $one){
			$usersCount++;
			if($one->attributes){
				$attrsCount++;
			}
		}

		return response()->json(['total' => $total, 'data' => $all], 200);
	}

	/**
	 * Delete users
	 * @param int $id
	 * @return JsonResponse 
	 */
	public function delete(int $id) : JsonResponse
	{
		/** Try get model
		 */
		try {
			$model = User::find($id);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try remove model
		 */
		try {
			$model->delete();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json(['message' => true], 200);
	}

	/**
	 * Delete many users
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deleteMany(Request $request) : JsonResponse
	{
		foreach ($request->all() as $id) {
			$this->delete($id);
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
			$model = User::with('orders')
				->find($id);

			foreach ($model->orders as $order) {
				$order->orderDeliveries;
			}
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
