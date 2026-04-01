@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-16">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 bg-dark-800 border border-dark-700 overflow-hidden">
            <div class="p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-dark-700">
                <p class="text-brand-500 uppercase tracking-widest text-xs mb-3">Welcome Back</p>
                <h1 class="font-heading text-4xl text-white uppercase leading-tight mb-4">Login To Your Account</h1>
                <p class="text-gray-400 mb-6">Access your orders, wishlist, and account details from one place.</p>

                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-start gap-2"><i class="bi bi-check-circle text-brand-500"></i><span>Track your recent and past orders.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-check-circle text-brand-500"></i><span>Manage cart and checkout faster.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-check-circle text-brand-500"></i><span>Save your favorite products in wishlist.</span></li>
                </ul>
            </div>

            <div class="p-8 lg:p-10">
                @if(session('error'))
                    <div class="mb-4 bg-red-600 text-white p-3 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('status'))
                    <div class="mb-4 bg-green-600 text-white p-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-600 text-white p-3 text-sm">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label for="password" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="Enter your password">
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label class="inline-flex items-center text-sm text-gray-300 gap-2">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="accent-brand-500">
                            <span>Remember Me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-brand-500 hover:text-white text-sm">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-brand w-full py-3">Login</button>
                </form>

                <p class="text-gray-400 text-sm mt-5">
                    New customer?
                    <a href="{{ route('register') }}" class="text-brand-500 hover:text-white">Create an account</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
