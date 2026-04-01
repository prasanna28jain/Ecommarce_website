<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $categories = Category::take(6)->get();

        $featuredProducts = Product::where('is_active', true)
            
            ->with('images', 'category')
            ->latest()
            ->take(8)
            ->get();

        $newProducts = Product::where('is_active', true)
            ->with('images', 'category')
            ->latest()
            ->take(8)
            ->get();

        $brands = Brand::get();

        return view('frontend.home', compact('sliders', 'categories', 'featuredProducts', 'newProducts', 'brands'));
    }
}
