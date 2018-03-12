<?php

namespace App\Http\Controllers\Manager\Base;

use App\Model\Base\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Model\Base\VariableContent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditPageRequest;
use App\Http\Requests\CreatePageRequest;
use Illuminate\Database\Eloquent\Collection;

class PageController extends Controller
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

		/** Filter by parent_id
		 */
		if (isset($params['parent_id'])) {
			$c = $c->where('parent_id', $params['parent_id']);
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
	 * Get all pages
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all(Request $request) : JsonResponse
	{
		/** Try set params to query
		 */
		try {
			$all = Page::select();
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

		/** Check parent has childs page
		 */
		foreach ($all as &$item) {
			if (Page::where('parent_id', $item->id)->first()) {
				$item->issetChilds = true;
			}
			else $item->issetChilds = false;
		}

		return response()->json(['total' => $total, 'data' => $all], 200);
	}

	/**
	 * Get data of certain page
	 * @param int $id
	 * @return JsonResponse
	 */
	public function get(int $id) : JsonResponse
	{
		/** Try get model
		 */
		try {
			$page = Page::find($id);
			$page->view;

			$a = [];
			foreach ($page->view->variables as $item) {
				if ($item->type === 'multi') {
					foreach ($item->multiVariableLines as $line) {
						$c = [];
						foreach ($line->content as $value) {
							$c[$value->multiVariable->title] = $value->content;
						}
						$a[$item->title][] = $c;
					}
					$item->columns;
				}

				else {
					$item->variable_content = [];
					$variableContent = VariableContent::where('page_id', $id)->get();
					if ($variableContent) {
						$item->variable_content = $variableContent;
					}
				}
			}
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}
		
		return response()->json($page, 200);
	}

	/**
	 * Delete certain page
	 * @param {Int} $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(int $id) : JsonResponse
	{
		/** Try get page model
		 */
		try {
			$model = Page::find($id);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try remove all childrean pages
		 */
		try {
			Page::removeChilds($model->id);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try remove current page model
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
	 * Create new page
	 * @param CreatePageRequest $request
	 * @return JsonResponse
	 */
	public function create(CreatePageRequest $request)
	{
		$data = $request->all();

		/** Content data about user that created current page
		 */
		if (Auth::user()) {
			$data['createdby_id'] = Auth::user()->id;
			$data['updatedby_id'] = Auth::user()->id;
		}

		/** Delete slashes from start and end of the link line
		 */
		$data['link'] = rtrim(ltrim($data['link'], '/\\'), '/\\');

		/** Create new model
		 */
		$model = new Page;
		$model->fill($data);
		
		/** Try safe new model
		 */
		try {
			$model->save();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($model, 200);
	}

	/**
	 * Update certain page
	 * @param {Int} $id Page ID
	 * @param {EditPageRequest} $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(int $id, EditPageRequest $request) : JsonResponse
	{
		/** Value of the link field must be only one
		 */
		try {
			$request->validate([
				'link' => [Rule::unique('pages')->ignore($id)]
			]);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		$data = $request->only([
			'title',
			'description',
			'introtext',
			'content',
			'context_id',
			'parent_id',
			'view_id',
			'link'
		]);

		/** Content data about user that created current page
		 */
		if (Auth::user()) {
			$data['createdby_id'] = Auth::user()->id;
			$data['updatedby_id'] = Auth::user()->id;
		}

		/** Delete slashes from start and end of the link line
		 */
		$data['link'] = rtrim(ltrim($data['link'], '/\\'), '/\\');

		/** Try get page model
		 */
		try {
			$page = Page::find($id);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		$page->fill($data);
		
		/** Try safe model
		 */
		try {
			$page->save();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try to update content of additional fields
		 */
		try {
			VariableContent::content($id, $request->input('fields'));
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json($page, 200);
	}
}
