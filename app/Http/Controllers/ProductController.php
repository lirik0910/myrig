<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Shop\Product;

class ProductController extends Controller
{
    /*
     * Get content for product page
     * @param (Int) $id Current Product ID
     * return boolean
     */
    public function getContent($id){
        $product = Product::where('id', $id)->with('options')->firstorFail();
        $options = $product::convertOptions($product->options);

        return view('content/product', ['product' => $product, 'options' => $options]);
    }
}
