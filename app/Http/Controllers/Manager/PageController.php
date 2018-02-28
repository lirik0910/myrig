<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Base\Page;
use App\Model\Base\VariableContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditPageRequest;
use App\Http\Requests\CreatePageRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection;

class PageController extends Controller
{
	/**
	 * Get data of certain page
	 * @param {Int} $id
	 * @return JsonResponse
	 */
	public function get(int $id) : JsonResponse
	{
		/** Try get model
		 */
		try {
			$page = Page::find($id);
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}
		
		return response()->json($page, 200);
	}

	/**
	 * Get all pages
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all() : JsonResponse
	{
		return response()->json(Page::all(), 200);
	}

	/**
	 * Get tree all pages
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function tree()
	{
		return response()->json(Page::getPagesTree(), 200);
	}

	/**
	 * Get pages collection except certain page
	 * @param {Int} $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function except(int $id) : JsonResponse
	{
		return response()->json(Page::where('id', '!=', $id)->get(), 200);
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
		$data['createdby_id'] = Auth::user()->id;
		$data['updatedby_id'] = Auth::user()->id;

		/** Create new model
		 */
		$model = new Page;
		$model->fill($data);
		
		/** Try safe new model
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
		$request->validate([
			'link' => [Rule::unique('pages')->ignore($id)]
		]);
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
		$data['createdby_id'] = Auth::user()->id;
		$data['updatedby_id'] = Auth::user()->id;

		/** Try get page model
		 */
		try {
			$page = Page::find($id);
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		$page->fill($data);
		
		/** Try safe model
		 */
		try {
			$page->save();
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		VariableContent::content($id, $request->input('fields'));

		return response()->json($page, 200);
	}

	/**
	 * Delete certain page
	 * @param {Int} $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function remove(int $id) : JsonResponse
	{
		/** Try get page model
		 */
		try {
			$page = Page::find($id);
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try remove all childrean pages
		 */
		try {
			Page::removeChilds($page->id);
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		/** Try remove current page model
		 */
		try {
			$page->delete();
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		return response()->json(['message' => true], 200);
	}

	/**
	 * Get pages by parent
	 * @param {Int} $parentID Parent ID
	 */
	public function childs(int $id = 0)
	{
		$pages = Page::where('parent_id', $id)->orderBy('id', 'asc')->get();
		foreach ($pages as &$page) {
			if (Page::where('parent_id', $page->id)->first()) {
				$page->childs = true;
			}
			else $page->childs = false;
			
		}
		return response()->json($pages, 200);
	}
}