<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Base\Page;

class PageController extends Controller
{
	/**
	 * Get data of certain page
	 * @return json
	 */
	public function get(int $id) {
		return response()->json(Page::find($id), 200);
	}

	/**
	 * Get pages collection
	 * @return json
	 */
	public function all() {

	}

	/**
	 * Update certain page
	 * @return json
	 */
	public function update() {

	}

	/**
	 * Remove certain page
	 * @return json
	 */
	public function remove() {

	}

	/**
	 * Create new page
	 * @return json
	 */
	public function create() {

	}
}
