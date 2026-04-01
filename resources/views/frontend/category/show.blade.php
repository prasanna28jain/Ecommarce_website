@extends('layouts.frontend')

@section('content')
<!-- Category Banner -->
<section class="relative bg-dark-800 flex items-center justify-center py-24 border-b border-brand-500 overflow-hidden">
    @if($category->image_path)
        <div class="absolute inset-0 z-0 opacity-20">
            <img src="{{ Storage::url($category->image_path) }}" class="w-full h-full object-cover" alt="Banner">
        </div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-dark-900 to-transparent z-0"></div>
    
    <div class="relative z-10 text-center px-4">
        <div class="text-brand-500 font-heading font-bold tracking-[0.2em] uppercase text-sm mb-4 block">Category</div>
        <h1 class="text-5xl md:text-7xl font-heading font-bold text-white uppercase leading-tight mb-6 tracking-wider">
            {{ $category->name }}
        </h1>
        <div class="text-gray-300 max-w-2xl mx-auto">
            {!! $category->description ?? 'Browse all equipment under ' . $category->name !!}
        </div>
    </div>
</section>

<!-- Category Products Grid -->
<div class="bg-dark-900 py-16 min-h-[50vh]">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8 pb-4 border-b border-dark-800">
            <div class="text-gray-400 font-heading uppercase tracking-widest text-sm">Showing {{ $category->products->count() }} results</div>
            <div>
                <a href="{{ route('categories.index') }}" class="text-brand-500 hover:text-white transition-colors uppercase font-heading text-sm tracking-widest font-bold">
                    <i class="bi bi-arrow-left"></i> All Categories
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($category->products as $product)
                <div class="product-card bg-dark-800 relative group">
                    <a href="{{ route('product.show', $product->slug) }}" class="block relative h-64 overflow-hidden bg-white p-4">
                        @if($product->images->count() > 0)
                            <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-100 mix-blend-multiply">
                                <i class="bi bi-image text-3xl mb-2"></i>
                                <span class="text-sm">No Image</span>
                            </div>
                        @endif
                        
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-20 translate-y-4 group-hover:translate-y-0 duration-300">
                            <button type="button" onclick="event.preventDefault(); event.stopPropagation(); document.getElementById('quick-cart-{{ $product->id }}').submit()" class="w-10 h-10 bg-black text-white hover:bg-brand-500 flex items-center justify-center rounded-full" title="Add to Cart"><i class="bi bi-cart-plus"></i></button>
                        </div>
                    </a>
                    <form id="quick-cart-{{ $product->id }}" action="{{ route('cart.add') }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                    </form>
                    
                    <div class="p-5 text-center border-t border-dark-700">
                        <a href="{{ route('product.show', $product->slug) }}" class="block font-heading font-medium text-lg text-white hover:text-brand-500 transition-colors uppercase truncate tracking-wide mb-2">
                            {{ $product->name }}
                        </a>
                        <div class="flex justify-center items-center gap-3 font-heading text-lg">
                            @if($product->sale_price)
                                <span class="text-brand-500 font-bold">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="text-gray-500 line-through text-sm">${{ number_format($product->base_price, 2) }}</span>
                            @else
                                <span class="text-white font-bold">${{ number_format($product->base_price, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-4 text-center py-20 bg-dark-800">
                    <i class="bi bi-box-seam text-5xl text-dark-600 block mb-4"></i>
                    <h3 class="text-xl font-heading text-white uppercase tracking-widest">No products found</h3>
                    <p class="text-gray-400 mt-2">There are currently no products available in this category.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
