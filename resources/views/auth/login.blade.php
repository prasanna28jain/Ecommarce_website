@extends('layouts.frontend')

@section('title', 'Login | XRT65 Fitness')

@section('content')
<section style="background: linear-gradient(100deg, #131313 1.15%, #022C2B 100%); min-height: 80vh; display: flex; align-items: center; padding: 60px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="row g-0 overflow-hidden" style="border-radius:16px; box-shadow: 0 24px 60px rgba(0,0,0,0.5);">

                    {{-- LEFT PANEL --}}
                    <div class="col-lg-5 d-flex flex-column justify-content-between"
                         style="background: linear-gradient(135deg, #022C2B 0%, #017075 100%); padding: 50px 40px; position:relative; overflow:hidden;">
                        {{-- Decorative circle --}}
                        <div style="position:absolute; width:300px; height:300px; border-radius:50%; background:rgba(0,229,255,0.05); top:-80px; right:-80px; pointer-events:none;"></div>
                        <div style="position:absolute; width:200px; height:200px; border-radius:50%; background:rgba(0,229,255,0.06); bottom:-60px; left:-60px; pointer-events:none;"></div>

                        <div>
                            {{-- Logo --}}
                            <a href="{{ route('home') }}" class="d-inline-block mb-4">
                                <img src="{{ asset('frontend/images/XRT65.png') }}" alt="XRT65" height="42"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <span style="display:none; font-size:1.6rem; font-weight:900; letter-spacing:2px; color:#fff;">BOX<span style="color:#00e5ff;">IMA</span></span>
                            </a>

                            <p style="color:#00e5ff; font-size:0.75rem; letter-spacing:3px; text-transform:uppercase; font-weight:600;" class="mb-2">Welcome Back</p>
                            <h1 style="color:#fff; font-size:1.9rem; font-weight:900; line-height:1.2;" class="mb-3">Login To Your<br>Account</h1>
                            <p style="color:rgba(255,255,255,0.6); font-size:0.9rem;" class="mb-4">
                                Access your orders, wishlist, and account details from one place.
                            </p>

                            <ul style="list-style:none; padding:0; margin:0;" class="d-flex flex-column gap-3">
                                <li class="d-flex align-items-start gap-2" style="color:rgba(255,255,255,0.8); font-size:0.9rem;">
                                    <i class="bi bi-check-circle-fill" style="color:#00e5ff; margin-top:2px;"></i>
                                    Track your recent and past orders.
                                </li>
                                <li class="d-flex align-items-start gap-2" style="color:rgba(255,255,255,0.8); font-size:0.9rem;">
                                    <i class="bi bi-check-circle-fill" style="color:#00e5ff; margin-top:2px;"></i>
                                    Manage cart and checkout faster.
                                </li>
                                <li class="d-flex align-items-start gap-2" style="color:rgba(255,255,255,0.8); font-size:0.9rem;">
                                    <i class="bi bi-check-circle-fill" style="color:#00e5ff; margin-top:2px;"></i>
                                    Save your favorite products in wishlist.
                                </li>
                            </ul>
                        </div>

                        {{-- Bottom product image --}}
                        <div class="text-center mt-4 d-none d-lg-block">
                            <img src="{{ asset('frontend/images/dumbbell.png') }}" alt="Equipment"
                                 style="max-height:160px; object-fit:contain; filter:drop-shadow(0 10px 20px rgba(0,229,255,0.3)); opacity:0.85;">
                        </div>
                    </div>

                    {{-- RIGHT PANEL (FORM) --}}
                    <div class="col-lg-7" style="background:#fff; padding: 50px 45px;">

                        <h2 style="font-size:1.5rem; font-weight:900; color:#0D0D0D; letter-spacing:1px;" class="mb-1">Sign In</h2>
                        <p style="color:#6C757D; font-size:0.9rem;" class="mb-4">Don't have an account?
                            <a href="{{ route('register') }}" style="color:#017075; font-weight:600;">Create one free</a>
                        </p>

                        {{-- Alerts --}}
                        @if(session('error'))
                            <div class="alert alert-danger py-2 mb-3" style="font-size:0.875rem;">{{ session('error') }}</div>
                        @endif
                        @if(session('status'))
                            <div class="alert alert-success py-2 mb-3" style="font-size:0.875rem;">{{ session('status') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger py-2 mb-3" style="font-size:0.875rem;">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1.5px; font-weight:700; color:#6C757D;" class="form-label">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                       required autocomplete="email" autofocus
                                       class="form-control"
                                       style="border:1.5px solid #DEE2E6; border-radius:8px; padding:12px 16px; font-size:0.95rem; color:#0D0D0D; background:#f9f9f9; transition:border-color 0.3s;"
                                       onfocus="this.style.borderColor='#017075'; this.style.background='#fff';"
                                       onblur="this.style.borderColor='#DEE2E6'; this.style.background='#f9f9f9';"
                                       placeholder="you@example.com">
                            </div>

                            <div class="mb-3">
                                <label for="password" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1.5px; font-weight:700; color:#6C757D;" class="form-label">Password</label>
                                <div style="position:relative;">
                                    <input id="password" type="password" name="password"
                                           required autocomplete="current-password"
                                           class="form-control"
                                           style="border:1.5px solid #DEE2E6; border-radius:8px; padding:12px 45px 12px 16px; font-size:0.95rem; color:#0D0D0D; background:#f9f9f9; transition:border-color 0.3s;"
                                           onfocus="this.style.borderColor='#017075'; this.style.background='#fff';"
                                           onblur="this.style.borderColor='#DEE2E6'; this.style.background='#f9f9f9';"
                                           placeholder="Enter your password">
                                    <button type="button" onclick="togglePass('password', 'eyeIcon1')"
                                            style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; color:#6C757D; cursor:pointer; font-size:1rem;">
                                        <i class="bi bi-eye" id="eyeIcon1"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <label class="d-flex align-items-center gap-2" style="font-size:0.875rem; color:#495057; cursor:pointer;">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                           style="accent-color:#017075; width:16px; height:16px;">
                                    Remember Me
                                </label>
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" style="color:#017075; font-size:0.875rem; font-weight:600; text-decoration:none;">Forgot Password?</a>
                                @endif
                            </div>

                            <button type="submit" class="btn-xrt btn-teal-xrt w-100 justify-content-center" style="border-radius:8px;">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                            </button>
                        </form>

                        <div style="margin-top:24px; padding-top:24px; border-top:1px solid #f0f0f0; text-align:center;">
                            <p style="color:#6C757D; font-size:0.875rem; margin:0;">
                                New customer?
                                <a href="{{ route('register') }}" style="color:#017075; font-weight:700; text-decoration:none;">Create an account →</a>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function togglePass(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endpush
