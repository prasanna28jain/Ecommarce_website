<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FrontendCartController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cartItems = Cart::with('product.images', 'variation')
            ->where('user_id', Auth::id())
            ->get()
            ->filter(fn ($item) => $item->product)
            ->values();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')
                ->with('error', 'Your cart is empty. Please add products first.');
        }

        $subtotal = (float) $cartItems->sum(fn ($item) => (int) $item->quantity * (float) $item->price);
        $appliedCoupon = $this->getAppliedCouponSummary($subtotal);
        $discount = (float) ($appliedCoupon['discount'] ?? 0);
        $grandTotal = max(0, $subtotal - $discount);

        return view('frontend.cart.index', compact('cartItems', 'subtotal', 'discount', 'grandTotal', 'appliedCoupon'));
    }

    public function add(Request $request)
    {
        if (! Auth::check()) {
            session(['url.intended' => url()->previous()]);

            return redirect()->route('login')
                ->with('error', 'Please login first to add products to cart.');
        }

        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variation_id' => 'nullable|integer|exists:product_variations,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::with(['variations' => fn ($q) => $q->where('is_active', true)])->findOrFail($data['product_id']);

        $hasActiveVariations = $product->variations->isNotEmpty();
        $selectedVariation = null;

        if ($hasActiveVariations) {
            if (empty($data['product_variation_id'])) {
                return back()->with('error', 'Please select a variation before adding to cart.');
            }

            $selectedVariation = ProductVariation::query()
                ->where('id', (int) $data['product_variation_id'])
                ->where('product_id', $product->id)
                ->where('is_active', true)
                ->first();

            if (! $selectedVariation) {
                return back()->with('error', 'Selected variation is invalid or unavailable.');
            }
        }

        $variationId = $selectedVariation?->id;
        $unitPrice = $selectedVariation ? (float) $selectedVariation->price : (float) ($product->sale_price ?? $product->base_price);

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $product->id)
                        ->where('product_variation_id', $variationId)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += (int) $data['quantity'];
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'product_variation_id' => $variationId,
                'quantity' => (int) $data['quantity'],
                'price' => $unitPrice,
            ]);
        }

        return back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        abort_if($cart->user_id !== Auth::id(), 403);

        $data = $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart->update([
            'quantity' => (int) $data['quantity'],
        ]);

        return back()->with('success', 'Cart quantity updated.');
    }

    public function destroy(Cart $cart): RedirectResponse
    {
        abort_if($cart->user_id !== Auth::id(), 403);

        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    private function getAppliedCouponSummary(float $subtotal): ?array
    {
        $stored = session('checkout_coupon');
        $code = strtoupper(trim((string) ($stored['code'] ?? '')));

        if ($code === '') {
            return null;
        }

        $coupon = Coupon::whereRaw('UPPER(code) = ?', [$code])->first();
        if (! $coupon || ! $this->isCouponApplicable($coupon, $subtotal)) {
            session()->forget('checkout_coupon');
            return null;
        }

        $discount = $this->calculateCouponDiscount($coupon, $subtotal);

        return [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'amount' => (float) $coupon->amount,
            'discount' => $discount,
        ];
    }

    private function isCouponApplicable(Coupon $coupon, float $subtotal): bool
    {
        if (! $coupon->is_active) {
            return false;
        }

        $now = now();

        if ($coupon->starts_at && $coupon->starts_at->greaterThan($now)) {
            return false;
        }

        if ($coupon->expires_at && $coupon->expires_at->lessThan($now)) {
            return false;
        }

        if (! is_null($coupon->max_uses) && (int) $coupon->used_count >= (int) $coupon->max_uses) {
            return false;
        }

        if (! is_null($coupon->min_order_amount) && $subtotal < (float) $coupon->min_order_amount) {
            return false;
        }

        return true;
    }

    private function calculateCouponDiscount(Coupon $coupon, float $subtotal): float
    {
        if ($coupon->type === 'percent') {
            $discount = ($subtotal * (float) $coupon->amount) / 100;
        } else {
            $discount = (float) $coupon->amount;
        }

        $discount = max(0, $discount);

        return min($discount, $subtotal);
    }
}
