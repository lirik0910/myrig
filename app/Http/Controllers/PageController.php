<?php

namespace App\Http\Controllers;

use App\Model\Base\Page;
use App\Model\Base\Setting;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

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

		if ($page = Page::where('link', $link)->with('multivariables')->first()) {
			return view($page->view->path, [
				'it' => $page,
				'get' => $this->get(),
				'request' => $request,
				'select' => $this->select(),
				'settings' => $this->settings(),
				'inCart' => $this->getInSessionCart(),
				'migx' => Page::convertMVs($page->multivariables),
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

	/**
	 * Get products in cart from session
	 * @return array
	 */
	public function getInSessionCart() : array
	{
		$a = json_decode(session('cart'), true);
		return $a ? $a : [];
	}

	/**
	 * Get settings collection of current context
	 * @return array
	 */
	public function settings() : array
	{
		try {
			$all = Setting::where('context_id', 1)->get();
		}
		catch (\Exception $e) {
			logger($e->getMessage());

			return [];
		}

		$a = [];
		foreach ($all as $item) {
			$a[$item->title] = $item->value;
		}
		return $a;
	}
}

