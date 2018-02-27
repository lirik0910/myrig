<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Model\Base\Component;

class ComponentController extends Controller
{
	/**
	 * Get json array of all views
	 */
	public function all() : JsonResponse
	{
		return response()->json(Component::all(), 200);
	}
}
