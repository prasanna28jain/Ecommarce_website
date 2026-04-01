@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-10 border-b border-dark-800">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="text-sm font-heading tracking-widest uppercase text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-brand-500 transition-colors">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-brand-500 transition-colors">Equipment</a>
            @if($product->category)
                <span class="mx-2">/</span>
                <a href="{{ route('category.show', $product->category->id) }}" class="hover:text-brand-500 transition-colors">{{ $product->category->name }}</a>
            @endif
            <span class="mx-2">/</span>
            <span class="text-white">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="bg-dark-900 py-16">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Product Images Gallery -->
            <div class="w-full lg:w-1/2">
                <div class="bg-white p-6 relative h-[500px] flex items-center justify-center mb-4 border border-dark-800">
                    @if($product->images->count() > 0)
                        <img id="main-product-image" src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain mix-blend-multiply">
                    @else
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <i class="bi bi-image text-5xl mb-3"></i>
                            <span class="uppercase font-heading tracking-widest text-sm">No Image Available</span>
                        </div>
                    @endif
                    
                    @if($product->sale_price)
                        <div class="absolute top-4 left-4 bg-brand-500 text-white font-heading font-bold px-3 py-1 uppercase text-sm tracking-widest">Sale</div>
                    @endif
                </div>
                
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                            <div class="bg-white p-2 h-24 border border-dark-700 cursor-pointer hover:border-brand-500 transition-colors" onclick="document.getElementById('main-product-image').src='{{ Storage::url($image->image_path) }}'">
                                <img src="{{ Storage::url($image->image_path) }}" class="w-full h-full object-contain mix-blend-multiply" alt="Thumbnail">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="w-full lg:w-1/2">
                @if($product->brand)
                    <div class="text-gray-400 uppercase font-heading tracking-widest text-sm mb-2">
                        Brand: <a href="{{ route('brand.show', $product->brand->id) }}" class="text-white hover:text-brand-500 transition-colors">{{ $product->brand->name }}</a>
                    </div>
                @endif
                <h1 class="font-heading text-4xl md:text-5xl font-bold uppercase tracking-wide text-white mb-4 leading-tight">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex text-brand-500 text-lg">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                    </div>
                    <a href="#reviews" class="text-gray-400 hover:text-white transition-colors text-sm font-heading tracking-widest uppercase">(3 Customer Reviews)</a>
                </div>

                @php
                    $activeVariations = $product->variations->where('is_active', true)->values();
                    $isVariableProduct = $activeVariations->isNotEmpty();
                    $simplePrice = (float) ($product->sale_price ?? $product->base_price ?? 0);
                    $firstVariationPrice = $isVariableProduct ? (float) ($activeVariations->first()->price ?? 0) : null;
                @endphp

                <div class="text-3xl font-heading font-bold flex items-center gap-4 mb-8">
                    <span id="product-price" class="text-brand-500">
                        @if($isVariableProduct)
                            ${{ number_format($firstVariationPrice, 2) }}
                        @elseif($product->sale_price)
                            ${{ number_format($product->sale_price, 2) }}
                        @else
                            ${{ number_format($product->base_price, 2) }}
                        @endif
                    </span>
                    @if(!$isVariableProduct && $product->sale_price)
                        <span class="text-gray-600 line-through text-xl">${{ number_format($product->base_price, 2) }}</span>
                    @endif
                </div>

                <div class="text-gray-300 mb-8 leading-relaxed max-w-xl">
                    {{ $product->short_description ?? 'High-performance gym equipment designed for intensive use. Built with durable materials to withstand the toughest workouts.' }}
                </div>

                <div class="bg-dark-800 p-6 border border-dark-700 mb-8">
                    @if(session('success'))
                        <div class="bg-green-600 text-white p-3 mb-4 text-sm font-bold uppercase tracking-widest">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-600 text-white p-3 mb-4 text-sm font-bold uppercase tracking-widest">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col gap-4" id="product-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        @if($isVariableProduct)
                            <div>
                                <label class="text-xs uppercase tracking-widest text-gray-400 block mb-2">Select Variation</label>
                                <select name="product_variation_id" id="product_variation_id" class="w-full bg-dark-900 border border-dark-700 text-white px-3 py-3" required>
                                    @foreach($activeVariations as $variation)
                                        @php
                                            $attrs = collect($variation->attributes ?? [])->map(fn ($val, $key) => ucfirst($key) . ': ' . $val)->implode(' | ');
                                        @endphp
                                        <option value="{{ $variation->id }}" data-price="{{ (float) $variation->price }}">
                                            {{ $attrs !== '' ? $attrs : ('Variation #' . $variation->id) }} - ${{ number_format((float) $variation->price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="flex flex-col sm:flex-row gap-4">
                        <!-- Quantity -->
                        <div class="flex border border-dark-700 w-32 bg-dark-900">
                            <button type="button" class="w-10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-dark-700 transition" onclick="document.getElementById('qty').stepDown()"><i class="bi bi-dash"></i></button>
                            <input type="number" id="qty" name="quantity" value="1" min="1" class="w-12 text-center bg-transparent border-none text-white focus:outline-none focus:ring-0 font-bold p-0">
                            <button type="button" class="w-10 flex items-center justify-center text-gray-400 hover:text-white hover:bg-dark-700 transition" onclick="document.getElementById('qty').stepUp()"><i class="bi bi-plus"></i></button>
                        </div>
                        
                        <!-- Add to Cart -->
                        <button type="submit" class="btn-brand flex-grow py-3 px-6 text-lg tracking-widest flex items-center justify-center gap-2">
                            Add to Cart <i class="bi bi-bag-plus"></i>
                        </button>
                        </div>
                    </form>

                    @auth
                        <form action="{{ route('wishlist.toggle') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @if($isVariableProduct)
                                <input type="hidden" name="product_variation_id" id="wishlist_variation_id" value="{{ $activeVariations->first()->id }}">
                            @endif
                            <button type="submit" class="w-full border border-dark-600 text-gray-300 hover:border-brand-500 hover:text-brand-500 transition py-3 uppercase tracking-widest text-sm flex items-center justify-center gap-2">
                                Wishlist <i class="bi bi-heart"></i>
                            </button>
                        </form>
                    @endauth

                    @if($isVariableProduct)
                        <div class="mt-4 border-t border-dark-700 pt-4">
                            <div class="text-xs uppercase tracking-widest text-gray-400 mb-2">Available Variations</div>
                            <div class="space-y-2 text-sm text-gray-300">
                                @foreach($activeVariations as $variation)
                                    @php
                                        $attrs = collect($variation->attributes ?? [])->map(fn ($val, $key) => ucfirst($key) . ': ' . $val)->implode(' | ');
                                    @endphp
                                    <div class="flex justify-between gap-3 border border-dark-700 bg-dark-900 px-3 py-2">
                                        <span>{{ $attrs !== '' ? $attrs : ('Variation #' . $variation->id) }}</span>
                                        <span class="text-brand-500 font-heading">${{ number_format((float) $variation->price, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col gap-3 font-heading uppercase text-sm tracking-widest text-gray-400">
                    <div class="flex"><span class="w-32 text-gray-500">SKU:</span> <span class="text-white">{{ $product->sku }}</span></div>
                    <div class="flex"><span class="w-32 text-gray-500">Categories:</span> <span class="text-white">
                        @if($product->category)
                            <a href="{{ route('category.show', $product->category->id) }}" class="hover:text-brand-500">{{ $product->category->name }}</a>
                        @endif
                    </span></div>
                    <div class="flex items-center gap-4 mt-4">
                        <span class="text-gray-500 w-32">Share:</span>
                        <a href="#" class="text-white hover:text-brand-500 transition-colors text-lg"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white hover:text-brand-500 transition-colors text-lg"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white hover:text-brand-500 transition-colors text-lg"><i class="bi bi-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description Tabs -->
        <div class="mt-20">
            <div class="flex border-b border-dark-700 gap-8 mb-8 font-heading uppercase tracking-widest font-bold">
                <button class="text-brand-500 pb-4 border-b-2 border-brand-500">Description</button>
                <button class="text-gray-500 hover:text-white transition-colors pb-4">Additional Information</button>
                <button class="text-gray-500 hover:text-white transition-colors pb-4">Reviews (0)</button>
            </div>
            
            <div class="text-gray-300 leading-relaxed max-w-4xl">
                {!! $product->description ?? 'No detailed description available for this product.' !!}
            </div>
        </div>
    </div>
</div>
@endsection

@if($isVariableProduct)
    @push('scripts')
        <script>
            (function () {
                const variationSelect = document.getElementById('product_variation_id');
                const wishlistVariationInput = document.getElementById('wishlist_variation_id');
                const priceNode = document.getElementById('product-price');

                if (!variationSelect) {
                    return;
                }

                const updateSelectedVariation = () => {
                    const selectedOption = variationSelect.options[variationSelect.selectedIndex];
                    const price = Number(selectedOption?.dataset?.price || 0);

                    if (priceNode) {
                        priceNode.textContent = '$' + price.toFixed(2);
                    }

                    if (wishlistVariationInput) {
                        wishlistVariationInput.value = variationSelect.value;
                    }
                };

                variationSelect.addEventListener('change', updateSelectedVariation);
                updateSelectedVariation();
            })();
        </script>
    @endpush
@endif
