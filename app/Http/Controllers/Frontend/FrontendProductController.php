<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class FrontendProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand','category','images')->paginate(12);
        return view('frontend.product.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with('variations','images','brand','category')->firstOrFail();
        return view('frontend.product.show', compact('product'));
    }
}
