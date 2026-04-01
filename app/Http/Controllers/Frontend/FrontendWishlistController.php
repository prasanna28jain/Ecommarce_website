<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FrontendWishlistController extends Controller
{
    public function index(): View
    {
        $items = Wishlist::with('product.images', 'product.category', 'variation')
            ->where('user_id', Auth::id())
            ->latest('id')
            ->paginate(20);

        return view('frontend.wishlist.index', compact('items'));
    }

    public function toggle(Request $request)
    {
        if (! Auth::check()) {
            session(['url.intended' => url()->previous()]);

            return redirect()->route('login')
                ->with('error', 'Please login first to add products to wishlist.');
        }

        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variation_id' => 'nullable|integer|exists:product_variations,id',
        ]);

        $product = Product::with(['variations' => fn ($q) => $q->where('is_active', true)])
            ->findOrFail((int) $data['product_id']);

        $hasActiveVariations = $product->variations->isNotEmpty();
        $variationId = null;

        if ($hasActiveVariations) {
            if (empty($data['product_variation_id'])) {
                return back()->with('error', 'Please select a variation before adding to wishlist.');
            }

            $variation = ProductVariation::query()
                ->where('id', (int) $data['product_variation_id'])
                ->where('product_id', $product->id)
                ->where('is_active', true)
                ->first();

            if (! $variation) {
                return back()->with('error', 'Selected variation is invalid or unavailable.');
            }

            $variationId = $variation->id;
        }

        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('product_variation_id', $variationId)
            ->first();

        if ($existing) {
            $existing->delete();

            return back()->with('success', 'Removed from wishlist.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'product_variation_id' => $variationId,
        ]);

        return back()->with('success', 'Added to wishlist.');
    }
}
