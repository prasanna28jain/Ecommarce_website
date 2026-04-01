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
            ->with('images', 'category', 'brand', 'variations')
            ->latest()
            ->take(12)
            ->get();

        $newProducts = Product::where('is_active', true)
            ->with('images', 'category', 'brand', 'variations')
            ->latest()
            ->take(8)
            ->get();

        // Tab categories: top 4 by product count + all products
        $tabCategories = Category::withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->having('products_count', '>', 0)
            ->orderByDesc('products_count')
            ->take(4)
            ->get();

        $brands = Brand::get();

        return view('frontend.home', compact(
            'sliders', 'categories', 'featuredProducts',
            'newProducts', 'tabCategories', 'brands'
        ));
    }
}
