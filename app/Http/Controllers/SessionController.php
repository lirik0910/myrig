<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class SessionController extends Controller
{
    public $cart;

    public function __construct()
    {
        if(isset($_SESSION['cart'])){
            $this->cart = $_SESSION['cart'];
        } else{
            $this->cart = [];
        }
    }

    /**
	 * Add new product to cart server session
	 * @param Illuminate\Http\Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function add(Request $request) : JsonResponse
	{
		$_SESSION['cart'][$request->input('id')] = $request->input('count');
		return response()->json(['message' => true], 200);
	}

	/** 
	 * Delete item from cart server session
	 * @param Illuminate\Http\Request $request
	 */
	public function delete(Request $request)
	{
		unset($_SESSION['cart'][$request->input('id')]);
		return response($this->cart);
	}

	/**
	 * Get array cart from server session
	 * @param Illuminate\Http\Request $request
	 */
	public function get(Request $request)
	{
		return response($this->cart);
	}
}
