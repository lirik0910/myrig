<?php

namespace App\Http\Controllers\Manager\Shop;

use App\Model\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Model\Shop\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\CreateProductRequest;
use App\Model\Shop\ExchangeRate;

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
					->orWhere('title', 'like', '%'. $params['search'] .'%')
					->orWhereHas('categories', function ($q) use ($params) {
						$q->where('title', 'like', '%'. $params['search'] .'%');
					});
		}

		/** Filter by context_id
		 */
		if (isset($params['context_id'])) {
			$c = $c->where('context_id', $params['context_id']);
		}

		/** Filter by category_id
		 */
		if (isset($params['category_id'])) {
			$c = $c
					->join('product_categories', 'products.id', '=', 'product_id')
					->where('category_id', $params['category_id']);
		}

		if (isset($params['delete_type'])) {
			$c = $c->where('delete', $params['delete_type']);
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
				//->with('category')
				->with('options');
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

		if ($request->input('start') && $request->input('limit')) {
			$all = $all->forPage($request->input('start'), $request->input('limit'));
			//var_dump($c);
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

		foreach ($all as $item) {

			/** If auto price regime
			 */
			if ($item->auto_price === 1) {
				$item->price = $item->calcAutoPrice();
			}
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

		/** Add product with categories
		 */
		if ($request->input('categories_line') !== null) {
			try {
				$model->setCategories($request->input('categories_line'));
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return response()->json(['message' => $e->getMessage()], 422);
			}
		}

		/** Add or update auto price settings
		 */
		if ($request->input('product_auto_prices')) {
			try {
				$model->setAutoPrices($request->input('product_auto_prices'));
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
				->with('categories')
				->with('productAutoPrices')
				->with('images')
				->find($id);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		$btc = ExchangeRate::where('title', 'BTC/USD')->first();
		if($btc === NULL){
		    $btc = 1;
        }

		return response()->json(['product' => $model, 'btc' => $btc], 200);
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

		/** Add product with categories
		 */
		if ($request->input('categories_line') !== null) {
			try {
				$model->setCategories($request->input('categories_line'));
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
				$model->setOptions(trim($request->input('options')));
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return response()->json(['message' => $e->getMessage()], 422);
			}
		}

		/** Add or update auto price settings
		 */
		if ($request->input('product_auto_prices')) {
			try {
				$model->setAutoPrices($request->input('product_auto_prices'));
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

	/**
	 * Send product to trash
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function trash(int $id) : JsonResponse
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

		if ($model->delete === 1) {
			$model->delete = 0;
		}
		else {
			$model->delete = 1;	
		}

		$model->save();
		return response()->json(['message' => true], 200);
	}

	/**
	 * Send many products to trash
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function trashMany(Request $request) : JsonResponse
	{
		foreach ($request->input() as $item) {
			/** Try to get model
			 */
			try {
				$model = Product::find($item);
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return response()->json(['message' => $e->getMessage()], 422);
			}

			if ($model->delete === 1) {
				$model->delete = 0;
			}
			else {
				$model->delete = 1;
			}
			$model->save();
		}
		return response()->json(['message' => true], 200);
	}

	/**
	 * Empty product trash
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function emptyTrash() : JsonResponse
	{
		/** Try get collection
		 */
		try {
			$all = Product::where('delete', 1)->get();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		foreach ($all as $item) {
			$item->delete();
		}
		return response()->json(['message' => true], 200);
	}
}