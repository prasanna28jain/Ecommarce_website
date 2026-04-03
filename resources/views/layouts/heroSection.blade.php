<!-- ================= HERO ================= -->
        <section class="hero-section">

            <div class="container-fluid">
                <div class="row g-0">

                    <!-- LEFT AUTO SLIDER -->
                    <div class="col-lg-6 position-relative hero-left d-flex ">

                        <!-- BIG CENTER CARD -->
                        <div class="card-svg big">
                            <!-- ACCENT LINE -->
                            <svg class="accent-line" xmlns="http://www.w3.org/2000/svg" width="99" height="4"
                                viewBox="0 0 99 4" fill="none">
                                <path
                                    d="M9.09877e-07 3.24966e-06L3.14163 3.21878L98.2666 3.12262L94 -4.92184e-09L9.09877e-07 3.24966e-06Z"
                                    fill="#00FFEF" />
                            </svg>

                            <svg xmlns="http://www.w3.org/2000/svg" width="602" height="301" viewBox="0 0 602 301"
                                fill="none">
                                <path d="M602 301H301L0 0H301L602 301Z" fill="url(#paint0_linear_6171_240)" />
                                <defs>
                                    <linearGradient id="paint0_linear_6171_240" x1="301" y1="0" x2="301" y2="301"
                                        gradientUnits="userSpaceOnUse">
                                        <stop stop-color="white" stop-opacity="0.8" />
                                        <stop offset="1" stop-color="white" stop-opacity="0" />
                                    </linearGradient>
                                </defs>
                            </svg>

                            <!-- ORANGE ACCENT SVG -->
                            <svg class="bottom-overlay-svg" xmlns="http://www.w3.org/2000/svg" width="132" height="114"
                                viewBox="0 0 182 174" fill="none">
                                <g filter="url(#filter0_d_6171_241_new)">
                                    <path
                                        d="M52.952 110.816L41.2328 90.5176L100.283 56.4252L60.9882 45.8963L66.4476 25.5214L140.67 45.4094L121.562 116.721L101.187 111.262L110.546 76.3336L52.952 110.816Z"
                                        fill="#FF813E" />
                                    <path
                                        d="M52.952 110.816L41.2328 90.5176L100.283 56.4252L60.9882 45.8963L66.4476 25.5214L140.67 45.4094L121.562 116.721L101.187 111.262L110.546 76.3336L52.952 110.816Z"
                                        stroke="#FF6311" stroke-width="3.85965" />
                                </g>
                                <defs>
                                    <filter id="filter0_d_6171_241_new" x="0.00018692" y="1.90735e-06" width="150"
                                        height="124" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                        <feColorMatrix in="SourceAlpha" type="matrix"
                                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                        <feOffset dy="15.4386" />
                                        <feGaussianBlur stdDeviation="19.2982" />
                                        <feComposite in2="hardAlpha" operator="out" />
                                        <feColorMatrix type="matrix"
                                            values="0 0 0 0 1 0 0 0 0 0.503935 0 0 0 0 0.243183 0 0 0 0.5 0" />
                                        <feBlend mode="normal" in2="BackgroundImageFix"
                                            result="effect1_dropShadow_6171_241" />
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_6171_241"
                                            result="shape" />
                                    </filter>
                                </defs>
                            </svg>

                            <img src="{{ isset($heroProducts) && $heroProducts->count() > 0 && $heroProducts[0]->images->isNotEmpty() ? asset('storage/' . $heroProducts[0]->images->first()->path) : asset('frontend/images/dumbbell.png') }}" class="img-main" alt="{{ $heroProducts[0]->name ?? 'Featured Product' }}">
                        </div>

                        <svg class="accent-line-right" xmlns="http://www.w3.org/2000/svg" width="68" height="44"
                            viewBox="0 0 68 64" fill="none">
                            <path d="M68 -2.97237e-06L68 2.45367L0 64L0.904994 61.3419L68 -2.97237e-06Z" fill="white" />
                        </svg>
                        <svg class="accent-line-right2" xmlns="http://www.w3.org/2000/svg" width="68" height="44"
                            viewBox="0 0 68 64" fill="none">
                            <path d="M68 -2.97237e-06L68 2.45367L0 64L0.904994 61.3419L68 -2.97237e-06Z" fill="white" />
                        </svg>

                        <!-- RIGHT SMALL CARD -->
                        <div class="card-svg right">
                            <!-- ACCENT LINE -->

                            <svg xmlns="http://www.w3.org/2000/svg" width="301" height="151" viewBox="0 0 301 151"
                                fill="none">
                                <path d="M301 151H150.5L0 0H150.5L301 151Z" fill="url(#paint0_linear_6171_234)" />
                                <defs>
                                    <linearGradient id="paint0_linear_6171_234" x1="150.5" y1="0" x2="150.5" y2="151"
                                        gradientUnits="userSpaceOnUse">
                                        <stop stop-color="white" stop-opacity="0.8" />
                                        <stop offset="1" stop-color="white" stop-opacity="0" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            <img src="{{ isset($heroProducts) && $heroProducts->count() > 1 && $heroProducts[1]->images->isNotEmpty() ? asset('storage/' . $heroProducts[1]->images->first()->path) : asset('frontend/images/home-gym-kit 1.png') }}" class="img-small" alt="{{ $heroProducts[1]->name ?? 'Featured Product' }}">
                        </div>

                        <!-- LEFT BOTTOM CARD -->
                        <div class="card-svg left">
                            <svg xmlns="http://www.w3.org/2000/svg" width="301" height="150" viewBox="0 0 301 150"
                                fill="none">
                                <path d="M301 150H150.5L0 0H150.5L301 150Z" fill="url(#paint0_linear_6171_232)" />
                                <defs>
                                    <linearGradient id="paint0_linear_6171_232" x1="150.5" y1="0" x2="150.5" y2="150"
                                        gradientUnits="userSpaceOnUse">
                                        <stop stop-color="white" stop-opacity="0.8" />
                                        <stop offset="1" stop-color="white" stop-opacity="0" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            <img src="{{ isset($heroProducts) && $heroProducts->count() > 2 && $heroProducts[2]->images->isNotEmpty() ? asset('storage/' . $heroProducts[2]->images->first()->path) : asset('frontend/images/combo-set 1.png') }}" class="img-small2" alt="{{ $heroProducts[2]->name ?? 'Featured Product' }}">
                        </div>
                        <svg class="accent-line-left" xmlns="http://www.w3.org/2000/svg" width="68" height="44"
                            viewBox="0 0 68 64" fill="none">
                            <path d="M68 -2.97237e-06L68 2.45367L0 64L0.904994 61.3419L68 -2.97237e-06Z" fill="white" />
                        </svg>
                        <svg class="accent-line-left2" xmlns="http://www.w3.org/2000/svg" width="68" height="44"
                            viewBox="0 0 68 64" fill="none">
                            <path d="M68 -2.97237e-06L68 2.45367L0 64L0.904994 61.3419L68 -2.97237e-06Z" fill="white" />
                        </svg>

                        <!-- EXTRA SMALL BACK CARD -->
                        <div class="card-svg back">
                            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="75" viewBox="0 0 150 75"
                                fill="none">
                                <path d="M150 75H75L0 0H75L150 75Z" fill="url(#paint0_linear_6171_252)" />
                                <defs>
                                    <linearGradient id="paint0_linear_6171_252" x1="75" y1="0" x2="75" y2="75"
                                        gradientUnits="userSpaceOnUse">
                                        <stop stop-color="white" stop-opacity="0.8" />
                                        <stop offset="1" stop-color="white" stop-opacity="0" />
                                    </linearGradient>
                                </defs>
                            </svg>

                        </div>


                        <div class="card-svg back-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="75" viewBox="0 0 150 75"
                                fill="none">
                                <path d="M150 75H75L0 0H75L150 75Z" fill="url(#paint0_linear_6171_252_2)" />
                                <defs>
                                    <linearGradient id="paint0_linear_6171_252_2" x1="75" y1="0" x2="75" y2="75"
                                        gradientUnits="userSpaceOnUse">
                                        <stop stop-color="white" stop-opacity="0.8" />
                                        <stop offset="1" stop-color="white" stop-opacity="0" />
                                    </linearGradient>
                                </defs>
                            </svg>

                        </div>



                    </div>

                    <!-- RIGHT CONTENT -->
                    <div
                        class="col-lg-6 d-flex align-items-center justify-content-center  text-center text-lg-start mt-lg-0">
                        <div class="glass-box" style="background-image: url('./frontend/images/Group 14 1.png');">
                            <h6 class="text-light">COMPLETE</h6>
                            <h1 class="text-info fw-bold">HOME GYM COMBO</h1>
                            <p class="body-content">Body Content</p>

                            <button class="btn btn-info rounded-pill px-4 mt-3">Shop Now</button>
                        </div>

                    </div>

                </div>
            </div>


        </section>





        <section class="features-bar container">
            <div class="features-bar-inner">
                <svg class="feature-curve-left" xmlns="http://www.w3.org/2000/svg" width="39" height="95"
                    viewBox="0 0 39 95" fill="none">
                    <path
                        d="M37.5875 0.919927C37.4338 0.271522 36.7829 -0.130939 36.1385 0.0388983C25.8835 2.74178 16.7848 8.73589 10.2506 17.1172C3.46877 25.816 -0.14532 36.5667 0.00447258 47.5958C0.154266 58.6248 4.05899 69.2734 11.0745 77.7849C17.8339 85.9856 27.0921 91.7304 37.4167 94.1538C38.0655 94.3061 38.7052 93.8861 38.8413 93.2337C38.9774 92.5814 38.5583 91.9438 37.9097 91.7907C28.1223 89.4799 19.347 84.0272 12.9367 76.25C6.27023 68.162 2.55979 58.0433 2.41745 47.563C2.27511 37.0827 5.70938 26.867 12.1537 18.6009C18.3505 10.6525 26.9745 4.96344 36.6955 2.38775C37.3397 2.21707 37.7413 1.56833 37.5875 0.919927Z"
                        fill="url(#paint0_linear_6171_275)" />
                    <defs>
                        <linearGradient id="paint0_linear_6171_275" x1="5.43316e-07" y1="42.9371" x2="42" y2="42.9371"
                            gradientUnits="userSpaceOnUse">
                            <stop stop-color="#06D0DA" />
                            <stop offset="1" stop-color="#707474" stop-opacity="0" />
                        </linearGradient>
                    </defs>
                </svg>
                <div class="features-scroll-wrapper">
                    <div class="row text-center text-md-start align-items-center">

                        <div class="col-md-3 d-flex align-items-center gap-3 feature-item">

                            <i class="bi bi-geo-alt-fill icon"></i>
                            <div>
                                <h6>Pan-India Service</h6>
                                <p>On-site service across India</p>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex align-items-center gap-3 feature-item">
                            <i class="bi bi-award-fill icon"></i>
                            <div>
                                <h6>Guaranteed Quality</h6>
                                <p>ISO Certified Products</p>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex align-items-center gap-3 feature-item">
                            <i class="bi bi-truck icon"></i>
                            <div>
                                <h6>Free Delivery</h6>
                                <p>On orders above ₹5,000</p>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex align-items-center gap-3 feature-item">
                            <i class="bi bi-shield-check icon"></i>
                            <div>
                                <h6>5-Year Warranty</h6>
                                <p>Industry-leading coverage</p>
                            </div>

                        </div>
                    </div>
                    <svg class="feature-curve-right" xmlns="http://www.w3.org/2000/svg" width="39" height="95"
                        viewBox="0 0 39 95" fill="none">
                        <path
                            d="M1.27967 93.2651C1.43343 93.9135 2.0843 94.316 2.72868 94.1462C12.9837 91.4433 22.0824 85.4492 28.6166 77.0679C35.3984 68.369 39.0125 57.6183 38.8627 46.5893C38.7129 35.5602 34.8082 24.9116 27.7927 16.4002C21.0333 8.19944 11.7751 2.45464 1.45044 0.0312729C0.801685 -0.121002 0.161987 0.298988 0.0258904 0.951324C-0.110207 1.60367 0.308884 2.24126 0.957443 2.39439C10.7449 4.70512 19.5202 10.1579 25.9305 17.9351C32.597 26.023 36.3074 36.1418 36.4497 46.622C36.5921 57.1023 33.1578 67.3181 26.7135 75.5841C20.5167 83.5326 11.8927 89.2216 2.17168 91.7973C1.52752 91.968 1.1259 92.6167 1.27967 93.2651Z"
                            fill="url(#paint0_linear_6171_276)" />
                        <defs>
                            <linearGradient id="paint0_linear_6171_276" x1="38.8672" y1="51.2479" x2="-3.13281"
                                y2="51.2479" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#06D0DA" />
                                <stop offset="1" stop-color="#707474" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                    </svg>

                </div>
        </section>