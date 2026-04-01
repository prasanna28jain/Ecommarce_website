@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-16">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 bg-dark-800 border border-dark-700 overflow-hidden">
            <div class="p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-dark-700">
                <p class="text-brand-500 uppercase tracking-widest text-xs mb-3">Password Recovery</p>
                <h1 class="font-heading text-4xl text-white uppercase leading-tight mb-4">Forgot Password?</h1>
                <p class="text-gray-400 mb-6">Enter your account email and we will send you a secure reset link.</p>

                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-start gap-2"><i class="bi bi-shield-lock text-brand-500"></i><span>Secure one-time reset token via email.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-clock-history text-brand-500"></i><span>Quick access back to your account.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-person-check text-brand-500"></i><span>Your customer profile and orders stay safe.</span></li>
                </ul>
            </div>

            <div class="p-8 lg:p-10">
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

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="you@example.com">
                    </div>

                    <button type="submit" class="btn-brand w-full py-3">Send Reset Link</button>
                </form>

                <p class="text-gray-400 text-sm mt-5">
                    Remember your password?
                    <a href="{{ route('login') }}" class="text-brand-500 hover:text-white">Back to login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
