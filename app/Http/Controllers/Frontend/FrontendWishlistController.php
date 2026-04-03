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

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['redirect' => route('login')], 401);
            }

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
            $totalCount = Wishlist::where('user_id', Auth::id())->count();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'action' => 'removed',
                    'message' => 'Removed from wishlist.',
                    'total_count' => $totalCount
                ]);
            }

            return back()->with('success', 'Removed from wishlist.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'product_variation_id' => $variationId,
        ]);

        $totalCount = Wishlist::where('user_id', Auth::id())->count();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Added to wishlist.',
                'total_count' => $totalCount
            ]);
        }

        return back()->with('success', 'Added to wishlist.');
    }

    public function moveToCart(Request $request)
    {
        if (! Auth::check()) {
            return response()->json(['redirect' => route('login')], 401);
        }

        $data = $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $userId = Auth::id();
        $movedCount = 0;

        foreach ($data['product_ids'] as $productId) {
            // Find the wishlist entry
            $wishlistItem = Wishlist::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if (! $wishlistItem) {
                continue;
            }

            $product = Product::find($productId);
            if (! $product) {
                continue;
            }

            $variationId = $wishlistItem->product_variation_id;
            $unitPrice = $variationId
                ? (float) optional(\App\Models\ProductVariation::find($variationId))->price
                : (float) ($product->sale_price ?? $product->base_price);

            // Add to cart (increment if exists)
            $cartItem = \App\Models\Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->where('product_variation_id', $variationId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                \App\Models\Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'product_variation_id' => $variationId,
                    'quantity' => 1,
                    'price' => $unitPrice,
                ]);
            }

            // Remove from wishlist
            $wishlistItem->delete();
            $movedCount++;
        }

        $newWishlistCount = Wishlist::where('user_id', $userId)->count();
        $newCartCount = (int) \App\Models\Cart::where('user_id', $userId)->sum('quantity');

        return response()->json([
            'success' => true,
            'moved_count' => $movedCount,
            'wishlist_count' => $newWishlistCount,
            'cart_count' => $newCartCount,
            'message' => $movedCount . ' item(s) moved to cart!',
        ]);
    }

    public function clear(Request $request)
    {
        if (! Auth::check()) {
            return response()->json(['redirect' => route('login')], 401);
        }

        $userId = Auth::id();
        $productIds = $request->input('product_ids', []);

        if (!empty($productIds)) {
            // Remove only selected products
            $deleted = Wishlist::where('user_id', $userId)
                ->whereIn('product_id', $productIds)
                ->delete();
            $message = $deleted . ' item(s) removed from wishlist.';
        } else {
            // Remove all
            $deleted = Wishlist::where('user_id', $userId)->delete();
            $message = 'Wishlist cleared!';
        }

        $newCount = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'success' => true,
            'removed_count' => $deleted,
            'wishlist_count' => $newCount,
            'message' => $message,
        ]);
    }
}
