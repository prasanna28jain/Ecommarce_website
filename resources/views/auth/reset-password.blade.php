@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-16">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 bg-dark-800 border border-dark-700 overflow-hidden">
            <div class="p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-dark-700">
                <p class="text-brand-500 uppercase tracking-widest text-xs mb-3">Set New Password</p>
                <h1 class="font-heading text-4xl text-white uppercase leading-tight mb-4">Reset Your Password</h1>
                <p class="text-gray-400 mb-6">Create a new secure password to continue using your account safely.</p>

                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-start gap-2"><i class="bi bi-shield-check text-brand-500"></i><span>Token-based secure password reset.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-lock text-brand-500"></i><span>Use a strong password for better protection.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-person-check text-brand-500"></i><span>Get back to your orders and wishlist quickly.</span></li>
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

                <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label for="email" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label for="password" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">New Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="Enter new password">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="Re-enter new password">
                    </div>

                    <button type="submit" class="btn-brand w-full py-3">Reset Password</button>
                </form>

                <p class="text-gray-400 text-sm mt-5">
                    Remembered your password?
                    <a href="{{ route('login') }}" class="text-brand-500 hover:text-white">Back to login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
