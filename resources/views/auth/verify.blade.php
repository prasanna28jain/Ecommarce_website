@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-16">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 bg-dark-800 border border-dark-700 overflow-hidden">
            <div class="p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-dark-700">
                <p class="text-brand-500 uppercase tracking-widest text-xs mb-3">Email Verification</p>
                <h1 class="font-heading text-4xl text-white uppercase leading-tight mb-4">Verify Your Email Address</h1>
                <p class="text-gray-400 mb-6">Please verify your email to unlock full account access and secure your profile.</p>

                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-start gap-2"><i class="bi bi-envelope-check text-brand-500"></i><span>Check your inbox for the verification link.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-shield-check text-brand-500"></i><span>Verification protects your account from misuse.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-arrow-repeat text-brand-500"></i><span>You can resend the email if needed.</span></li>
                </ul>
            </div>

            <div class="p-8 lg:p-10">
                @if (session('resent') || session('status') === 'verification-link-sent')
                    <div class="mb-4 bg-green-600 text-white p-3 text-sm" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <p class="text-gray-300 text-sm mb-6">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                </p>

                <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn-brand w-full py-3">Resend Verification Email</button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full border border-dark-600 text-gray-200 px-6 py-3 hover:border-brand-500 hover:text-white transition-colors">Log Out</button>
                </form>

                <p class="text-gray-400 text-sm mt-5">
                    Already verified?
                    <a href="{{ route('login') }}" class="text-brand-500 hover:text-white">Go to login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
