<?php

namespace App\Http\Controllers\Manager\Base;

use App\Model\Base\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
		$c = $c->orderBy('created_at', 'DESC');

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
	 * Send page model to trash
	 * @param int $id
	 * @return JsonResponse
	 */
	public function trash(int $id) : JsonResponse
	{
		/** Try get model
		 */
		try {
			$model = Page::find($id);
		}
		catch(\Exception $e) {
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

			$context = strtolower($page->context->title);

			$a = [];
			foreach ($page->view->variables as $item) {
				if ($item->type === 'multi') {
					foreach ($item->multiVariableLines as $line) {
					    //var_dump($line->page_id, $page->id); die;
					    if($line->page_id == $page->id){
                            $c = [];
                            foreach ($line->content as $value) {
                                $c[$value->multiVariable->title] = $value->content;
                            }
                        //if($line->page_id == $page->id){
                            $a[$item->title][] = $c;
                        }
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
			//var_dump($a); die;
            //var_dump($page->view->variables->multiVariables); die;
		}
		catch(\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}
		
		return response()->json($page, 200);
	}

	/**
	 * Empty trash
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function emptyTrash() : JsonResponse
	{
		/** Try get collection
		 */
		try {
			$all = Page::where('delete', 1)->get();
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		foreach ($all as $item) {
			/** Try remove all childrean pages
			 */
			try {
				Page::removeChilds($item->id);
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return response()->json(['message' => $e->getMessage()], 422);
			}

			/** Try remove current page model
			 */
			try {
				$item->delete();
			}
			catch (\Exception $e) {
				logger($e->getMessage());
				return response()->json(['message' => $e->getMessage()], 422);
			}
		}
		return response()->json(['message' => true], 200);
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

        if($data['parent_id']){
            $currentParentPage = Page::find($data['parent_id']);
            if($currentParentPage){
                $parentPage = Page::where('link', $currentParentPage->link)->where('context_id', $data['context_id'])->first();
            }
        }
		//$parentPage = Page::where('context_id', $data['context_id'])->where('link', explode('/', $data['link'])[0])->first();

		if(isset($parentPage) && $parentPage){
		    $data['parent_id'] = $parentPage->id;
        }

        $data['published'] = $data['published'] === 'true' ? 1 : 0;

        if($data['published']){
            $data['published_at'] = now();
        }
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
				//'link' => [Rule::unique('pages')->ignore($id)]
			]);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}
//var_dump($request->only('context_id')); die;
		$data = $request->only([
			'title',
			'description',
			'introtext',
			'content',
			'context_id',
			'parent_id',
			'view_id',
			'link',
            'published'
		]);

		/** Content data about user that created current page
		 */
		if (Auth::user()) {
			$data['createdby_id'] = Auth::user()->id;
			$data['updatedby_id'] = Auth::user()->id;
		}

		/** Delete slashes from start and end of the link line
		 */
		if ($data['link'] !== '/') {
			$data['link'] = rtrim(ltrim($data['link'], '/\\'), '/\\');
		}


		/** Try get page model
		 */
		try {
			$page = Page::find($id);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response()->json(['message' => $e->getMessage()], 422);
		}

		$data['published'] = $data['published'] === 'true' ? 1 : 0;
		//var_dump($data['published']); die;

        if(!$page->published && $data['published']){
		    $data['published_at'] = now();
        }

		if($data['parent_id']){
		    $currentParentPage = Page::find($data['parent_id']);
		    if($currentParentPage){
		        $parentPage = Page::where('link', $currentParentPage->link)->where('context_id', $data['context_id'])->first();
            }
        }

        //$parentPage = Page::where('context_id', $data['context_id'])->where('link', explode('/', $data['link'])[0])->first();
        if(isset($parentPage) && $parentPage){
            $data['parent_id'] = $parentPage->id;
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
