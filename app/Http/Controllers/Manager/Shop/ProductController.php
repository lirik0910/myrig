<?php

namespace App\Http\Controllers\Manager\Shop;

use App\Model\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\Shop\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\CreateProductRequest;

class ProductController extends Controller
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
					->orWhere('title', 'like', '%'. $params['search'] .'%');
		}

		/** Filter by context_id
		 */
		if (isset($params['context_id'])) {
			$c = $c->where('context_id', $params['context_id']);
		}

		/** Filter by category_id
		 */
		if (isset($params['category_id'])) {
			$c = $c->where('category_id', $params['category_id']);
		}

		if (isset($params['start']) && isset($params['limit'])) {
			$c = $c->forPage($params['start'], $params['limit']);
		}

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
	 * Get all products
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all(Request $request) : JsonResponse
	{
		/** Try set params to query
		 */
		try {
			$all = Product::select();
			$all = $this->setParamsBeforeQuery($all, $request->all());
			$all->with('images')
				->with('options')
				->with('category');
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

		return response()->json(['total' => $total, 'data' => $all], 200);
	}

	/**
	 * Create new product
	 * @param App\Http\Requests\CreateProductRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function create(CreateProductRequest $request) : JsonResponse
	{
		/** Get product columns array for getting post data
		 */
		try {
			$columns = Schema::getColumnListing('products');
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try get post data from request object 
		 */
		try {
			$data = $request->only($columns);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Create and fill new product model
		 */
		$model = new Product;
		$model->fill($data);

		/** Try save product model
		 */
		try {
			$model->save();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Add images to product
		 */
		if ($request->input('images')) {
			try {
				$model->setImages($request->input('images'));
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return response()->json(['message' => $e->getMessage()], 422);
			}
		}

		/** Add custom options to product
		 */
		if ($request->input('options')) {
			try {
				$model->setOptions($request->input('options'));
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return response()->json(['message' => $e->getMessage()], 422);
			}
		}

		return response()->json($model, 200);
	}

	/**
	 * Get product by id
	 * @param int $id
	 * @return @return \Illuminate\Http\JsonResponse
	 */
	public function one($id) : JsonResponse
	{
		/** Try get model
		 */
		try {
			$model = Product::with('options')
				->with('category')
				->with('images')
				->find($id);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($model, 200);
	}

	/**
	 * Create new product
	 * @param int $id
	 * @param App\Http\Requests\CreateProductRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(int $id, CreateProductRequest $request) : JsonResponse
	{
		/** Get product columns array for getting post data
		 */
		try {
			$columns = Schema::getColumnListing('products');
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try get post data from request object 
		 */
		try {
			$data = $request->only($columns);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try get model
		 */
		try {
			$model = Product::findOrFail($id);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try fill data and save model
		 */
		try {
			$model->fill($data);
			$model->save();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Add images to product
		 */
		if ($request->input('images')) {
			try {
				$model->setImages($request->input('images'));
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return response()->json(['message' => $e->getMessage()], 422);
			}
		}

		/** Add custom options to product
		 */
		if ($request->input('options')) {
			try {
				$model->setOptions($request->input('options'));
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return response()->json(['message' => $e->getMessage()], 422);
			}
		}

		return response()->json(['message' => true], 200);
	}

	/**
	 * Create new product
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(int $id) : JsonResponse
	{
		/** Try get model
		 */
		try {
			$model = Product::find($id);
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
	 * Delete many products
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
}