<?php

namespace App\Http\Controllers;

use App\Model\Base\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
	/**
	 * Get page
	 * @param Request $request
	 */
	public function view(Request $request)
	{
		$link = $request->decodedPath();
		$link = $link === '/' ?
			$link :
			rtrim(ltrim($link, '/\\'), '/\\');
		
		if ($page = Page::where('link', $link)->first()) {
			return view($page->view->path, [
				'it' => $page,
				'get' => $this->get(),
				'select' => $this->select(),
			]);
		}

		else abort(404);
	}

	/** 
	 * Get getting page function
	 * @return function
	 */
	public function get()
	{
		return function(int $id) {
			return Page::find($id);
		};
	}

	/** 
	 * Get model select query function
	 * @param function
	 */
	public function select()
	{
		return function($class) {
			return $class::select();
		};
	}
}