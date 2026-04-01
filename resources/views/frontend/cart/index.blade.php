@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-10 border-b border-dark-800">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-heading font-bold uppercase tracking-wide text-white">Your Cart</h1>
        <p class="text-gray-400 mt-2">Update quantity, remove products, and review totals before checkout.</p>
    </div>
</div>

<div class="bg-dark-900 py-12">
    <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            @if(session('success'))
                <div class="bg-green-700/60 border border-green-500 text-white p-4 text-sm font-heading uppercase tracking-wide">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="bg-red-600 text-white p-4 text-sm font-heading uppercase tracking-wide">{{ session('error') }}</div>
            @endif

            @foreach($cartItems as $item)
                <div class="bg-dark-800 border border-dark-700 p-4 md:p-6 flex flex-col md:flex-row gap-4 md:gap-6">
                    <a href="{{ route('product.show', $item->product->slug) }}" class="block w-full md:w-40 h-36 bg-white p-3 shrink-0">
                        @if($item->product->images->count() > 0)
                            <img src="{{ Storage::url($item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain mix-blend-multiply">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                    </a>

                    <div class="flex-1">
                        <a href="{{ route('product.show', $item->product->slug) }}" class="text-white font-heading text-lg uppercase tracking-wide hover:text-brand-500 transition">{{ $item->product->name }}</a>

                        @if($item->variation)
                            @php
                                $attrs = collect($item->variation->attributes ?? [])->map(fn ($val, $key) => ucfirst($key) . ': ' . $val)->implode(' | ');
                            @endphp
                            <div class="mt-1 text-xs uppercase tracking-wider text-gray-400">
                                {{ $attrs !== '' ? $attrs : ('Variation #' . $item->variation->id) }}
                            </div>
                        @endif

                        <div class="mt-2 text-gray-400 text-sm">Unit Price: Rs {{ number_format($item->price, 2) }}</div>
                        <div class="mt-1 text-gray-300 text-sm">Line Total: Rs {{ number_format($item->quantity * $item->price, 2) }}</div>

                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label class="text-xs uppercase tracking-wider text-gray-400">Qty</label>
                                <input type="number" name="quantity" min="1" max="99" value="{{ $item->quantity }}" class="w-20 bg-dark-900 border border-dark-700 text-white px-3 py-2 text-sm">
                                <button type="submit" class="px-3 py-2 border border-brand-500 text-brand-500 hover:bg-brand-500 hover:text-white transition text-xs uppercase tracking-widest">Update</button>
                            </form>

                            <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 border border-red-500 text-red-400 hover:bg-red-500 hover:text-white transition text-xs uppercase tracking-widest">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            <div class="bg-dark-800 border border-dark-700 p-6 sticky top-24">
                <h2 class="font-heading text-xl text-white uppercase tracking-wide mb-4">Cart Summary</h2>

                <div class="mb-5 border-b border-dark-700 pb-4">
                    <form action="{{ route('checkout.coupon.apply') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="coupon_code" value="{{ old('coupon_code', $appliedCoupon['code'] ?? '') }}" placeholder="Coupon code" class="w-full bg-dark-900 border border-dark-700 text-white px-3 py-2 text-sm uppercase tracking-wider">
                        <button type="submit" class="px-4 py-2 border border-brand-500 text-brand-500 text-xs font-heading uppercase tracking-widest hover:bg-brand-500 hover:text-white transition">Apply</button>
                    </form>

                    @if($appliedCoupon)
                        <div class="mt-3 flex items-center justify-between text-xs text-green-400 uppercase tracking-wider">
                            <span>{{ $appliedCoupon['code'] }} applied</span>
                            <form action="{{ route('checkout.coupon.remove') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Remove</button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="space-y-2 text-sm border-b border-dark-700 pb-4 mb-4">
                    <div class="flex justify-between text-gray-300">
                        <span>Subtotal</span>
                        <span>Rs {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-300">
                        <span>Discount</span>
                        <span>- Rs {{ number_format($discount, 2) }}</span>
                    </div>
                </div>

                <div class="flex justify-between items-center text-lg font-heading uppercase tracking-wide mb-6">
                    <span class="text-gray-300">Total</span>
                    <span class="text-brand-500">Rs {{ number_format($grandTotal, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn-brand w-full py-3 text-center block">Proceed to Checkout</a>
                <a href="{{ route('products.index') }}" class="w-full mt-3 py-3 border border-dark-600 text-gray-300 hover:border-brand-500 hover:text-brand-500 transition text-center block uppercase tracking-widest text-sm">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>
@endsection
