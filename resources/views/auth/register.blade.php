@extends('layouts.frontend')

@section('title', 'Create Account | XRT65 Fitness')

@section('content')
<section style="background: linear-gradient(100deg, #131313 1.15%, #022C2B 100%); min-height: 85vh; display: flex; align-items: center; padding: 60px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="row g-0 overflow-hidden" style="border-radius:16px; box-shadow: 0 24px 60px rgba(0,0,0,0.5);">

                    {{-- LEFT PANEL --}}
                    <div class="col-lg-5 d-flex flex-column justify-content-between"
                         style="background: linear-gradient(135deg, #022C2B 0%, #017075 100%); padding: 50px 40px; position:relative; overflow:hidden;">
                        <div style="position:absolute; width:300px; height:300px; border-radius:50%; background:rgba(0,229,255,0.05); top:-80px; right:-80px; pointer-events:none;"></div>
                        <div style="position:absolute; width:200px; height:200px; border-radius:50%; background:rgba(0,229,255,0.06); bottom:-60px; left:-60px; pointer-events:none;"></div>

                        <div>
                            <a href="{{ route('home') }}" class="d-inline-block mb-4">
                                <img src="{{ asset('frontend/images/XRT65.png') }}" alt="XRT65" height="42"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <span style="display:none; font-size:1.6rem; font-weight:900; letter-spacing:2px; color:#fff;">BOX<span style="color:#00e5ff;">IMA</span></span>
                            </a>

                            <p style="color:#00e5ff; font-size:0.75rem; letter-spacing:3px; text-transform:uppercase; font-weight:600;" class="mb-2">Join XRT65</p>
                            <h1 style="color:#fff; font-size:1.9rem; font-weight:900; line-height:1.2;" class="mb-3">Create Your<br>Account</h1>
                            <p style="color:rgba(255,255,255,0.6); font-size:0.9rem;" class="mb-4">
                                Register as a customer to place orders, track deliveries, and manage your wishlist.
                            </p>

                            <ul style="list-style:none; padding:0; margin:0;" class="d-flex flex-column gap-3">
                                <li class="d-flex align-items-start gap-2" style="color:rgba(255,255,255,0.8); font-size:0.9rem;">
                                    <i class="bi bi-check-circle-fill" style="color:#00e5ff; margin-top:2px;"></i>
                                    Fast checkout with saved details.
                                </li>
                                <li class="d-flex align-items-start gap-2" style="color:rgba(255,255,255,0.8); font-size:0.9rem;">
                                    <i class="bi bi-check-circle-fill" style="color:#00e5ff; margin-top:2px;"></i>
                                    Order history and tracking in one place.
                                </li>
                                <li class="d-flex align-items-start gap-2" style="color:rgba(255,255,255,0.8); font-size:0.9rem;">
                                    <i class="bi bi-check-circle-fill" style="color:#00e5ff; margin-top:2px;"></i>
                                    Save products to your wishlist.
                                </li>
                                <li class="d-flex align-items-start gap-2" style="color:rgba(255,255,255,0.8); font-size:0.9rem;">
                                    <i class="bi bi-check-circle-fill" style="color:#00e5ff; margin-top:2px;"></i>
                                    Exclusive member offers and deals.
                                </li>
                            </ul>
                        </div>

                        <div class="text-center mt-4 d-none d-lg-block">
                            <img src="{{ asset('frontend/images/home-gym-kit.png') }}" alt="Equipment"
                                 style="max-height:140px; object-fit:contain; filter:drop-shadow(0 10px 20px rgba(0,229,255,0.3)); opacity:0.85;">
                        </div>
                    </div>

                    {{-- RIGHT PANEL (FORM) --}}
                    <div class="col-lg-7" style="background:#fff; padding: 50px 45px;">

                        <h2 style="font-size:1.5rem; font-weight:900; color:#0D0D0D; letter-spacing:1px;" class="mb-1">Create Account</h2>
                        <p style="color:#6C757D; font-size:0.9rem;" class="mb-4">Already have an account?
                            <a href="{{ route('login') }}" style="color:#017075; font-weight:600;">Sign in here</a>
                        </p>

                        @if($errors->any())
                            <div class="alert alert-danger py-2 mb-3" style="font-size:0.875rem;">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1.5px; font-weight:700; color:#6C757D;" class="form-label">Full Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}"
                                       required autocomplete="name" autofocus
                                       class="form-control"
                                       style="border:1.5px solid #DEE2E6; border-radius:8px; padding:12px 16px; font-size:0.95rem; background:#f9f9f9; transition:border-color 0.3s;"
                                       onfocus="this.style.borderColor='#017075'; this.style.background='#fff';"
                                       onblur="this.style.borderColor='#DEE2E6'; this.style.background='#f9f9f9';"
                                       placeholder="Enter your full name">
                            </div>

                            <div class="mb-3">
                                <label for="email" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1.5px; font-weight:700; color:#6C757D;" class="form-label">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                       required autocomplete="email"
                                       class="form-control"
                                       style="border:1.5px solid #DEE2E6; border-radius:8px; padding:12px 16px; font-size:0.95rem; background:#f9f9f9; transition:border-color 0.3s;"
                                       onfocus="this.style.borderColor='#017075'; this.style.background='#fff';"
                                       onblur="this.style.borderColor='#DEE2E6'; this.style.background='#f9f9f9';"
                                       placeholder="you@example.com">
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <label for="password" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1.5px; font-weight:700; color:#6C757D;" class="form-label">Password</label>
                                    <div style="position:relative;">
                                        <input id="password" type="password" name="password"
                                               required autocomplete="new-password"
                                               class="form-control"
                                               style="border:1.5px solid #DEE2E6; border-radius:8px; padding:12px 45px 12px 16px; font-size:0.95rem; background:#f9f9f9; transition:border-color 0.3s;"
                                               onfocus="this.style.borderColor='#017075'; this.style.background='#fff';"
                                               onblur="this.style.borderColor='#DEE2E6'; this.style.background='#f9f9f9';"
                                               placeholder="Create password">
                                        <button type="button" onclick="togglePass('password', 'eye1')"
                                                style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; color:#6C757D; cursor:pointer;">
                                            <i class="bi bi-eye" id="eye1"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="password_confirmation" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1.5px; font-weight:700; color:#6C757D;" class="form-label">Confirm Password</label>
                                    <div style="position:relative;">
                                        <input id="password_confirmation" type="password" name="password_confirmation"
                                               required autocomplete="new-password"
                                               class="form-control"
                                               style="border:1.5px solid #DEE2E6; border-radius:8px; padding:12px 45px 12px 16px; font-size:0.95rem; background:#f9f9f9; transition:border-color 0.3s;"
                                               onfocus="this.style.borderColor='#017075'; this.style.background='#fff';"
                                               onblur="this.style.borderColor='#DEE2E6'; this.style.background='#f9f9f9';"
                                               placeholder="Confirm password">
                                        <button type="button" onclick="togglePass('password_confirmation', 'eye2')"
                                                style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; color:#6C757D; cursor:pointer;">
                                            <i class="bi bi-eye" id="eye2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn-xrt btn-teal-xrt w-100 justify-content-center" style="border-radius:8px;">
                                <i class="bi bi-person-plus me-2"></i> Create Account
                            </button>
                        </form>

                        <div style="margin-top:24px; padding-top:24px; border-top:1px solid #f0f0f0; text-align:center;">
                            <p style="color:#6C757D; font-size:0.8rem; margin:0;">
                                By creating an account, you agree to our
                                <a href="#" style="color:#017075;">Terms of Service</a> &
                                <a href="#" style="color:#017075;">Privacy Policy</a>
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
