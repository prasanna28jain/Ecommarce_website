@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-12">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="flex items-center justify-between mb-6">
            <h1 class="font-heading text-3xl text-white uppercase tracking-wide">Profile</h1>
            <a href="{{ route('account.index') }}" class="text-brand-500 uppercase text-sm tracking-widest">Back to Account</a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-600 text-white p-3">{{ session('success') }}</div>
        @endif

        @if(session('success_password'))
            <div class="mb-4 bg-green-600 text-white p-3">{{ session('success_password') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-dark-800 border border-dark-700 p-6">
                <h2 class="font-heading text-xl text-white uppercase tracking-wide mb-4">Account Information</h2>

                <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500">
                        @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500">
                        @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-brand px-6 py-3">Save Profile</button>
                </form>
            </div>

            <div class="bg-dark-800 border border-dark-700 p-6">
                <h2 class="font-heading text-xl text-white uppercase tracking-wide mb-4">Change Password</h2>

                <form action="{{ route('account.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Current Password</label>
                        <input type="password" name="current_password" class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500">
                        @error('current_password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-widest mb-2">New Password</label>
                        <input type="password" name="password" class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500">
                        @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-widest mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full bg-dark-900 border border-dark-700 text-white p-3 focus:outline-none focus:border-brand-500">
                    </div>

                    <button type="submit" class="btn-brand px-6 py-3">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
