<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Boxima Fitness | Premium Home Gym Equipment')</title>
    <meta name="description"
        content="Transform your workout with XRT65 adjustable dumbbells. Premium home gym equipment from 2kg to 40kg. Shop dumbbells, benches, and combo kits with free shipping.">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Inter:opsz@14..32&display=swap"
        rel="stylesheet">
    <!-- XRT60 Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/xrt60.css') }}">
    <script src="{{ asset('frontend/js/load.js') }}"></script>
    <script src="{{ asset('frontend/js/app.js') }}"></script>

    @yield('styles')
    @stack('styles')
</head>

<body>

    @include('layouts.topbar')
    <!-- ================= NAVBAR ================= -->
    <div class="hero-dark-wrapper">
        <div class="container-fluid">
            @include('layouts.navbar')
        </div>
        @hasSection('hero')
            @yield('hero')
        @else
            @if (request()->routeIs('home'))
                @include('layouts.heroSection')
            @endif
        @endif
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <main>
        @yield('content')
    </main>



    @include('layouts.footer')


    <!-- ===== QUICK VIEW MODAL ===== -->
    <div class="modal fade modal-xrt" id="quickViewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="quickViewTitle">Quick View</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="quickViewBody"></div>
            </div>
        </div>
    </div>

    <!-- ===== OFFER POPUP ===== -->
    <div class="offer-popup-overlay" id="offerPopup">
        <div class="offer-popup">
            <button class="offer-popup-close">&times;</button>
            <div class="offer-popup-header">
                <div class="mb-2"><i class="bi bi-gift" style="font-size:2.5rem;"></i></div>
                <h3>Get 10% OFF</h3>
                <p class="mb-0 opacity-75">Your first order!</p>
            </div>
            <div class="offer-popup-body">
                <p class="text-muted mb-3">Enter your email to receive your exclusive discount code</p>
                <input type="email" placeholder="Your email address">
                <button class="btn-xrt btn-primary-xrt w-100"
                    onclick="showToast('Coupon code XRT10 sent to your email! 🎉'); document.getElementById('offerPopup').classList.remove('show'); sessionStorage.setItem('xrt65_popup_dismissed','1');">Claim
                    My Discount</button>
                <p class="mt-3 mb-0"><small class="text-muted">No spam. Unsubscribe anytime.</small></p>
            </div>
        </div>
    </div>

    <!-- ===== BACK TO TOP ===== -->
    <button class="back-to-top" id="backToTop"><i class="bi bi-chevron-up"></i></button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script>
        // Hero image rotator — only on home page
        (function() {
            const imgMain  = document.querySelector(".img-main");
            const imgSmall = document.querySelector(".img-small");
            const imgSmall2 = document.querySelector(".img-small2");
            if (!imgMain || !imgSmall || !imgSmall2) return;

            const images = [
                "{{ asset('frontend/images/combo-set 1.png') }}",
                "{{ asset('frontend/images/dumbbell.png') }}",
                "{{ asset('frontend/images/home-gym-kit 1.png') }}"
            ];
            function rotateImages() {
                images.push(images.shift());
                imgSmall2.src = images[0];
                imgMain.src   = images[1];
                imgSmall.src  = images[2];
            }
            setInterval(rotateImages, 3000);
        })();
    </script>

    <script>
        // Video modal — only on home page
        (function() {
            const modal    = document.getElementById("videoModal");
            const iframe   = document.getElementById("videoFrame");
            const closeBtn = document.querySelector(".close-btn");
            const watchBtn = document.querySelector(".watch-video");
            if (!modal || !iframe) return;

            document.querySelectorAll(".video-circle").forEach(item => {
                item.addEventListener("click", () => {
                    iframe.src = item.dataset.video;
                    modal.classList.add("active");
                });
            });

            if (watchBtn) {
                watchBtn.addEventListener("click", function() {
                    iframe.src = this.dataset.video;
                    modal.classList.add("active");
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener("click", () => {
                    modal.classList.remove("active");
                    iframe.src = "";
                });
            }

            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.classList.remove("active");
                    iframe.src = "";
                }
            });
        })();
    </script>
    <script>
        const mindsetSection = document.querySelector(".mindset-section");
        const mindsetWrapper = document.querySelector(".mindset-wrapper");
        const spotlight = document.querySelector(".spotlight");
        const highlightText = document.querySelector(".mindset-section .text.highlight");
        const cursorCircle = document.querySelector(".cursor-circle");
        const isMobile = window.matchMedia("(max-width: 768px)");

        const resetMindsetEffects = () => {
            if (cursorCircle) cursorCircle.style.opacity = "0";
            if (highlightText) {
                const resetMask = "radial-gradient(circle 0px at 0 0, black 0%, transparent 100%)";
                highlightText.style.webkitMaskImage = resetMask;
                highlightText.style.maskImage = resetMask;
            }
        };

        if (mindsetSection && mindsetWrapper && spotlight && highlightText && cursorCircle) {
            mindsetSection.addEventListener("mouseenter", () => {
                if (!isMobile.matches) cursorCircle.style.opacity = "1";
            });

            mindsetSection.addEventListener("mouseleave", () => {
                resetMindsetEffects();
            });

            mindsetSection.addEventListener("mousemove", (e) => {
                if (isMobile.matches) {
                    resetMindsetEffects();
                    return;
                }

                const sectionRect = mindsetSection.getBoundingClientRect();
                const wrapperRect = mindsetWrapper.getBoundingClientRect();
                const sectionX = e.clientX - sectionRect.left;
                const sectionY = e.clientY - sectionRect.top;
                const wrapperX = e.clientX - wrapperRect.left;
                const wrapperY = e.clientY - wrapperRect.top;

                cursorCircle.style.left = `${wrapperX}px`;
                cursorCircle.style.top = `${wrapperY}px`;
                cursorCircle.style.opacity = "1";

                spotlight.style.background = `
      radial-gradient(
        circle 170px at ${sectionX}px ${sectionY}px,
        rgba(255,255,255,0.38) 0%,
        rgba(238,240,241,0) 72%
      )
    `;

                const textRect = highlightText.getBoundingClientRect();
                const localX = e.clientX - textRect.left;
                const localY = e.clientY - textRect.top;
                const revealYOffset = 42;
                const mask =
                    `radial-gradient(circle 96px at ${localX}px ${localY + revealYOffset}px, black 86%, transparent 100%)`;
                highlightText.style.webkitMaskImage = mask;
                highlightText.style.maskImage = mask;
            });

            isMobile.addEventListener("change", () => {
                resetMindsetEffects();
            });
        }
    </script>
    <script>
        (() => {
            const slider = document.querySelector(".pm-testimonial-slider");
            const track = document.querySelector(".pm-testimonial-track");
            if (!slider || !track) return;

            const originalItems = Array.from(track.children);
            originalItems.forEach((item) => {
                track.appendChild(item.cloneNode(true));
            });

            let rafId = null;
            const speed = 0.45;

            const tick = () => {
                slider.scrollLeft += speed;
                if (slider.scrollLeft >= track.scrollWidth / 2) {
                    slider.scrollLeft = 0;
                }
                rafId = requestAnimationFrame(tick);
            };

            const start = () => {
                if (!rafId) rafId = requestAnimationFrame(tick);
            };

            const stop = () => {
                if (rafId) {
                    cancelAnimationFrame(rafId);
                    rafId = null;
                }
            };

            start();
            slider.addEventListener("mouseenter", stop);
            slider.addEventListener("mouseleave", start);
            window.addEventListener("blur", stop);
            window.addEventListener("focus", start);
        })();
    </script>
    <script>
        (function() {
            const items = document.querySelectorAll(".faq-item");
            items.forEach(item => {
                item.addEventListener("click", () => {
                    items.forEach(i => { if (i !== item) i.classList.remove("active"); });
                    item.classList.toggle("active");
                });
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>
