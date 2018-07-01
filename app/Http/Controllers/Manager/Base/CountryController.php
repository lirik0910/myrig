<?php

namespace App\Http\Controllers\Manager\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
	/**
	 * Get all pages
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function all() : JsonResponse
	{
		return response()->json([
			['id' => 'AZ', 'title' => 'Azerbaijan'],
			['id' => 'AM', 'title' => 'Armenia'],
			['id' => 'BY', 'title' => 'Belarus'],
			['id' => 'GE', 'title' => 'Georgia'],
			['id' => 'KZ', 'title' => 'Kazakhstan'],
			['id' => 'KG', 'title' => 'Kyrgyzstan'],
			['id' => 'TM', 'title' => 'Turkmenistan'],
			['id' => 'UZ', 'title' => 'Uzbekistan'],
			['id' => 'UA', 'title' => 'Ukraine'],
			['id' => 'RU', 'title' => 'Russia']
		], 200);
	}
}
