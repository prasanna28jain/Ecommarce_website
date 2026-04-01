@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-16">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 bg-dark-800 border border-dark-700 overflow-hidden">
            <div class="p-8 lg:p-10 border-b lg:border-b-0 lg:border-r border-dark-700">
                <p class="text-brand-500 uppercase tracking-widest text-xs mb-3">Security Check</p>
                <h1 class="font-heading text-4xl text-white uppercase leading-tight mb-4">Confirm Your Password</h1>
                <p class="text-gray-400 mb-6">For your account safety, please confirm your current password before continuing.</p>

                <ul class="space-y-3 text-sm text-gray-300">
                    <li class="flex items-start gap-2"><i class="bi bi-shield-lock text-brand-500"></i><span>Extra verification for sensitive actions.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-person-lock text-brand-500"></i><span>Protects your account settings and data.</span></li>
                    <li class="flex items-start gap-2"><i class="bi bi-check2-circle text-brand-500"></i><span>Fast confirmation with one step.</span></li>
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

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="password" class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Current Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500"
                               placeholder="Enter current password">
                    </div>

                    <button type="submit" class="btn-brand w-full py-3">Confirm Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
