@extends('layouts.frontend')

@section('content')
    <!-- Hero Section -->
    @php
        $heroSlides = ($sliders ?? collect())->values();
    @endphp
    <section class="relative overflow-hidden" style="min-height: 85vh;">
        @if($heroSlides->isNotEmpty())
            @foreach($heroSlides as $index => $slide)
                <div class="home-hero-slide absolute inset-0 {{ $index === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' }} transition-opacity duration-700"
                     data-slide-index="{{ $index }}"
                     style="background-image: linear-gradient(rgba(15, 15, 15, 0.7), rgba(15, 15, 15, 0.9)), url('{{ $slide->image_path ? asset('storage/' . $slide->image_path) : '' }}'); background-size: cover; background-position: center;">
                    <div class="container mx-auto px-4 py-20 h-full flex items-center">
                        <div class="max-w-2xl">
                            <span class="text-brand-500 font-heading font-bold tracking-[0.2em] uppercase text-sm mb-4 block">Featured</span>
                            <h1 class="text-5xl md:text-7xl font-heading font-bold text-white uppercase leading-tight mb-6">{{ $slide->title }}</h1>
                            @if($slide->subheading)
                                <p class="text-gray-300 text-lg mb-8 max-w-lg">{{ $slide->subheading }}</p>
                            @endif
                            @if($slide->button_text && $slide->button_link)
                                <a href="{{ $slide->button_link }}" class="btn-brand px-8 py-4 text-sm tracking-widest inline-flex items-center gap-2">
                                    {{ $slide->button_text }} <i class="bi bi-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @if($heroSlides->count() > 1)
                <div class="absolute bottom-8 left-0 right-0 z-20">
                    <div class="container mx-auto px-4 flex items-center gap-2">
                        @foreach($heroSlides as $index => $slide)
                            <button type="button" class="home-hero-dot w-3 h-3 rounded-full {{ $index === 0 ? 'bg-brand-500' : 'bg-white/40' }}" data-dot-index="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <div class="hero-banner h-full flex items-center" style="min-height: 85vh;">
                <div class="container mx-auto px-4 py-20">
                    <div class="max-w-2xl">
                        <span class="text-brand-500 font-heading font-bold tracking-[0.2em] uppercase text-sm mb-4 block">Build Your Dream Body</span>
                        <h1 class="text-5xl md:text-7xl font-heading font-bold text-white uppercase leading-tight mb-6">
                            Heavy Duty <br> <span class="text-transparent" style="-webkit-text-stroke: 1px #E63946;">Equipment</span>
                        </h1>
                        <p class="text-gray-300 text-lg mb-8 max-w-lg">
                            Discover professional-grade gym equipment designed for uncompromised performance and maximum durability.
                        </p>
                        <div class="flex gap-4">
                            <a href="{{ route('products.index') }}" class="btn-brand px-8 py-4 text-sm tracking-widest inline-flex items-center gap-2">
                                Shop Now <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="{{ route('categories.index') }}" class="px-8 py-4 text-sm font-heading font-semibold tracking-widest uppercase border border-white text-white hover:bg-white hover:text-black transition-colors inline-block">
                                View Categories
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <!-- Services / Features Bar -->
    <section class="bg-brand-500 py-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-red-700">
                <div class="flex items-center justify-center gap-4 py-2">
                    <i class="bi bi-shield-check text-3xl"></i>
                    <div class="text-left font-heading">
                        <h4 class="font-bold text-lg uppercase tracking-wider leading-none mb-1">Lifetime Warranty</h4>
                        <span class="text-xs text-red-100 uppercase tracking-widest">On all metal frames</span>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-4 py-2">
                    <i class="bi bi-lightning-charge text-3xl"></i>
                    <div class="text-left font-heading">
                        <h4 class="font-bold text-lg uppercase tracking-wider leading-none mb-1">Fast Delivery</h4>
                        <span class="text-xs text-red-100 uppercase tracking-widest">Global shipping available</span>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-4 py-2">
                    <i class="bi bi-arrow-return-left text-3xl"></i>
                    <div class="text-left font-heading">
                        <h4 class="font-bold text-lg uppercase tracking-wider leading-none mb-1">30-Day Returns</h4>
                        <span class="text-xs text-red-100 uppercase tracking-widest">Money back guarantee</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-20 bg-dark-900">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="font-heading text-3xl font-bold uppercase tracking-wide text-white"><span class="text-brand-500">Shop</span> By Category</h2>
                    <p class="text-gray-400 mt-2">Find exactly what you need for your specific workout routine.</p>
                </div>
                <a href="{{ route('categories.index') }}" class="text-brand-500 uppercase font-heading font-semibold text-sm hover:text-white transition-colors tracking-widest">View All</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $index => $category)
                    <a href="{{ route('category.show', $category->id) }}" class="group relative h-80 overflow-hidden bg-dark-800 {{ $index === 0 ? 'md:col-span-2 lg:col-span-2' : '' }}">
                        <div class="absolute inset-0 bg-black/50 group-hover:bg-black/20 transition-all z-10"></div>
                        @if($category->image_path)
                            <img src="{{ Storage::url($category->image_path) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <!-- Dummy gradient if no image -->
                            <div class="w-full h-full bg-gradient-to-tr from-dark-800 to-dark-700"></div>
                        @endif
                        <div class="absolute bottom-6 left-6 z-20">
                            <h3 class="font-heading text-2xl font-bold uppercase tracking-wide text-white mb-1 group-hover:text-brand-500 transition-colors">{{ $category->name }}</h3>
                            <span class="text-xs text-gray-300 uppercase tracking-widest inline-flex items-center gap-1 group-hover:text-white">Shop Now <i class="bi bi-chevron-right text-[10px]"></i></span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="py-20 bg-[#141414]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="font-heading text-4xl font-bold uppercase tracking-wide text-white mb-3">New <span class="text-brand-500">Arrivals</span></h2>
                <div class="w-16 h-1 bg-brand-500 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($newProducts as $product)
                    <div class="product-card bg-dark-800 relative group">
                        @if($product->created_at->diffInDays(now()) < 30)
                            <span class="badge-hot z-20">NEW</span>
                        @endif
                        
                        <a href="{{ route('product.show', $product->slug) }}" class="block relative h-64 overflow-hidden bg-white p-4">
                            @if($product->images->count() > 0)
                                <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                            
                            <!-- Quick actions overlay -->
                            <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-20 translate-y-4 group-hover:translate-y-0 duration-300">
                                <button type="button" onclick="event.preventDefault(); event.stopPropagation(); document.getElementById('quick-cart-{{ $product->id }}').submit()" class="w-10 h-10 bg-black text-white hover:bg-brand-500 flex items-center justify-center rounded-full" title="Add to Cart"><i class="bi bi-cart-plus"></i></button>
                                @auth
                                    <button type="button" onclick="event.preventDefault(); event.stopPropagation(); document.getElementById('quick-wishlist-{{ $product->id }}').submit()" class="w-10 h-10 bg-black text-white hover:bg-brand-500 flex items-center justify-center rounded-full" title="Wishlist"><i class="bi bi-heart"></i></button>
                                @endauth
                                <a href="{{ route('product.show', $product->slug) }}" class="w-10 h-10 bg-black text-white hover:bg-brand-500 flex items-center justify-center rounded-full" title="View Product"><i class="bi bi-eye"></i></a>
                            </div>
                        </a>
                        <form id="quick-cart-{{ $product->id }}" action="{{ route('cart.add') }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                        </form>
                        @auth
                            <form id="quick-wishlist-{{ $product->id }}" action="{{ route('wishlist.toggle') }}" method="POST" class="hidden">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            </form>
                        @endauth
                        
                        <div class="p-5 text-center">
                            @if($product->category)
                                <div class="text-brand-500 text-xs font-heading tracking-widest uppercase mb-2">{{ $product->category->name }}</div>
                            @endif
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
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="inline-block border-2 border-dark-700 text-white font-heading px-8 py-3 uppercase tracking-widest hover:border-brand-500 hover:text-brand-500 transition-colors font-semibold">
                    Load More Products
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-brand-500 z-0 opacity-90"></div>
        <div class="absolute inset-0 z-0 mix-blend-overlay" style="background-image: url('https://images.unsplash.com/photo-1540497077202-7c8a3999166f?q=80&w=2940&auto=format&fit=crop'); background-size: cover; background-position: center; filter: grayscale(100%); opacity: 0.3;"></div>
        
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h2 class="text-4xl md:text-6xl font-heading font-bold uppercase text-white tracking-widest leading-tight mb-6">
                Upgrade Your <br> Home Gym Today
            </h2>
            <p class="text-white text-lg max-w-2xl mx-auto mb-8 font-medium">Get flat 20% off on all strength equipment. Offer valid till month end. Terms and conditions apply.</p>
            <a href="{{ route('products.index') }}" class="px-10 py-4 bg-black text-white font-heading tracking-widest uppercase font-bold hover:bg-white hover:text-black transition-colors text-lg inline-block">
                Claim Discount
            </a>
        </div>
    </section>

    <!-- Brands Carousel (Grid representation) -->
    <section class="py-16 bg-dark-900 border-t border-dark-800">
        <div class="container mx-auto px-4">
            <h3 class="text-center font-heading text-xl text-gray-500 uppercase tracking-widest mb-10">Trusted by Global Brands</h3>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
                @foreach($brands as $brand)
                    <a href="{{ route('brand.show', $brand->id) }}" class="block w-32 filter hover:opacity-100 transition-opacity">
                        @if($brand->logo_path)
                            <img src="{{ Storage::url($brand->logo_path) }}" alt="{{ $brand->name }}" class="max-w-full h-auto object-contain">
                        @else
                            <span class="font-heading font-bold text-2xl uppercase tracking-widest">{{ $brand->name }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@if(($sliders ?? collect())->count() > 1)
    @push('scripts')
        <script>
            (function () {
                const slides = Array.from(document.querySelectorAll('.home-hero-slide'));
                const dots = Array.from(document.querySelectorAll('.home-hero-dot'));

                if (!slides.length || slides.length < 2) {
                    return;
                }

                let activeIndex = 0;

                const setActiveSlide = (index) => {
                    activeIndex = index;

                    slides.forEach((slide, i) => {
                        const isActive = i === activeIndex;
                        slide.classList.toggle('opacity-100', isActive);
                        slide.classList.toggle('opacity-0', !isActive);
                        slide.classList.toggle('pointer-events-none', !isActive);
                    });

                    dots.forEach((dot, i) => {
                        const isActive = i === activeIndex;
                        dot.classList.toggle('bg-brand-500', isActive);
                        dot.classList.toggle('bg-white/40', !isActive);
                    });
                };

                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => setActiveSlide(index));
                });

                setInterval(() => {
                    const next = (activeIndex + 1) % slides.length;
                    setActiveSlide(next);
                }, 5000);
            })();
        </script>
    @endpush
@endif
