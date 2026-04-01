@extends('layouts.frontend')

@section('title', 'Shop by Category | Boxima Fitness')

@section('content')

    {{-- PAGE HEADER --}}
    <section style="background:linear-gradient(135deg,#013a3c 0%,#017075 60%,#02AAB1 100%); padding:48px 0 40px;">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0" style="background:none; padding:0;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.7); text-decoration:none;">Home</a>
                    </li>
                    <li class="breadcrumb-item active" style="color:#fff;">Categories</li>
                </ol>
            </nav>
            <h1 style="color:#fff; font-size:2.2rem; font-weight:800; margin:0 0 6px;">
                Shop by <span style="color:#00e5ff;">Category</span>
            </h1>
            <p style="color:rgba(255,255,255,0.75); margin:0; font-size:0.95rem;">
                {{ $categories->count() }} {{ Str::plural('category', $categories->count()) }} available
            </p>
        </div>
    </section>

    {{-- CATEGORIES GRID --}}
    <section style="background:#f8f9fa; padding:50px 0 70px;">
        <div class="container">

            @if($categories->isEmpty())
                <div style="background:#fff; border-radius:16px; padding:80px 40px; text-align:center; border:1px solid #e9ecef;">
                    <i class="bi bi-grid" style="font-size:4rem; color:#ccc;"></i>
                    <h4 class="mt-3" style="color:#6C757D;">No categories yet</h4>
                    <p style="color:#aaa; margin:0;">Check back soon.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($categories as $category)
                        <div class="col-sm-6 col-lg-4">
                            <a href="{{ route('category.show', $category->slug) }}" class="cat-card">

                                {{-- Background image / gradient --}}
                                <div class="cat-card-bg">
                                    @if($category->image_path)
                                        <img src="{{ Storage::url($category->image_path) }}"
                                             alt="{{ $category->name }}" class="cat-card-img">
                                    @else
                                        <div class="cat-card-gradient"></div>
                                    @endif
                                    <div class="cat-card-overlay"></div>
                                </div>

                                {{-- Content --}}
                                <div class="cat-card-content">
                                    <h3 class="cat-card-name">{{ $category->name }}</h3>
                                    <div class="cat-card-line"></div>
                                    @if($category->description)
                                        <p class="cat-card-desc">{{ Str::limit($category->description, 60) }}</p>
                                    @endif
                                    <span class="cat-card-count">
                                        <i class="bi bi-box-seam me-1"></i>
                                        {{ $category->products_count ?? 0 }} Products
                                    </span>
                                </div>

                                {{-- Arrow --}}
                                <div class="cat-card-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>

                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

@endsection

@push('styles')
<style>
    .cat-card {
        display: block;
        position: relative;
        height: 260px;
        border-radius: 14px;
        overflow: hidden;
        text-decoration: none;
        background: #1a1a1a;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .cat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 48px rgba(1,112,117,0.25);
    }

    /* Background */
    .cat-card-bg { position: absolute; inset: 0; }
    .cat-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .cat-card:hover .cat-card-img { transform: scale(1.08); }
    .cat-card-gradient {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #022C2B 0%, #017075 60%, #02AAB1 100%);
    }
    .cat-card-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.52);
        transition: background 0.3s;
    }
    .cat-card:hover .cat-card-overlay { background: rgba(0,0,0,0.3); }

    /* Content */
    .cat-card-content {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 28px 24px;
        text-align: center;
    }
    .cat-card-name {
        color: #fff;
        font-size: 1.35rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0 0 10px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.4);
    }
    .cat-card-line {
        height: 2px;
        width: 36px;
        background: #00e5ff;
        margin-bottom: 10px;
        transition: width 0.3s;
    }
    .cat-card:hover .cat-card-line { width: 72px; }
    .cat-card-desc {
        color: rgba(255,255,255,0.75);
        font-size: 0.8rem;
        line-height: 1.5;
        margin: 0 0 10px;
    }
    .cat-card-count {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.25);
        background: rgba(0,0,0,0.35);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: all 0.3s;
    }
    .cat-card:hover .cat-card-count {
        background: #017075;
        border-color: #017075;
    }

    /* Arrow badge */
    .cat-card-arrow {
        position: absolute;
        bottom: 16px;
        right: 16px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    .cat-card:hover .cat-card-arrow {
        background: #017075;
        border-color: #017075;
        transform: translateX(3px);
    }
</style>
@endpush
