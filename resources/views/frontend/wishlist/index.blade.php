@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-10 border-b border-dark-800">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-heading font-bold uppercase tracking-wide text-white">My Wishlist</h1>
        <p class="text-gray-400 mt-2">Your saved products for later.</p>
    </div>
</div>

<div class="bg-dark-900 py-12 min-h-[50vh]">
    <div class="container mx-auto px-4">
        @if(session('success'))
            <div class="bg-green-700/60 border border-green-500 text-white px-4 py-3 mb-6 text-sm uppercase tracking-wider">{{ session('success') }}</div>
        @endif

        @if($items->isEmpty())
            <div class="bg-dark-800 border border-dark-700 p-10 text-center">
                <h2 class="text-white font-heading text-xl uppercase tracking-widest">Wishlist is empty</h2>
                <p class="text-gray-400 mt-2">Save products you like and find them quickly here.</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-6 px-6 py-3 border border-brand-500 text-brand-500 hover:bg-brand-500 hover:text-white transition uppercase text-xs tracking-widest">Browse Products</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($items as $item)
                    <div class="bg-dark-800 border border-dark-700 p-4">
                        <a href="{{ route('product.show', $item->product->slug) }}" class="block h-56 bg-white p-4 mb-4">
                            @if($item->product->images->count() > 0)
                                <img src="{{ Storage::url($item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain mix-blend-multiply">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                        </a>

                        <a href="{{ route('product.show', $item->product->slug) }}" class="block text-white font-heading uppercase tracking-wide hover:text-brand-500 transition truncate" title="{{ $item->product->name }}">{{ $item->product->name }}</a>

                        @if($item->variation)
                            @php
                                $attrs = collect($item->variation->attributes ?? [])->map(fn ($val, $key) => ucfirst($key) . ': ' . $val)->implode(' | ');
                            @endphp
                            <div class="mt-1 text-xs uppercase tracking-wider text-gray-400">
                                {{ $attrs !== '' ? $attrs : ('Variation #' . $item->variation->id) }}
                            </div>
                        @endif

                        <div class="text-brand-500 font-heading mt-2">${{ number_format($item->product->sale_price ?? $item->product->base_price, 2) }}</div>

                        <div class="mt-4 flex gap-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                @if($item->variation)
                                    <input type="hidden" name="product_variation_id" value="{{ $item->variation->id }}">
                                @endif
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full px-3 py-2 border border-brand-500 text-brand-500 hover:bg-brand-500 hover:text-white transition text-xs uppercase tracking-wider">Add to Cart</button>
                            </form>
                            <form action="{{ route('wishlist.toggle') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                @if($item->variation)
                                    <input type="hidden" name="product_variation_id" value="{{ $item->variation->id }}">
                                @endif
                                <button type="submit" class="px-3 py-2 border border-red-500 text-red-400 hover:bg-red-500 hover:text-white transition text-xs uppercase tracking-wider">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
