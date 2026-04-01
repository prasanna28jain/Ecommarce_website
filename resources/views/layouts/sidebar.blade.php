<aside class="df-sidebar">
    <!-- Logo -->
    <div class="df-sidebar-logo">
        <a href="{{ route('admin.dashboard') }}">
            <span class="logo-icon"><i class="bi bi-lightning-charge-fill"></i></span>
            {{ config('app.name', 'Dataflow') }}
        </a>
    </div>

    <!-- Navigation -->
    <nav class="df-sidebar-nav">

        {{-- Dashboard --}}
        <div class="df-nav-section">
            <a href="{{ route('admin.dashboard') }}" class="df-nav-link">
                <span class="nav-icon"><i class="bi bi-grid-1x2"></i></span>
                <span class="nav-text">Dashboard</span>
            </a>
        </div>

        {{-- CATALOG --}}
        <div class="df-nav-section">
            <div class="df-nav-section-title">Catalog</div>

            {{-- Products --}}
            <div class="df-nav-item has-submenu">
                <a class="df-nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-box-seam"></i></span>
                    <span class="nav-text">Product</span>
                    <span class="nav-chevron"><i class="bi bi-chevron-right"></i></span>
                </a>
                <div class="df-submenu">
                    <a href="{{ route('admin.products.index') }}" class="df-nav-link">All Products</a>
                    <a href="{{ route('admin.products.create') }}" class="df-nav-link">Add Product</a>
                </div>
            </div>

            {{-- Category --}}
            <div class="df-nav-item has-submenu">
                <a class="df-nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-folder2-open"></i></span>
                    <span class="nav-text">Category</span>
                    <span class="nav-chevron"><i class="bi bi-chevron-right"></i></span>
                </a>
                <div class="df-submenu">
                    <a href="{{ route('admin.categories.index') }}" class="df-nav-link">All Categories</a>
                    <a href="{{ route('admin.categories.create') }}" class="df-nav-link">Add Category</a>
                </div>
            </div>

            {{-- Tags --}}
            <div class="df-nav-item has-submenu">
                <a class="df-nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-bookmark-star"></i></span>
                    <span class="nav-text">Tags</span>
                    <span class="nav-chevron"><i class="bi bi-chevron-right"></i></span>
                </a>
                <div class="df-submenu">
                    <a href="{{ route('admin.tags.index') }}" class="df-nav-link">All Tags</a>
                    <a href="{{ route('admin.tags.create') }}" class="df-nav-link">Add Tag</a>
                </div>
            </div>

            {{-- Attributes --}}
            <div class="df-nav-item has-submenu">
                <a class="df-nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-sliders"></i></span>
                    <span class="nav-text">Attributes</span>
                    <span class="nav-chevron"><i class="bi bi-chevron-right"></i></span>
                </a>
                <div class="df-submenu">
                    <a href="{{ route('admin.attributes.index') }}" class="df-nav-link">All Attributes</a>
                    <a href="{{ route('admin.attributes.create') }}" class="df-nav-link">Add Attribute</a>
                </div>
            </div>

            {{-- Brands --}}
            <div class="df-nav-item">
                <a href="{{ route('admin.brands.index') }}" class="df-nav-link">
                    <span class="nav-icon"><i class="bi bi-award"></i></span>
                    <span class="nav-text">Brands</span>
                </a>
            </div>
        </div>

        {{-- SALES --}}
        <div class="df-nav-section">
            <div class="df-nav-section-title">Sales</div>

            <div class="df-nav-item has-submenu">
                <a class="df-nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-receipt"></i></span>
                    <span class="nav-text">Order</span>
                    <span class="nav-chevron"><i class="bi bi-chevron-right"></i></span>
                </a>
                <div class="df-submenu">
                    <a href="{{ route('admin.orders.index') }}" class="df-nav-link">Order List</a>
                </div>
            </div>

            <div class="df-nav-item">
                <a href="{{ route('admin.coupons.index') }}" class="df-nav-link">
                    <span class="nav-icon"><i class="bi bi-ticket-perforated"></i></span>
                    <span class="nav-text">Coupons</span>
                </a>
            </div>
        </div>

        {{-- SETTINGS --}}
        <div class="df-nav-section">
            <div class="df-nav-section-title">Settings</div>

            {{-- <div class="df-nav-item">
                <a href="{{ route('admin.payment-providers.settings') }}" class="df-nav-link">
                    <span class="nav-icon"><i class="bi bi-sliders"></i></span>
                    <span class="nav-text">Payment Settings</span>
                </a>
            </div> --}}

            <div class="df-nav-item">
                <a href="{{ route('admin.payment-providers.index') }}" class="df-nav-link">
                    <span class="nav-icon"><i class="bi bi-credit-card"></i></span>
                    <span class="nav-text">Payment Providers</span>
                </a>
            </div>

            <div class="df-nav-item">
                <a href="{{ route('admin.delivery-partners.index') }}" class="df-nav-link">
                    <span class="nav-icon"><i class="bi bi-truck"></i></span>
                    <span class="nav-text">Delivery Partners</span>
                </a>
            </div>

            <div class="df-nav-item">
                <a href="{{ route('admin.pages.index') }}" class="df-nav-link">
                    <span class="nav-icon"><i class="bi bi-file-earmark-text"></i></span>
                    <span class="nav-text">Pages</span>
                </a>
            </div>

            <div class="df-nav-item">
                <a href="{{ route('admin.sliders.index') }}" class="df-nav-link">
                    <span class="nav-icon"><i class="bi bi-images"></i></span>
                    <span class="nav-text">Sliders</span>
                </a>
            </div>

            <div class="df-nav-item">
                <a href="{{ route('admin.settings.edit') }}" class="df-nav-link">
                    <span class="nav-icon"><i class="bi bi-gear"></i></span>
                    <span class="nav-text">Settings</span>
                </a>
            </div>
        </div>

        {{-- SUPPORT --}}
        <div class="df-nav-section">
            <div class="df-nav-section-title">Support</div>

            <div class="df-nav-item">
                <a href="{{ url('/') }}" class="df-nav-link">
                    <span class="nav-icon"><i class="bi bi-globe"></i></span>
                    <span class="nav-text">Visit Store</span>
                </a>
            </div>
        </div>

    </nav>
</aside>