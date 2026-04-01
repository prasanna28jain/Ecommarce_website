<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;

class FrontendCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('frontend.category.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::with('products.images')->findOrFail($id);
        return view('frontend.category.show', compact('category'));
    }
}
