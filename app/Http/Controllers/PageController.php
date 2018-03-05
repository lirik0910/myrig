<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Base\Page;

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
			rtrim(ltrim($request->decodedPath(), '/\\'), '/\\');
		
		if ($page = Page::where('link', $link)->first()) {
			return view($page->view->path, ['page' => $page]);
		}

		else abort(404);
	}
}
