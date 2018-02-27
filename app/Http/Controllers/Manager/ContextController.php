<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Base\Context;

class ContextController extends Controller
{
	public function all()
	{
		return response()->json(Context::all(), 200);
	}
}
