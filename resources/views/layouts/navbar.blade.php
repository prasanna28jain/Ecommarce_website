<nav class="navbar navbar-expand-lg navbar-dark custom-navbar px-4">
    <a class="navbar-brand d-flex flex-column align-items-start" href="{{ route('home') }}" style="line-height:1;">
        @if(optional($appSetting)->logo_path)
            <img src="{{ asset('storage/' . $appSetting->logo_path) }}" alt="{{ $appSetting->site_name ?? 'Boxima Fitness' }}" height="42"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
            <span style="display:none; font-size:1.4rem; font-weight:900; letter-spacing:2px; color:#fff;">BOX<span style="color:#00e5ff;">IMA</span></span>
        @else
            <span style="font-size:1.4rem; font-weight:900; letter-spacing:2px; color:#fff;">BOX<span style="color:#00e5ff;">IMA</span></span>
        @endif
        <span style="font-size:10px; font-style:italic; font-weight:800; letter-spacing:1.6px; color:#fff; margin-top:2px; text-transform:uppercase; align-self:flex-end; text-align:right; font-family: 'Sprintura' !important; position: relative; left: 56px;">
            KEEP GOING
        </span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
            aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse align-items-center" id="navMenu">
        <ul class="navbar-nav mx-auto gap-4">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('categories.*','category.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('brands.*','brand.*') ? 'active' : '' }}" href="{{ route('brands.index') }}">Brands</a>
            </li>
        </ul>

        {{-- Desktop Icons + Auth --}}
        <div class="d-flex align-items-center gap-3">
            <div class="nav-icons d-none d-lg-flex">
                {{-- Wishlist --}}
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#wishlistSidebar" class="nav-icon-link nav-wishlist-link" aria-label="Wishlist">
                    <i class="bi bi-heart"></i>
                    <span class="wishlist-count nav-wishlist-count">{{ $headerWishlistCount ?? 0 }}</span>
                </a>
                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="nav-icon-link nav-cart-link" aria-label="Cart">
                    <i class="bi bi-cart3"></i>
                    <span class="cart-count nav-cart-count">{{ $headerCartCount ?? 0 }}</span>
                </a>
            </div>

            @auth
                {{-- User Dropdown --}}
                <div class="dropdown d-none d-lg-block">
                    <button class="btn btn-shop-now rounded-pill px-4 dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            style="display:flex; align-items:center; gap:8px;">
                        <i class="bi bi-person-circle" style="font-size:1.1rem;"></i>
                        <span style="max-width:100px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width:200px; border-radius:10px; box-shadow:0 8px 30px rgba(0,0,0,0.15); border:none; padding:8px 0;">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('account.index') }}"
                               style="font-size:0.9rem; color:#495057; font-weight:600;">
                                <i class="bi bi-person" style="color:#017075; width:18px;"></i> My Account
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('account.orders') }}"
                               style="font-size:0.9rem; color:#495057; font-weight:600;">
                                <i class="bi bi-bag-check" style="color:#017075; width:18px;"></i> My Orders
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('wishlist.index') }}"
                               style="font-size:0.9rem; color:#495057; font-weight:600;">
                                <i class="bi bi-heart" style="color:#017075; width:18px;"></i> Wishlist
                                <span class="badge ms-auto nav-wishlist-count" style="background:#017075; font-size:0.7rem;">{{ $headerWishlistCount ?? 0 }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('cart.index') }}"
                               style="font-size:0.9rem; color:#495057; font-weight:600;">
                                <i class="bi bi-cart3" style="color:#017075; width:18px;"></i> Cart
                                <span class="badge ms-auto nav-cart-count" style="background:#017075; font-size:0.7rem;">{{ $headerCartCount ?? 0 }}</span>
                            </a>
                        </li>
                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('access admin'))
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('admin.dashboard') }}"
                                   style="font-size:0.9rem; color:#495057; font-weight:600;">
                                    <i class="bi bi-speedometer2" style="color:#017075; width:18px;"></i> Admin Panel
                                </a>
                            </li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2"
                                        style="font-size:0.9rem; color:#dc3545; font-weight:600;">
                                    <i class="bi bi-box-arrow-right" style="color:#dc3545; width:18px;"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <div class="d-none d-lg-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-shop-now rounded-pill px-4">Log In</a>
                    <a href="{{ route('register') }}" class="btn rounded-pill px-4"
                       style="border:1.5px solid #02AAB1; color:#fff; font-weight:600; background:transparent; transition:all 0.2s; display:flex; align-items:center; justify-content:center;"
                       onmouseover="this.style.background='rgba(2,170,177,0.15)'; this.style.borderColor='#00c9e0';"
                       onmouseout="this.style.background='transparent'; this.style.borderColor='#02AAB1';">Sign Up</a>
                </div>
            @endauth
        </div>

        {{-- Mobile Menu --}}
        <div class="d-lg-none w-100 mt-3">
            <div class="nav-icons d-flex justify-content-center gap-4 mb-3">
                {{-- Wishlist --}}
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#wishlistSidebar" class="nav-icon-link nav-wishlist-link" aria-label="Wishlist">
                    <i class="bi bi-heart"></i>
                    <span class="wishlist-count nav-wishlist-count">{{ $headerWishlistCount ?? 0 }}</span>
                </a>
                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="nav-icon-link nav-cart-link" aria-label="Cart">
                    <i class="bi bi-cart3"></i>
                    <span class="cart-count nav-cart-count">{{ $headerCartCount ?? 0 }}</span>
                </a>
            </div>

            @auth
                <div style="background:rgba(255,255,255,0.05); border-radius:10px; padding:14px 16px; margin-bottom:8px;">
                    <p style="color:rgba(255,255,255,0.5); font-size:0.7rem; text-transform:uppercase; letter-spacing:2px; margin:0 0 8px;">Logged in as</p>
                    <p style="color:#fff; font-weight:700; font-size:0.95rem; margin:0 0 10px;">{{ Auth::user()->name }}</p>
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <a href="{{ route('account.index') }}" style="color:rgba(255,255,255,0.8); font-size:0.88rem; text-decoration:none; display:flex; align-items:center; gap:8px;">
                            <i class="bi bi-person" style="color:#00e5ff;"></i> My Account
                        </a>
                        <a href="{{ route('account.orders') }}" style="color:rgba(255,255,255,0.8); font-size:0.88rem; text-decoration:none; display:flex; align-items:center; gap:8px;">
                            <i class="bi bi-bag-check" style="color:#00e5ff;"></i> My Orders
                        </a>
                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('access admin'))
                            <a href="{{ route('admin.dashboard') }}" style="color:rgba(255,255,255,0.8); font-size:0.88rem; text-decoration:none; display:flex; align-items:center; gap:8px;">
                                <i class="bi bi-speedometer2" style="color:#00e5ff;"></i> Admin Panel
                            </a>
                        @endif
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn w-100 rounded-pill"
                            style="border:1.5px solid rgba(220,53,69,0.5); color:#ff6b6b; font-weight:600; background:transparent;">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            @else
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <a href="{{ route('login') }}">
                        <button class="btn btn-shop-now rounded-pill px-4 w-100">Log In</button>
                    </a>
                    <a href="{{ route('register') }}">
                        <button class="btn rounded-pill px-4 w-100"
                                style="border:1.5px solid rgba(255,255,255,0.3); color:#fff; font-weight:600; background:transparent;">
                            Create Account
                        </button>
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
