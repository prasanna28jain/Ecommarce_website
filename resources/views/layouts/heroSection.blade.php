<!-- ================= HERO ================= -->
@php
    $heroSlide = isset($sliders)
        ? $sliders->first(fn($slide) => filled($slide->image_path))
        : null;

    $heroBottle = $heroSlide
        ? asset('storage/' . ltrim($heroSlide->image_path, '/'))
        : asset('frontend/images/about1.png');
@endphp

@push('styles')
    <style>
        /* HERO SECTION */
        .hero-section {
            height: 100vh;
            background: linear-gradient(90deg, #F4B952 0%, #F4B952 35%, #9FB8B4 35%, #9FB8B4 100%);
            font-family: 'Quicksand', sans-serif;
            overflow: hidden;
        }

        /* LEFT SIDE */
        .left-bg {
            background-color: #F4B952 !important;
            height: 100vh;
        }

        .left-bg .circle {
            position: absolute;
            width: 450px;
            height: 450px;
            background-color: #1E4D4F;
            border-radius: 50%;
            left: 50%;
            transform: translateX(-10%); /* Shifted slightly right to overlap the split */
            z-index: 1;
        }

        /* Bottle Image */
        .bottle-img {
            position: relative;
            z-index: 2;
            height: 500px;
            object-fit: contain;
        }

        /* RIGHT SIDE */
        .right-bg {
            background-color: #9FB8B4;
            height: 100vh;
            position: relative;
        }

        /* Nav links at the top center */
        .hero-nav {
            position: absolute;
            top: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 30px;
            z-index: 10;
        }

        .hero-nav a {
            text-decoration: none;
            color: #1E4D4F;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Branding Top Left */
        .hero-brand {
            position: absolute;
            top: 40px;
            left: 40px;
            z-index: 10;
            color: #1E4D4F;
            font-weight: 700;
            font-size: 1.2rem;
            letter-spacing: 1px;
        }

        /* Social Icons Top Right */
        .hero-socials {
            position: absolute;
            top: 40px;
            right: 40px;
            z-index: 10;
            display: flex;
            gap: 15px;
            color: white;
        }

        .hero-socials i {
            font-size: 1.1rem;
        }

        .content {
            margin-left: 50px; /* Offset to not overlap the bottle too much */
            position: relative;
            z-index: 5;
        }

        .content h1 {
            font-size: 70px;
            font-weight: 700;
            color: #1E4D4F;
            line-height: 1.1;
            letter-spacing: 2px;
        }

        .content p {
            margin-top: 30px;
            color: #1E4D4F;
            max-width: 400px;
            font-size: 1.1rem;
            line-height: 1.5;
            font-weight: 500;
            }

        /* BUTTON */
        .shop-btn {
            margin-top: 30px;
            background-color: #E36C61;
            color: white;
            padding: 12px 35px;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .shop-btn:hover {
            background-color: #d65a50;
            color: white;
            transform: translateY(-2px);
        }

        /* Shop floating icon bottom right */
        .shop-floating-icon {
            position: absolute;
            bottom: 40px;
            right: 40px;
            width: 60px;
            height: 60px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .shop-floating-icon i {
            color: #1E4D4F;
            font-size: 1.5rem;
        }

        .shop-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 12px;
            height: 12px;
            background-color: #E36C61;
            border-radius: 50%;
        }

        /* RESPONSIVE */
        @media (max-width: 991px) {
            .content h1 {
                font-size: 50px;
            }
            .left-bg .circle {
                width: 350px;
                height: 350px;
            }
            .bottle-img {
                height: 400px;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                background: #9FB8B4;
                height: auto;
                min-height: 100vh;
                padding-bottom: 50px;
            }
            .content h1 {
                font-size: 40px;
            }
            .left-bg {
                background-color: transparent !important;
                height: auto;
                padding-top: 100px;
                padding-bottom: 40px;
            }
            .left-bg .circle {
                transform: translateX(-50%);
            }
            .right-bg {
                width: 100%;
                height: auto;
            }
            .content {
                margin-left: 0;
                text-align: center;
            }
            .content p {
                margin: 20px auto;
            }
            .hero-nav {
                display: none; /* Hide on mobile to save space, assuming a mobile menu exists */
            }
        }
    </style>
@endpush

<section class="hero-section">
    <!-- Branding Top Left -->
    <div class="hero-brand">ELEGANZA</div>

    <!-- Nav Links Top Center -->
    <div class="hero-nav">
        <a href="#">THE BOTTLE</a>
        <a href="#">SHOP</a>
        <a href="#">TECHNOLOGY</a>
        <a href="#">REVIEWS</a>
        <a href="#">SIGN IN</a>
    </div>

    <!-- Socials Top Right -->
    <div class="hero-socials">
        <a href="#"><i class="fab fa-twitter" style="color: white;"></i></a>
        <a href="#"><i class="fab fa-instagram" style="color: white;"></i></a>
        <a href="#"><i class="fab fa-facebook-f" style="color: white;"></i></a>
    </div>

    <div class="container-fluid p-0 h-100">
        <div class="row g-0 h-100">

            <!-- LEFT SIDE -->
            <div class="col-md-4 left-bg position-relative d-flex justify-content-center align-items-center">
                <div class="circle"></div>

                <!-- Bottle Image -->
                <img src="{{ $heroBottle }}" class="bottle-img" alt="Bottle">
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-md-8 right-bg d-flex align-items-center">
                <div class="content px-5">
                    <h1>DISCOVER <br> THE SOLID <br> COLLECTION</h1>

                    <p>
                        Our patented design keeps your water <br> cold for 18hrs.
                        Find your favourite bottle
                    </p>

                    <button class="btn shop-btn">Go to shop</button>
                </div>
                
                <!-- Floating Cart Icon bottom right -->
                <div class="shop-floating-icon">
                    <i class="fas fa-shopping-bag"></i>
                    <div class="shop-badge"></div>
                </div>
            </div>

        </div>
    </div>
</section>
