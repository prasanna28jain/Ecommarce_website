@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-16">
    <div class="container mx-auto px-4">
        <!-- Page Title -->
        <div class="text-center mb-16">
            <h1 class="font-heading text-5xl font-bold uppercase tracking-widest text-white mb-4">All <span class="text-brand-500">Equipment</span></h1>
            <div class="w-16 h-1 bg-brand-500 mx-auto"></div>
            <p class="text-gray-400 mt-6 max-w-2xl mx-auto">Browse our complete collection of professional gym equipment. Built to last and designed to maximize your strength training and cardio routines.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters (Visual only for now, can be wired later) -->
            <div class="w-full lg:w-1/4">
                <div class="bg-dark-800 p-6 sticky top-24">
                    <h3 class="font-heading text-xl font-bold text-white uppercase tracking-wider mb-6 pb-4 border-b border-dark-700">Filter By</h3>
                    
                    <div class="mb-8">
                        <h4 class="font-heading font-medium text-gray-300 uppercase tracking-wider mb-4">Categories</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('categories.index') }}" class="text-gray-400 hover:text-brand-500 transition-colors flex justify-between"><span>All Categories</span></a></li>
                            <!-- Dynamic categories would go here -->
                        </ul>
                    </div>

                    <div class="mb-8">
                        <h4 class="font-heading font-medium text-gray-300 uppercase tracking-wider mb-4">Price Range</h4>
                        <input type="range" min="0" max="5000" class="w-full accent-brand-500">
                        <div class="flex justify-between text-gray-400 text-sm mt-2">
                            <span>$0</span>
                            <span>$5000+</span>
                        </div>
                    </div>
                    
                    <button class="w-full p-3 font-heading uppercase text-sm font-bold tracking-widest border border-brand-500 text-brand-500 hover:bg-brand-500 hover:text-white transition-all">
                        Apply Filters
                    </button>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="w-full lg:w-3/4">
                <div class="flex justify-between items-center mb-6 pb-4 border-b border-dark-800">
                    <div class="text-gray-400">Showing all {{ $products->total() }} results</div>
                    <div>
                        <select class="bg-dark-800 border border-dark-700 text-gray-300 py-2 px-4 focus:outline-none focus:border-brand-500">
                            <option>Default Sorting</option>
                            <option>Sort by Popularity</option>
                            <option>Sort by Newness</option>
                            <option>Sort by Price: Low to High</option>
                            <option>Sort by Price: High to Low</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($products as $product)
                        <div class="product-card bg-dark-800 relative group">
                            @if($product->is_featured)
                                <span class="badge-hot z-20" style="background-color: #f59e0b;">HOT</span>
                            @endif
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
                            
                            <div class="p-5 text-center">
                                @if($product->category)
                                    <div class="text-brand-500 text-xs font-heading tracking-widest uppercase mb-2">{{ $product->category->name }}</div>
                                @endif
                                <a href="{{ route('product.show', $product->slug) }}" class="block font-heading font-medium text-lg text-white hover:text-brand-500 transition-colors uppercase truncate tracking-wide mb-2" title="{{ $product->name }}">
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
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 bg-dark-800">
                            <i class="bi bi-emoji-frown text-5xl text-dark-600 block mb-4"></i>
                            <h3 class="text-xl font-heading text-white uppercase tracking-widest">No products found</h3>
                            <p class="text-gray-400 mt-2">Check back later or browse other categories.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-12 flex justify-center">
                        <div class="bg-dark-800 inline-flex p-2 gap-2">
                            <!-- Tailwind pagination overrides for black/red theme can be styled here. For now, Laravel's default might be messy in tailwind if not configured. Providing a simple custom link array or letting default render. -->
                            {{ $products->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
