@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-16">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 bg-dark-800 border border-dark-700 overflow-hidden">
            <div class="p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-dark-700">
                <p class="text-brand-500 uppercase tracking-widest text-xs mb-3">Join Boxima</p>
                <h1 class="font-heading text-4xl text-white uppercase leading-tight mb-4">Create Your Account</h1>
                <p class="text-gray-400 mb-6">Register as a customer to place orders, track deliveries, and manage your wishlist.</p>

                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-start gap-2"><i class="bi bi-check-circle text-brand-500"></i><span>Fast checkout with saved details.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-check-circle text-brand-500"></i><span>Order history and tracking in one place.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-check-circle text-brand-500"></i><span>Save products to your wishlist.</span></li>
                </ul>
            </div>

            <div class="p-8 lg:p-10">
                @if($errors->any())
                    <div class="mb-4 bg-red-600 text-white p-3 text-sm">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Full Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="Enter your full name">
                    </div>

                    <div>
                        <label for="email" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label for="password" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="Choose a secure password">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="Re-enter your password">
                    </div>

                    <button type="submit" class="btn-brand w-full py-3">Create Account</button>
                </form>

                <p class="text-gray-400 text-sm mt-5">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-brand-500 hover:text-white">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
