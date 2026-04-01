<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;

class FrontendBrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->get();
        return view('frontend.brand.index', compact('brands'));
    }

    public function show($id)
    {
        $brand = Brand::with('products.images')->findOrFail($id);
        return view('frontend.brand.show', compact('brand'));
    }
}
