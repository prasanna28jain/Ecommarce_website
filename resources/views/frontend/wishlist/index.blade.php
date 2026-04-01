@extends('layouts.frontend')

@section('title', 'My Wishlist | Boxima Fitness')

@section('content')

{{-- Page Header --}}
<div class="page-header-teal">
    <div class="container">
        <h1 class="page-header-title">My Wishlist</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb-xrt">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Wishlist</li>
            </ol>
        </nav>
    </div>
</div>

<section style="background:#f5f5f5; padding: 50px 0; min-height: 55vh;">
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success py-2 mb-4" style="font-size:0.875rem; border-radius:8px;">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($items->isEmpty())
            <div style="background:#fff; border-radius:12px; padding:70px 40px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.06);">
                <div style="width:80px; height:80px; border-radius:50%; background:rgba(1,112,117,0.08); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                    <i class="bi bi-heart" style="font-size:2.5rem; color:#017075;"></i>
                </div>
                <h2 style="font-size:1.4rem; font-weight:800; color:#0D0D0D; margin-bottom:8px;">Your wishlist is empty</h2>
                <p style="color:#6C757D; font-size:0.95rem; margin-bottom:28px;">Save products you love and find them here later.</p>
                <a href="{{ route('products.index') }}" class="btn-xrt btn-teal-xrt">
                    <i class="bi bi-grid me-2"></i> Browse Products
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($items as $item)
                    <div class="col-sm-6 col-lg-3">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                <a href="{{ route('product.show', $item->product->slug) }}">
                                    @if($item->product->images->count() > 0)
                                        <img src="{{ Storage::url($item->product->images->first()->image_path) }}"
                                             alt="{{ $item->product->name }}" class="product-img">
                                    @else
                                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#aaa; font-size:0.85rem;">No Image</div>
                                    @endif
                                </a>
                                <div class="product-actions-overlay">
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                        @if($item->variation)
                                            <input type="hidden" name="product_variation_id" value="{{ $item->variation->id }}">
                                        @endif
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn-cart-xrt" title="Add to Cart">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('wishlist.toggle') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                        @if($item->variation)
                                            <input type="hidden" name="product_variation_id" value="{{ $item->variation->id }}">
                                        @endif
                                        <button type="submit" class="btn-cart-xrt" title="Remove from Wishlist"
                                                style="background:rgba(220,53,69,0.85);">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('product.show', $item->product->slug) }}" class="btn-cart-xrt" title="View Product">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-brand">{{ optional($item->product->brand)->name ?? 'Boxima' }}</div>
                                <a href="{{ route('product.show', $item->product->slug) }}" class="product-name">{{ $item->product->name }}</a>
                                @if($item->variation)
                                    @php
                                        $attrs = collect($item->variation->attributes ?? [])->map(fn($v,$k) => ucfirst($k).': '.$v)->implode(' | ');
                                    @endphp
                                    <div style="font-size:0.78rem; color:#6C757D; margin-bottom:4px;">{{ $attrs ?: ('Variation #'.$item->variation->id) }}</div>
                                @endif
                                <div class="product-price">
                                    @if($item->product->sale_price)
                                        <span class="price-sale">Rs {{ number_format($item->product->sale_price, 2) }}</span>
                                        <span class="price-original">Rs {{ number_format($item->product->base_price, 2) }}</span>
                                    @else
                                        <span class="price-sale">Rs {{ number_format($item->product->base_price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">{{ $items->links() }}</div>
        @endif

    </div>
</section>

@endsection
