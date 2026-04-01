@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-16">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 bg-dark-800 border border-dark-700 overflow-hidden">
            <div class="p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-dark-700">
                <p class="text-brand-500 uppercase tracking-widest text-xs mb-3">Email Verification</p>
                <h1 class="font-heading text-4xl text-white uppercase leading-tight mb-4">Verify Your Email</h1>
                <p class="text-gray-400 mb-6">We sent a verification link to your inbox. Click the link to activate your account.</p>

                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-start gap-2"><i class="bi bi-envelope-check text-brand-500"></i><span>One-click verification from email.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-shield-check text-brand-500"></i><span>Helps protect your account from misuse.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-arrow-repeat text-brand-500"></i><span>You can resend the link anytime.</span></li>
                </ul>
            </div>

            <div class="p-8 lg:p-10">
                <div class="mb-4 text-sm text-gray-300">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 bg-green-600 text-white p-3 text-sm">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between mt-6">
                    <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="btn-brand w-full sm:w-auto px-6 py-3">Resend Verification Email</button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto border border-dark-600 text-gray-200 px-6 py-3 hover:border-brand-500 hover:text-white transition-colors">Log Out</button>
                    </form>
                </div>

                <p class="text-gray-400 text-sm mt-5">
                    Verified already?
                    <a href="{{ route('login') }}" class="text-brand-500 hover:text-white">Go to login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
