@extends('layouts.frontend')

@section('title', 'XRT65 Fitness | Premium Gym & Home Equipment')

@section('content')




    {{-- ===== BANNER ===== --}}
    <section class="banner">
        <svg class="banner1" xmlns="http://www.w3.org/2000/svg" width="239" height="108" viewBox="0 0 239 108"
            fill="none">
            <path d="M216 108H108L0 0H108L216 108Z" fill="url(#paint0_ban1)" fill-opacity="0.3" />
            <path d="M239 53H185.5L132 0H185.5L239 53Z" fill="url(#paint1_ban1)" fill-opacity="0.3" />
            <defs>
                <linearGradient id="paint0_ban1" x1="108" y1="0" x2="108" y2="108"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="#4F9597" />
                    <stop offset="1" stop-color="white" stop-opacity="0" />
                </linearGradient>
                <linearGradient id="paint1_ban1" x1="185.5" y1="0" x2="185.5" y2="53"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="#4F9597" />
                    <stop offset="1" stop-color="white" stop-opacity="0" />
                </linearGradient>
            </defs>
        </svg>
        <h1>KEEP GOING</h1>
        <p>ELEVATE YOUR FITNESS GAME</p>
        <svg class="banner2" xmlns="http://www.w3.org/2000/svg" width="239" height="108" viewBox="0 0 239 108"
            fill="none">
            <path d="M23 0H131L239 108H131L23 0Z" fill="url(#paint0_ban2)" fill-opacity="0.3" />
            <path d="M0 55H53.5L107 108H53.5L0 55Z" fill="url(#paint1_ban2)" fill-opacity="0.3" />
            <defs>
                <linearGradient id="paint0_ban2" x1="131" y1="108" x2="131" y2="0"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="#4F9597" />
                    <stop offset="1" stop-color="white" stop-opacity="0" />
                </linearGradient>
                <linearGradient id="paint1_ban2" x1="53.5" y1="108" x2="53.5" y2="55"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="#4F9597" />
                    <stop offset="1" stop-color="white" stop-opacity="0" />
                </linearGradient>
            </defs>
        </svg>
    </section>

    {{-- ===== EXPLORE BY CATEGORY ===== --}}
    <section class="category-grid-section" id="categoryGrid">
        <div class="container-fluid">
            <div class="pm-section-header">
                <span class="pm-section-sub">Discover Your Favorites</span>
                <h2 class="pm-section-title">EXPLORE BY CATEGORY</h2>
                <div class="pm-title-line"></div>
            </div>
            <div class="category-asymmetric-grid">
                @foreach($categories as $index => $category)
                    <a href="{{ route('category.show', $category->slug ?? $category->id) }}"
                        class="cat-grid-item {{ $index === 0 ? 'cat-grid-large' : '' }}">
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                        @else
                            {{-- Fallback to a default image if no image is uploaded in the backend --}}
                            <img src="{{ asset('frontend/images/dumbbell.png') }}" alt="{{ $category->name }}">
                        @endif
                        <span
                            class="cat-grid-label {{ $index === 0 ? 'cat-grid-label-primary' : '' }}">{{ strtoupper($category->name) }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== PRODUCT CATEGORY ===== --}}
    <section class="pm-products-section" id="productCategorySection">
        <div class="container-fluid">
            <div class="pm-section-header-row">
                <div>
                    <span class="pm-section-sub">Discover The Latest Additions</span>
                    <h2 class="pm-section-title">PRODUCT CATEGORY</h2>
                    <div class="pm-title-line"></div>
                </div>
                <div class="pm-tab-nav" id="productCategoryTabs">
                    <button class="pm-tab-btn active" data-tab="all">All Products</button>
                    @foreach($tabCategories as $tabCat)
                        <button class="pm-tab-btn" data-tab="cat-{{ $tabCat->id }}">{{ $tabCat->name }}</button>
                    @endforeach
                </div>
            </div>

            {{-- ALL PRODUCTS TAB --}}
            <div class="pm-tab-panel" data-panel="all">
                <div class="swiper product-category-swiper">
                    <div class="swiper-wrapper">
                        @foreach($featuredProducts as $product)
                            <div class="swiper-slide">
                                @include('frontend.partials.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next pm-swiper-next"></div>
                    <div class="swiper-button-prev pm-swiper-prev"></div>
                </div>
            </div>

            {{-- PER-CATEGORY TAB PANELS --}}
            @foreach($tabCategories as $tabCat)
                <div class="pm-tab-panel" data-panel="cat-{{ $tabCat->id }}" style="display:none;">
                    @if($tabCat->products->isEmpty())
                        <p style="color:#6C757D; text-align:center; padding:40px 0;">No products in this category yet.</p>
                    @else
                        <div class="swiper product-category-swiper swiper-cat-{{ $tabCat->id }}">
                            <div class="swiper-wrapper">
                                @foreach($tabCat->products as $product)
                                    <div class="swiper-slide">
                                        @include('frontend.partials.product-card', ['product' => $product])
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next pm-swiper-next"></div>
                            <div class="swiper-button-prev pm-swiper-prev"></div>
                        </div>
                    @endif
                </div>
            @endforeach

        </div>
    </section>

    {{-- ===== QUICK VIEW MODAL ===== --}}
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius:14px; overflow:hidden;">
                <div class="modal-header" style="border-bottom:1px solid #f0f0f0; padding:16px 24px;">
                    <h5 class="modal-title fw-bold" id="quickViewTitle">Quick View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="quickViewBody" style="padding:28px;">
                    <div class="text-center py-4">
                        <div class="spinner-border" style="color:#017075;" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ==== About Section  ====== -->
    <section class="about-section">
        <div class="container-fluid">

            <div class="about-wrapper">

                <!-- LEFT CONTENT -->
                <div class="about-left">
                    <p class="about-tag">ABOUT <span>XRT65</span></p>
                    <svg class="about-svg" xmlns="http://www.w3.org/2000/svg" width="71" height="36"
                        viewBox="0 0 91 36" fill="none">
                        <path
                            d="M85.5 25.2559C88.1453 25.3861 90.25 27.5724 90.25 30.25C90.25 33.0114 88.0114 35.25 85.25 35.25C82.4886 35.25 80.25 33.0114 80.25 30.25C80.25 27.5724 82.3547 25.3861 85 25.2559V0.5H0.25C0.111929 0.5 0 0.388071 0 0.25C0 0.111929 0.111929 0 0.25 0H85.5V25.2559Z"
                            fill="white" />
                    </svg>
                    <h2>
                        Engineered for Strength. Designed for You. <br>
                        Built for Your Space.
                    </h2>

                    <h3>Shaped to Fit Your Life.</h3>

                    <div class="about-image">
                        <img src="frontend/images/gymVector.png" class="img-shape" alt="Vector Background">
                        <img src="frontend/images/about1.png" alt="Gym Photo" class="main-img">
                        <svg class="about1-glow" xmlns="http://www.w3.org/2000/svg" width="522" height="522"
                            viewBox="0 0 522 522" fill="none">
                            <g filter="url(#filter0_f_about1_glow)">
                                <circle cx="260.922" cy="260.922" r="110.922" fill="#17948E" />
                            </g>
                            <defs>
                                <filter id="filter0_f_about1_glow" x="0" y="0" width="521.844" height="521.844"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                        result="shape" />
                                    <feGaussianBlur stdDeviation="75" result="effect1_foregroundBlur_6311_2685" />
                                </filter>
                            </defs>
                        </svg>
                        <img src="frontend/images/gymVector.png" class="img-shape1" alt="Vector Background">
                        <svg class="about2-glow" xmlns="http://www.w3.org/2000/svg" width="522" height="522"
                            viewBox="0 0 522 522" fill="none">
                            <g filter="url(#filter0_f_about1_glow)">
                                <circle cx="260.922" cy="260.922" r="110.922" fill="#17948E" />
                            </g>
                            <defs>
                                <filter id="filter0_f_about1_glow" x="0" y="0" width="521.844" height="521.844"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                        result="shape" />
                                    <feGaussianBlur stdDeviation="75" result="effect1_foregroundBlur_6311_2685" />
                                </filter>
                            </defs>
                        </svg>
                    </div>
                </div>

                <!-- RIGHT CONTENT -->
                <div class="about-right">

                    <!-- Small Images -->
                    <div class="about-gallery">
                        <img src="frontend/images/about2.png" alt="Workout Photo">
                        <img src="frontend/images/about3.png" alt="Workout Photo">
                        <img src="frontend/images/about4.png" alt="Workout Photo">
                        <img src="frontend/images/about5.png" alt="Workout Photo">
                        <img src="frontend/images/about6.png" alt="Workout Photo">
                    </div>

                    <p class="about-desc">
                        XRT65 brings complete fitness into your everyday space with thoughtfully designed equipment and
                        accessories. Built for
                        performance without bulk, our range helps you train efficiently and make the most of your space.
                        Whether you’re starting out or staying consistent, XRT65 keeps your fitness simple, flexible,
                        and within reach.
                    </p>

                    <!-- Stats -->
                    <div class="about-stats" id="whyChooseUs">

                        <div class="stat">
                            <img src="frontend/images/customer-service 1.png" alt="Customers" class="stat-icon">

                            <h4 class="stat-number">
                                <img src="frontend/images/starvectore1.png" class="icon-shape" alt="">
                                <svg class="stats-glow" xmlns="http://www.w3.org/2000/svg" width="522" height="522"
                                    viewBox="0 0 522 522" fill="none">
                                    <g filter="url(#filter0_f_about1_glow)">
                                        <circle cx="260.922" cy="260.922" r="110.922" fill="#17948E" />
                                    </g>
                                    <defs>
                                        <filter id="filter0_f_about1_glow" x="0" y="0" width="521.844" height="521.844"
                                            filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="75" result="effect1_foregroundBlur_6311_2685" />
                                        </filter>
                                    </defs>
                                </svg>
                                <span class="pm-trust-number" data-count="50000">0</span>
                            </h4>

                            <p>Happy Customers</p>
                        </div>

                        <div class="stat">
                            <img src="frontend/images/product 1.png" alt="Products" class="stat-icon">
                            <h4 class="stat-number">
                                <img src="frontend/images/starvectore1.png" class="icon-shape" alt="">
                                <svg class="stats-glow" xmlns="http://www.w3.org/2000/svg" width="522" height="522"
                                    viewBox="0 0 522 522" fill="none">
                                    <g filter="url(#filter0_f_about1_glow)">
                                        <circle cx="260.922" cy="260.922" r="110.922" fill="#17948E" />
                                    </g>
                                    <defs>
                                        <filter id="filter0_f_about1_glow" x="0" y="0" width="521.844" height="521.844"
                                            filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="75" result="effect1_foregroundBlur_6311_2685" />
                                        </filter>
                                    </defs>
                                </svg>
                                <span class="pm-trust-number" data-count="200">0</span>
                            </h4>
                            <p>Products Delivered</p>
                        </div>



                        <div class="stat">
                            <img src="frontend/images/king 1.png" alt="Warranty" class="stat-icon">

                            <h4 class="stat-number">
                                <img src="frontend/images/starvectore1.png" class="icon-shape" alt="">
                                <svg class="stats-glow" xmlns="http://www.w3.org/2000/svg" width="522" height="522"
                                    viewBox="0 0 522 522" fill="none">
                                    <g filter="url(#filter0_f_about1_glow)">
                                        <circle cx="260.922" cy="260.922" r="110.922" fill="#17948E" />
                                    </g>
                                    <defs>
                                        <filter id="filter0_f_about1_glow" x="0" y="0" width="521.844" height="521.844"
                                            filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="75" result="effect1_foregroundBlur_6311_2685" />
                                        </filter>
                                    </defs>
                                </svg>
                                <span class="pm-trust-number" data-count="5" data-suffix=" year">0</span>
                            </h4>

                            <p>Happy Customers</p>
                        </div>

                        <div class="stat">
                            <img src="frontend/images/costumer.png" alt="Rating" class="stat-icon">
                            <h4 class="stat-number">
                                <img src="frontend/images/starvectore1.png" class="icon-shape" alt="">
                                <svg class="stats-glow" xmlns="http://www.w3.org/2000/svg" width="522" height="522"
                                    viewBox="0 0 522 522" fill="none">
                                    <g filter="url(#filter0_f_about1_glow)">
                                        <circle cx="260.922" cy="260.922" r="110.922" fill="#17948E" />
                                    </g>
                                    <defs>
                                        <filter id="filter0_f_about1_glow" x="0" y="0" width="521.844" height="521.844"
                                            filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="75" result="effect1_foregroundBlur_6311_2685" />
                                        </filter>
                                    </defs>
                                </svg>
                                <span class="pm-trust-number" data-count="4.8" data-is-decimal="true"
                                    data-suffix=" star">0.0</span>
                            </h4>
                            <p>Average Rating</p>
                        </div>

                    </div>

                    <!-- CTA -->
                    <div class="about-cta">

                        <!-- LEFT: VIDEO THUMBNAILS -->
                        <div class="video-list">
                            <div class="video-circle" data-video="https://www.youtube.com/embed/VIDEO_ID_1">
                                <img src="frontend/images/video1.png" alt="">
                            </div>
                            <div class="video-circle" data-video="https://www.youtube.com/embed/VIDEO_ID_2">
                                <img src="frontend/images/video2.png" alt="">
                            </div>
                            <div class="video-circle" data-video="https://www.youtube.com/embed/VIDEO_ID_3">
                                <img src="frontend/images/video3.png" alt="">
                            </div>
                        </div>

                        <!-- RIGHT: CTA -->
                        <div class="watch-video" data-video="https://www.youtube.com/embed/VIDEO_ID_1">
                            <button class="play-btn">▶</button>
                            <span>WATCH VIDEO</span>
                        </div>

                    </div>

                    <!-- VIDEO MODAL -->
                    <div class="video-modal" id="videoModal">
                        <div class="video-content">
                            <span class="close-btn">&times;</span>
                            <iframe id="videoFrame" src="" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- ===== Story Section ===== -->
    <div style="border: 1px solid #F8FFFF; background: linear-gradient(180deg, #F8FFFF 0%, #FFF 100%);">
        <section class="story-section">
            <div class="container-fluid">

                <div class="story-wrapper">


                    <!-- LEFT SIDE -->
                    <div class="story-left">
                        <img src="frontend/images/fSectionvector.png" class="fimg-shape" alt="Vector Background">
                        <h1 class="story-title">Leo Singh Arora</h1>

                        <p class="story-sub">(Founder XRT65 FITNESS)</p>

                        <p class="story-tagline">
                            From Pandemic Struggles to <br>
                            Your Home Gym Solution:
                        </p>

                        <h2 class="story-heading">XRT65's Story</h2>

                        <div class="story-line"></div>

                        <div class="story-image">
                            <img src="frontend/images/founder copy.png" alt="Founder">
                        </div>

                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="story-right">
                        <p>
                            The pandemic hit us all hard. It forced us to re-evaluate our lives, our habits, and our
                            health.
                            For me, it revealed a truth I couldn’t ignore any longer: I was battling addiction.
                        </p>

                        <p>
                            But within the struggle, I found my escape. Fitness became my lifeline. It pushed back the
                            anxiety,
                            the depression, and the addiction, replacing them with a newfound strength and purpose.
                        </p>

                        <p>
                            I knew I wasn’t alone. Millions were grappling with similar challenges, even after the
                            pandemic
                            eased.
                            That’s when I realized fitness wasn’t a luxury — it was a necessity.
                        </p>

                        <p>
                            XRT65 was born to break those barriers. No more excuses, just effective workouts — right at
                            home.
                        </p>

                        <p>
                            XRT65 is more than a brand; it's a movement – Keep India Fit and Keep Going.
                        </p>
                    </div>
                    <img src="frontend/images/fSectionvector2.png" class="fimg-shape2" alt="Vector Background">


                </div>

            </div>
        </section>
    </div>


    <!-- ===== MindSet Section ======= -->
    <section class="mindset-section">

        <div class="mindset-wrapper">
            <div class="cursor-circle"></div>

            <!-- LEFT CONTENT -->
            <div class="mindset-left">
                <h2 class="title">The XRT65 Mindset</h2>

                <div class="text-wrapper">
                    <!-- DULL TEXT -->
                    <p class="text dull">
                        Strength is not just about what you can do, but about how you conquer what you cannot do.
                    </p>

                    <!-- BOLD TEXT -->
                    <p class="text highlight">
                        Strength is not just about what you can do, but about how you conquer what you cannot do.
                    </p>
                </div>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="mindset-right">
                <div class="mindset-line"></div>
                <div class="mindset-dot"></div>

                <img src="frontend/images/nopainnogain.png" class="mindset-logo" alt="">
            </div>

        </div>

        <!-- SPOTLIGHT -->
        <div class="spotlight"></div>

    </section>


    <!-- =========  Philosophy Section ===========  -->
    <section class="philosophy-section">
        <div class="container-fluid philosophy-container">

            <!-- TOP HEADER -->
            <div class="philosophy-header-row d-flex align-items-center mb-4">
                <h2 class="philosophy-title mb-0">The XRT65 Philosophy</h2>

                <!-- Line from Title to Foundation -->
                <img src="frontend/images/line1.png" class="branch-line flex-grow-1" style="min-width: 50px;" alt="">

                <div class="branch-node d-flex align-items-center flex-shrink-0">
                    <div class="node-dot"></div>
                    <span class="node-text ms-3 text-nowrap">Our Foundation</span>
                </div>

                <!-- Stepped Line from Foundation to Purpose -->
                <div class="flex-grow-1 position-relative"
                    style="height: 19px; margin: 0 6px; border-top: 1.5px solid #a4cece; border-right: 1.5px solid #a4cece; align-self: center; margin-top: 19px; right: -0.6%;">
                </div>

                <div class="branch-node d-flex align-items-center position-relative flex-shrink-0"
                    style="height: 24px; align-self: flex-end; margin-bottom: -15px;">
                    <div class="node-dot"></div>
                    <span class="node-text position-absolute text-nowrap" style="top: 88%; right: -22px; ">Built on
                        Purpose</span>
                </div>
            </div>

            <!-- CARDS & TREE L-SHAPE CONTAINER -->
            <div class="philosophy-cards-container position-relative">

                <!-- The L-shape starting line and horizontal connector -->
                <div class="tree-horizontal-bar"></div>

                <div class="philosophy-cards">

                    <!-- CARD 1 -->
                    <div class="philosophy-card">

                        <div class="tree-branch-down"></div>
                        <img src="frontend/images/phyvector.png" class="phy-shape" alt="Vector Background">

                        <div class="card-top">
                            <img src="frontend/images/philosophyvector.png" class="shape-bg" alt="">
                            <img src="frontend/images/philosophycircle.png" class="circle-img" alt="Philosophy Icon">
                            <h4>OUR VALUES</h4>
                        </div>
                        <div class="card-body-text">
                            <p style="width: 176px">
                                Make fitness a necessity, not a luxury, for a happy and healthy life in every Indian
                                household.
                            </p>
                            <div class="card-bracket">
                                <img src="frontend/images/philosophycircle.png" class="bracket-end-icon" alt="">
                                <div class="bracket-shadow"></div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2 -->
                    <div class="philosophy-card">
                        <div class="tree-branch-down"></div>
                        <img src="frontend/images/phyvector.png" class="phy-shape" alt="Vector Background">
                        <div class="card-top">
                            <img src="frontend/images/philosophyvector.png" class="shape-bg" alt="">
                            <img src="frontend/images/philosophycircle.png" class="circle-img" alt="Philosophy Icon">
                            <h4>OUR VISION</h4>
                        </div>
                        <div class="card-body-text">
                            <p style="width: 130px">
                                Accessibility, quality, innovation and community around fitness.
                            </p>
                            <div class="card-bracket">
                                <img src="frontend/images/philosophycircle.png" class="bracket-end-icon" alt="">
                                <div class="bracket-shadow"></div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3 -->
                    <div class="philosophy-card">
                        <div class="tree-branch-down"></div>
                        <img src="frontend/images/phyvector.png" class="phy-shape" alt="Vector Background">
                        <div class="card-top">
                            <img src="frontend/images/philosophyvector.png" class="shape-bg" alt="">
                            <img src="frontend/images/philosophycircle.png" class="circle-img" alt="Philosophy Icon">
                            <h4>OUR MISSION</h4>
                        </div>
                        <div class="card-body-text">
                            <p style="width: 210px">
                                Break down barriers to fitness by providing high-quality, space-saving equipment for
                                effective home
                                workouts.
                            </p>
                            <div class="card-bracket">
                                <img src="frontend/images/philosophycircle.png" class="bracket-end-icon" alt="">
                                <div class="bracket-shadow"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- =========== FAQ =================== -->
    <section class="faq-section">
        <div class="faq-container">

            <!-- LEFT SIDE -->
            <div class="faq-left">
                <div class="faq-label"><span>FAQ</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="36" viewBox="0 0 91 36"
                        fill="none">
                        <path
                            d="M85.5 25.2559C88.1453 25.3861 90.25 27.5724 90.25 30.25C90.25 33.0114 88.0114 35.25 85.25 35.25C82.4886 35.25 80.25 33.0114 80.25 30.25C80.25 27.5724 82.3547 25.3861 85 25.2559V0.5H0.25C0.111929 0.5 0 0.388071 0 0.25C0 0.111929 0.111929 0 0.25 0H85.5V25.2559Z"
                            fill="white" />
                    </svg>
                </div>

                <h2>Popular<br>Questions</h2>

                <p>
                    Got questions? We've got answers to the stuff people ask us about the most right here!
                </p>

                <div class="faq-cta">
                    <button class="faq-btn">Contact Us</button>
                    <img src="frontend/images/fSectionvector2.png" class="faq-btn-vector" alt="">
                </div>
                <svg class="contact-line" xmlns="http://www.w3.org/2000/svg" width="333" height="36"
                    viewBox="0 0 433 36" fill="none">
                    <path
                        d="M0 0H0.5V30.75H422.25V31.25H0V0ZM427.25 36C424.489 36 422.25 33.7614 422.25 31C422.25 28.2386 424.489 26 427.25 26C430.011 26 432.25 28.2386 432.25 31C432.25 33.7614 430.011 36 427.25 36Z"
                        fill="white" />
                </svg>
            </div>

            <!-- RIGHT SIDE -->
            <div class="faq-right">
                @forelse($faqs as $faq)
                    <div class="faq-item {{ $loop->first ? 'active' : '' }}">
                        <div class="faq-question">
                            {{ $faq->question }}
                            <span class="faq-icon" aria-hidden="true"></span>
                        </div>
                        <div class="faq-answer">{!! nl2br(e($faq->answer)) !!}</div>
                    </div>
                @empty
                    <div class="faq-item active">
                        <div class="faq-question">
                            FAQs will be available soon.
                            <span class="faq-icon" aria-hidden="true"></span>
                        </div>
                        <div class="faq-answer">
                            No FAQs are active right now. Please check back later.
                        </div>
                    </div>
                @endforelse

            </div>

        </div>
    </section>


    <!-- ============  Community Vector ============= -->
    <section class="community-section">
        <div class="container-fluid">

            <!-- HEADER -->
            <div class="community-header">
                <h2>XRT65 Community </h2>


                <div class="subtitle">
                    <span class="line"></span>
                    <p>Insights from Real Journeys</p>
                    <span class="dot"></span>
                </div>
            </div>

            <!-- CARDS -->
            <div class="community-grid">

                <!-- CARD -->
                <div class="community-card">


                    <div class="card-inner">

                        <!-- BACKGROUND VECTOR -->
                        <img src="frontend/images/communityback.png" class="bg-vector" alt="">

                        <!-- CONTENT -->
                        <img src="frontend/images/comm1.png" class="card-img" alt="">
                        <p>Tips to crush your fitness at home</p>

                        <!-- ARROW -->
                        <svg class="arrow-overlay-svg" xmlns="http://www.w3.org/2000/svg" width="132" height="114"
                            viewBox="0 0 182 174" fill="none">
                            <g>
                                <path
                                    d="M52.952 110.816L41.2328 90.5176L100.283 56.4252L60.9882 45.8963L66.4476 25.5214L140.67 45.4094L121.562 116.721L101.187 111.262L110.546 76.3336L52.952 110.816Z"
                                    fill="#FF813E" />
                                <path
                                    d="M52.952 110.816L41.2328 90.5176L100.283 56.4252L60.9882 45.8963L66.4476 25.5214L140.67 45.4094L121.562 116.721L101.187 111.262L110.546 76.3336L52.952 110.816Z" />
                            </g>
                        </svg>
                    </div>
                </div>

                <!-- COPY SAME STRUCTURE FOR ALL -->
                <div class="community-card">


                    <div class="card-inner">
                        <img src="frontend/images/communityback.png" class="bg-vector" alt="">
                        <img src="frontend/images/comm2.png" class="card-img" alt="">
                        <p>Effective Home Workout for Every Goal</p>
                        <!-- ORANGE ACCENT SVG -->
                        <svg class="arrow-overlay-svg" xmlns="http://www.w3.org/2000/svg" width="132" height="114"
                            viewBox="0 0 182 174" fill="none">
                            <g>
                                <path
                                    d="M52.952 110.816L41.2328 90.5176L100.283 56.4252L60.9882 45.8963L66.4476 25.5214L140.67 45.4094L121.562 116.721L101.187 111.262L110.546 76.3336L52.952 110.816Z"
                                    fill="#FF813E" />
                                <path
                                    d="M52.952 110.816L41.2328 90.5176L100.283 56.4252L60.9882 45.8963L66.4476 25.5214L140.67 45.4094L121.562 116.721L101.187 111.262L110.546 76.3336L52.952 110.816Z" />
                            </g>
                        </svg>
                    </div>

                </div>

                <div class="community-card">


                    <div class="card-inner">
                        <img src="frontend/images/communityback.png" class="bg-vector" alt="">
                        <img src="frontend/images/comm3.png" class="card-img" alt="">
                        <p>Fitting Fitness into your Busy Schedule</p>
                        <svg class="arrow-overlay-svg" xmlns="http://www.w3.org/2000/svg" width="132" height="114"
                            viewBox="0 0 182 174" fill="none">
                            <g>
                                <path
                                    d="M52.952 110.816L41.2328 90.5176L100.283 56.4252L60.9882 45.8963L66.4476 25.5214L140.67 45.4094L121.562 116.721L101.187 111.262L110.546 76.3336L52.952 110.816Z"
                                    fill="#FF813E" />
                                <path
                                    d="M52.952 110.816L41.2328 90.5176L100.283 56.4252L60.9882 45.8963L66.4476 25.5214L140.67 45.4094L121.562 116.721L101.187 111.262L110.546 76.3336L52.952 110.816Z" />
                            </g>
                        </svg>
                    </div>
                </div>

                <div class="community-card">

                    <div class="card-inner">
                        <img src="frontend/images/communityback.png" class="bg-vector" alt="">
                        <img src="frontend/images/comm4.png" class="card-img" alt="">

                        <p>Fitting Fitness into your Busy Schedule</p>
                        <svg class="arrow-overlay-svg" xmlns="http://www.w3.org/2000/svg" width="132" height="114"
                            viewBox="0 0 182 174" fill="none">
                            <g>
                                <path
                                    d="M52.952 110.816L41.2328 90.5176L100.283 56.4252L60.9882 45.8963L66.4476 25.5214L140.67 45.4094L121.562 116.721L101.187 111.262L110.546 76.3336L52.952 110.816Z"
                                    fill="#FF813E" />
                                <path
                                    d="M52.952 110.816L41.2328 90.5176L100.283 56.4252L60.9882 45.8963L66.4476 25.5214L140.67 45.4094L121.562 116.721L101.187 111.262L110.546 76.3336L52.952 110.816Z" />
                            </g>
                        </svg>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="pm-testimonials-section" id="testimonials">
        <div class="container-fluid">
            <div class="pm-section-header">
                <span class="pm-section-sub">Hear It From Our</span>
                <h2 class="pm-section-title">CUSTOMERS THEMSELVES</h2>
                <div class="pm-title-line"></div>
            </div>
            <div class="pm-testimonial-slider">
                <div class="row g-4 pm-testimonial-track">
                    @forelse($testimonials as $testimonial)
                        @php
                            $rating = max(0, min(5, (float) $testimonial->rating));
                            $fullStars = (int) floor($rating);
                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            $avatarText = $testimonial->initials
                                ? strtoupper($testimonial->initials)
                                : collect(preg_split('/\s+/', trim($testimonial->name)))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                    ->join('');
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="pm-testimonial-card">
                                <div class="pm-testimonial-stars">
                                    @for($i = 0; $i < $fullStars; $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                    @if($hasHalfStar)
                                        <i class="bi bi-star-half"></i>
                                    @endif
                                    @for($i = 0; $i < $emptyStars; $i++)
                                        <i class="bi bi-star"></i>
                                    @endfor
                                </div>
                                <p class="pm-testimonial-text">"{{ $testimonial->content }}"</p>
                                <div class="pm-testimonial-author">
                                    <div class="pm-testimonial-avatar">{{ $avatarText ?: 'NA' }}</div>
                                    <div>
                                        <h6>{{ $testimonial->name }}</h6>
                                        <span>{{ $testimonial->designation ?: 'Verified Customer' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-4 col-md-6">
                            <div class="pm-testimonial-card">
                                <div class="pm-testimonial-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                                <p class="pm-testimonial-text">"Customer testimonials will be available soon."</p>
                                <div class="pm-testimonial-author">
                                    <div class="pm-testimonial-avatar">NA</div>
                                    <div>
                                        <h6>XRT65 Customer</h6>
                                        <span>Stay tuned</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FEATURED ON (Press Logos) ===== -->
    <section class="pm-featured-on-section" id="featuredOn">
        <div class="container-fluid text-center">
            <span class="pm-section-sub">Making Waves Across Platforms</span>
            <h2 class="pm-section-title">OUR BRAND PROUDLY FEATURED ON</h2>
            <div class="pm-title-line mx-auto"></div>
            <div class="pm-press-logos">
                <div class="pm-press-logo">
                    <span class="press-brand press-brand-et">The Economic Times</span>
                </div>
                <div class="pm-press-logo">
                    <span class="press-brand press-brand-ht">Hindustan Times</span>
                </div>
                <div class="pm-press-logo">
                    <span class="press-brand press-brand-midday">mid•day</span>
                </div>
                <div class="pm-press-logo">
                    <span class="press-brand press-brand-outlook">Outlook</span>
                </div>
                <div class="pm-press-logo">
                    <span class="press-brand press-brand-bc">Business Connect</span>
                </div>
            </div>
        </div>
    </section>


    <!-- ===== NEWSLETTER ===== -->
    <section class="pm-newsletter-section" id="newsletterSection">
        <div class="container-fluid text-center">
            <span class="pm-section-sub">Stay Updated</span>
            <h2 class="pm-section-title">SUBSCRIBE TO OUR NEWSLETTER</h2>
            <div class="pm-title-line mx-auto"></div>
            <p class="pm-newsletter-desc">Get early access to sales, new launches, and fitness tips delivered to your
                inbox.
            </p>
            <form id="newsletterForm" class="pm-newsletter-form">
                <input type="email" placeholder="Email Address" required>
                <button type="submit"><i class="bi bi-arrow-right"></i></button>
            </form>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
    // ===== PRODUCT CATEGORY TABS =====
    (function () {
        const tabs = document.querySelectorAll('#productCategoryTabs .pm-tab-btn');
        const panels = document.querySelectorAll('.pm-tab-panel');
        const swiperInstances = {};

        function initSwiper(panel) {
            const swiperEl = panel.querySelector('.swiper');
            if (!swiperEl || swiperEl._swiperInit) return;
            swiperEl._swiperInit = true;
            new Swiper(swiperEl, {
                slidesPerView: 1.2,
                spaceBetween: 16,
                navigation: {
                    nextEl: swiperEl.querySelector('.swiper-button-next'),
                    prevEl: swiperEl.querySelector('.swiper-button-prev'),
                },
                breakpoints: {
                    480:  { slidesPerView: 2,   spaceBetween: 16 },
                    768:  { slidesPerView: 3,   spaceBetween: 20 },
                    1200: { slidesPerView: 4,   spaceBetween: 24 },
                }
            });
        }

        // Init the default visible panel's swiper
        const defaultPanel = document.querySelector('.pm-tab-panel[data-panel="all"]');
        if (defaultPanel) initSwiper(defaultPanel);

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                const target = tab.dataset.tab;
                panels.forEach(function (panel) {
                    if (panel.dataset.panel === target) {
                        panel.style.display = 'block';
                        initSwiper(panel);
                    } else {
                        panel.style.display = 'none';
                    }
                });
            });
        });
    })();

    // ===== CART CLICK HANDLER =====
    // If product has variations, redirect to product page instead of submitting cart
    function handleCartClick(event, productId, slug, hasVariations) {
        if (hasVariations) {
            event.preventDefault();
            event.stopPropagation();
            window.location.href = '/product/' + slug;
        }
        // Otherwise let the form submit naturally
    }

    // ===== QUICK VIEW =====
    function openQuickView(productId, productName) {
        const modal = document.getElementById('quickViewModal');
        const title = document.getElementById('quickViewTitle');
        const body  = document.getElementById('quickViewBody');

        if (!modal) return;

        title.textContent = productName;
        body.innerHTML = '<div class="text-center py-4"><div class="spinner-border" style="color:#017075;" role="status"></div><p class="mt-3 text-muted" style="font-size:0.9rem;">Loading...</p></div>';

        var bsModal = bootstrap.Modal.getOrCreateInstance(modal);
        bsModal.show();

        fetch('/product/' + productId + '/quick-view', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
        })
        .then(function(res) {
            if (!res.ok) throw new Error('Failed');
            return res.text();
        })
        .then(function(html) {
            body.innerHTML = html;
        })
        .catch(function() {
            body.innerHTML = '<div class="text-center py-4"><p class="text-muted">Could not load product. <a href="/product/' + productId + '" style="color:#017075;">View full page →</a></p></div>';
        });
    }

    // Counter animation for stats
        (function() {
            const counters = document.querySelectorAll('.pm-trust-number[data-count]');
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (!entry.isIntersecting) return;
                    const el = entry.target;
                    const target = parseInt(el.dataset.count, 10);
                    let current = 0;
                    const step = Math.ceil(target / 60);
                    const timer = setInterval(function() {
                        current = Math.min(current + step, target);
                        el.textContent = current.toLocaleString('en-IN') + '+';
                        if (current >= target) clearInterval(timer);
                    }, 30);
                    observer.unobserve(el);
                });
            }, {
                threshold: 0.5
            });
            counters.forEach(function(el) {
                observer.observe(el);
            });
        })();
    </script>
@endpush
