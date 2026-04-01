@extends('layouts.frontend')

@section('title', 'Shopping Cart | XRT65 Fitness')

@section('content')

{{-- PAGE HEADER --}}
<div class="hero-dark-wrapper" style="padding-bottom: 0;">
    <section class="page-header page-header-teal" style="padding-bottom:30px;">
        <div class="container position-relative" style="z-index:2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-xrt">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Shop</a></li>
                    <li class="breadcrumb-item active">Shopping Cart</li>
                </ol>
            </nav>
            <h1 class="text-white fw-bold" style="font-size:2.5rem;">
                Shopping <span style="color:#00e5ff;">Cart</span>
            </h1>
        </div>
    </section>
</div>

{{-- CART CONTENT --}}
<section class="py-5" id="cartPageWrap">
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($cartItems->isEmpty())
            {{-- Empty Cart --}}
            <div class="text-center py-5">
                <i class="bi bi-bag-x" style="font-size:5rem; color:#ccc;"></i>
                <h3 class="mt-4 fw-bold">Your Cart is Empty</h3>
                <p class="text-muted mb-4">Looks like you haven't added any equipment yet. Start building your home gym!</p>
                <a href="{{ route('products.index') }}" class="btn-xrt btn-teal-xrt">
                    <i class="bi bi-bag-plus"></i> Start Shopping
                </a>
            </div>
        @else
            <div class="row g-5">

                {{-- Cart Items --}}
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Cart Items ({{ $cartItems->count() }})</h5>
                        <a href="{{ route('products.index') }}" class="text-decoration-none" style="color:var(--primary); font-weight:600;">
                            <i class="bi bi-arrow-left me-1"></i> Continue Shopping
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr>
                                        {{-- Product Image --}}
                                        <td>
                                            <a href="{{ route('product.show', $item->product->slug) }}">
                                                @if($item->product->images->count() > 0)
                                                    <img src="{{ Storage::url($item->product->images->first()->image_path) }}"
                                                         alt="{{ $item->product->name }}" class="cart-item-img">
                                                @else
                                                    <img src="{{ asset('frontend/images/dumbbell.png') }}"
                                                         alt="{{ $item->product->name }}" class="cart-item-img" style="opacity:0.5;">
                                                @endif
                                            </a>
                                        </td>

                                        {{-- Name + Variant --}}
                                        <td>
                                            <a href="{{ route('product.show', $item->product->slug) }}" class="cart-item-name d-block text-dark text-decoration-none">
                                                {{ $item->product->name }}
                                            </a>
                                            @if($item->variation)
                                                @php $attrs = collect($item->variation->attributes ?? [])->map(fn($val, $key) => ucfirst($key) . ': ' . $val)->implode(' | '); @endphp
                                                <div class="cart-item-variant">{{ $attrs ?: ('Variation #' . $item->variation->id) }}</div>
                                            @endif
                                        </td>

                                        {{-- Price --}}
                                        <td>₹{{ number_format($item->price, 0) }}</td>

                                        {{-- Quantity --}}
                                        <td>
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <div class="qty-control" style="width:auto;">
                                                    <button type="button" onclick="this.nextElementSibling.stepDown(); this.closest('form').submit()">−</button>
                                                    <input type="number" name="quantity" min="1" max="99" value="{{ $item->quantity }}"
                                                           style="width:50px;" onchange="this.form.submit()">
                                                    <button type="button" onclick="this.previousElementSibling.stepUp(); this.closest('form').submit()">+</button>
                                                </div>
                                            </form>
                                        </td>

                                        {{-- Line Total --}}
                                        <td class="fw-bold">₹{{ number_format($item->quantity * $item->price, 0) }}</td>

                                        {{-- Remove --}}
                                        <td>
                                            <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="cart-remove-btn" title="Remove">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="col-lg-4">
                    <div class="cart-summary" style="position: sticky; top: 100px;">
                        <h5>Order Summary</h5>

                        {{-- Coupon --}}
                        <form action="{{ route('checkout.coupon.apply') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="d-flex gap-2">
                                <input type="text" name="coupon_code"
                                       value="{{ old('coupon_code', $appliedCoupon['code'] ?? '') }}"
                                       placeholder="Coupon code"
                                       class="form-control form-control-sm"
                                       style="text-transform:uppercase;">
                                <button type="submit" class="btn btn-sm btn-outline-secondary" style="white-space:nowrap;">Apply</button>
                            </div>
                            @if($appliedCoupon)
                                <div class="mt-2 d-flex align-items-center justify-content-between">
                                    <small class="text-success fw-bold"><i class="bi bi-check-circle me-1"></i>{{ $appliedCoupon['code'] }} applied</small>
                                    <form action="{{ route('checkout.coupon.remove') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-sm text-danger p-0">Remove</button>
                                    </form>
                                </div>
                            @endif
                        </form>

                        <div class="cart-summary-row">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($subtotal, 0) }}</span>
                        </div>
                        @if($discount > 0)
                            <div class="cart-summary-row" style="color:var(--success);">
                                <span>Savings</span>
                                <span>− ₹{{ number_format($discount, 0) }}</span>
                            </div>
                        @endif
                        <div class="cart-summary-row">
                            <span>Shipping</span>
                            <span>{{ $subtotal >= 5000 ? 'FREE' : '₹' . number_format(199, 0) }}</span>
                        </div>
                        <div class="cart-summary-row total">
                            <span>Total</span>
                            <span>₹{{ number_format($grandTotal, 0) }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn-xrt btn-teal-xrt w-100 mt-4 justify-content-center" style="border-radius:8px;">
                            <i class="bi bi-lock me-2"></i> Proceed to Checkout
                        </a>

                        <div class="text-center mt-3">
                            <small class="text-muted"><i class="bi bi-shield-lock me-1"></i> Secure SSL Encrypted Checkout</small>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-around text-center">
                            <div>
                                <i class="bi bi-truck d-block fs-5 text-primary mb-1"></i>
                                <small class="text-muted" style="font-size:0.75rem;">Free Shipping<br>Above ₹5,000</small>
                            </div>
                            <div>
                                <i class="bi bi-arrow-counterclockwise d-block fs-5 text-warning mb-1"></i>
                                <small class="text-muted" style="font-size:0.75rem;">30-Day<br>Returns</small>
                            </div>
                            <div>
                                <i class="bi bi-shield-check d-block fs-5 text-success mb-1"></i>
                                <small class="text-muted" style="font-size:0.75rem;">Genuine<br>Products</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
</section>

@endsection
