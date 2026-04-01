<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boxima - Fitness & Gym Equipment</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite('resources/css/app.css')
    
    <style>
        body { background-color: #0f0f0f; color: #f5f5f5; }
        .hero-banner {
            background-image: linear-gradient(rgba(15, 15, 15, 0.7), rgba(15, 15, 15, 0.9)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2940&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
        .btn-brand {
            background-color: #E63946;
            color: white;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-family: 'Oswald', sans-serif;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .btn-brand:hover {
            background-color: #D62828;
            transform: translateY(-2px);
        }
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(230, 57, 70, 0.15);
        }
        .badge-hot {
            background-color: #E63946;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 2px 6px;
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body class="antialiased flex flex-col min-h-screen">

    <!-- Topbar -->
    <div class="bg-brand-500 text-white py-2 text-xs font-semibold tracking-wider font-heading">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div>
                <i class="bi bi-truck mr-1"></i> FREE SHIPPING ON ORDERS OVER $500
            </div>
            <div class="flex gap-4">
                @if(optional($appSetting)->facebook_url)
                    <a href="{{ $appSetting->facebook_url }}" class="hover:text-gray-200" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook"></i></a>
                @endif
                @if(optional($appSetting)->instagram_url)
                    <a href="{{ $appSetting->instagram_url }}" class="hover:text-gray-200" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>
                @endif
                @if(optional($appSetting)->twitter_url)
                    <a href="{{ $appSetting->twitter_url }}" class="hover:text-gray-200" target="_blank" rel="noopener noreferrer"><i class="bi bi-twitter"></i></a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-dark-900 border-b border-dark-800 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-3xl font-heading font-bold text-white tracking-widest uppercase">
                BOX<span class="text-brand-500">IMA</span>
            </a>

            <!-- Navigation -->
            <nav class="hidden md:flex gap-8 font-heading text-lg font-medium text-gray-300">
                <a href="{{ route('home') }}" class="hover:text-brand-500 transition-colors {{ request()->routeIs('home') ? 'text-brand-500' : '' }}">Home</a>
                <a href="{{ route('products.index') }}" class="hover:text-brand-500 transition-colors {{ request()->routeIs('products.*') ? 'text-brand-500' : '' }}">Equipment</a>
                <a href="{{ route('categories.index') }}" class="hover:text-brand-500 transition-colors {{ request()->routeIs('categories.*') ? 'text-brand-500' : '' }}">Categories</a>
                <a href="{{ route('brands.index') }}" class="hover:text-brand-500 transition-colors {{ request()->routeIs('brands.*') ? 'text-brand-500' : '' }}">Brands</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-6">
                <a href="#" class="text-gray-300 hover:text-brand-500 text-xl"><i class="bi bi-search"></i></a>
                @auth
                    @if(auth()->user()->hasRole('admin') || auth()->user()->can('access admin'))
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-brand-500 font-heading tracking-wide uppercase text-sm">Admin Panel</a>
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-brand-500 text-xl"><i class="bi bi-person-circle"></i></a>
                    @else
                        <a href="{{ route('account.orders') }}" class="text-gray-300 hover:text-brand-500 font-heading tracking-wide uppercase text-sm">My Orders</a>
                        <a href="{{ route('account.index') }}" class="text-gray-300 hover:text-brand-500 text-xl"><i class="bi bi-person-circle"></i></a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-brand-500 font-heading tracking-wide uppercase text-sm">Login</a>
                @endauth
                <a href="{{ auth()->check() ? route('wishlist.index') : route('login') }}" class="text-gray-300 hover:text-brand-500 text-xl relative" title="Wishlist">
                    <i class="bi bi-heart"></i>
                    <span class="absolute -top-2 -right-2 bg-brand-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">{{ $headerWishlistCount ?? 0 }}</span>
                </a>
                <a href="{{ auth()->check() ? route('cart.index') : route('login') }}" class="text-gray-300 hover:text-brand-500 text-xl relative">
                    <i class="bi bi-cart3"></i>
                    <span class="absolute -top-2 -right-2 bg-brand-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">{{ $headerCartCount ?? 0 }}</span>
                </a>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-300 text-2xl"><i class="bi bi-list"></i></button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#0a0a0a] border-t border-dark-800 pt-16 mt-auto">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-12 pb-12">
            <div>
                <a href="{{ route('home') }}" class="text-3xl font-heading font-bold text-white tracking-widest uppercase mb-6 inline-block">
                    BOX<span class="text-brand-500">IMA</span>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    The ultimate destination for premium gym and fitness equipment. We provide top-tier gear for athletes and fitness enthusiasts worldwide.
                </p>
                <div class="flex gap-4">
                    @if(optional($appSetting)->facebook_url)
                        <a href="{{ $appSetting->facebook_url }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded bg-dark-800 flex items-center justify-center text-gray-400 hover:bg-brand-500 hover:text-white transition-all"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if(optional($appSetting)->instagram_url)
                        <a href="{{ $appSetting->instagram_url }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded bg-dark-800 flex items-center justify-center text-gray-400 hover:bg-brand-500 hover:text-white transition-all"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if(optional($appSetting)->youtube_url)
                        <a href="{{ $appSetting->youtube_url }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded bg-dark-800 flex items-center justify-center text-gray-400 hover:bg-brand-500 hover:text-white transition-all"><i class="bi bi-youtube"></i></a>
                    @endif
                    @if(optional($appSetting)->linkedin_url)
                        <a href="{{ $appSetting->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded bg-dark-800 flex items-center justify-center text-gray-400 hover:bg-brand-500 hover:text-white transition-all"><i class="bi bi-linkedin"></i></a>
                    @endif
                </div>
            </div>
            
            <div>
                <h4 class="font-heading text-xl text-white mb-6 uppercase tracking-wider">Quick Links</h4>
                <ul class="space-y-3 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-500 transition-colors">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-brand-500 transition-colors">Shop Everything</a></li>
                    <li><a href="{{ auth()->check() ? route('wishlist.index') : route('login') }}" class="hover:text-brand-500 transition-colors">Wishlist</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition-colors">About Us</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition-colors">Contact</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-heading text-xl text-white mb-6 uppercase tracking-wider">Customer Service</h4>
                <ul class="space-y-3 text-gray-400">
                    <li><a href="#" class="hover:text-brand-500 transition-colors">Shipping & Returns</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition-colors">FAQ</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition-colors">Track Order</a></li>
                    <li><a href="#" class="hover:text-brand-500 transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-heading text-xl text-white mb-6 uppercase tracking-wider">Newsletter</h4>
                <p class="text-gray-400 text-sm mb-4">Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.</p>
                <form class="flex">
                    <input type="email" placeholder="Enter your email" class="bg-dark-800 border border-dark-700 text-white px-4 py-2 w-full focus:outline-none focus:border-brand-500">
                    <button type="button" class="btn-brand px-4 py-2"><i class="bi bi-envelope"></i></button>
                </form>
            </div>
        </div>
        <div class="bg-black py-4 border-t border-dark-800">
            <div class="container mx-auto px-4 text-center text-gray-500 text-sm font-heading tracking-wide">
                &copy; {{ date('Y') }} BOXIMA FITNESS EQUIPMENT. ALL RIGHTS RESERVED.
            </div>
        </div>
    </footer>

    @stack('scripts')

    <a href="https://api.whatsapp.com/send/?phone=919324472262&text&type=phone_number&app_absent=0"
       target="_blank"
       rel="noopener noreferrer"
         class="w-12 h-12 rounded-full bg-[#25D366] text-white flex items-center justify-center shadow-lg hover:scale-105 transition-transform"
         style="position: fixed; right: 20px; bottom: 20px; top: auto; left: auto; z-index: 9999;"
       title="Chat on WhatsApp"
       aria-label="Chat on WhatsApp">
        <i class="bi bi-whatsapp text-2xl"></i>
    </a>

</body>
</html>
