<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function cart(Request $request) {
		$cart = json_decode(session('cart'), true);
		$cart[$request->input('id')] = $request->input('count');

		session()->forget('cart');
		session(['cart' => json_encode($cart)]);

		return response()->json(['message' => true], 200);
	}
}
