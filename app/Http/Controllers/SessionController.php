<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class SessionController extends Controller
{
	/**
	 * Add new product to cart server session
	 * @param Illuminate\Http\Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function add(Request $request) : JsonResponse
	{
		$cart = json_decode(session('cart'), true);
		$cart[$request->input('id')] = $request->input('count');

		session()->forget('cart');
		session(['cart' => json_encode($cart)]);

		return response()->json(['message' => true], 200);
	}

	/** 
	 * Delete item from cart server session
	 * @param Illuminate\Http\Request $request
	 */
	public function delete(Request $request)
	{
		$cart = json_decode(session('cart'), true);

		/** Try remove item
		 */
		try {
			unset($cart[$request->input('id')]);
		}
		catch (\Exception $e) {
			logger($e->getMessage());
			return response(session('cart'));
		}

		session()->forget('cart');
		session(['cart' => json_encode($cart)]);

		return response(session('cart'));
	}

	/**
	 * Get array cart from server session
	 * @param Illuminate\Http\Request $request
	 */
	public function get(Request $request)
	{
		return response(session('cart'));
	}
}
