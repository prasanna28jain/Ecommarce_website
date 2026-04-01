@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        @if(session('error'))
            <div class="mb-4 bg-red-600 text-white p-3">{{ session('error') }}</div>
        @endif

        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h1 class="font-heading text-3xl text-white uppercase tracking-wide">My Account</h1>
                <p class="text-gray-400 mt-2">Welcome back, {{ $user->name }}.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-brand-500 uppercase text-sm tracking-widest">Continue Shopping</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-dark-800 border border-dark-700 p-5">
                <p class="text-gray-400 text-xs uppercase tracking-widest">Total Orders</p>
                <p class="text-3xl text-white font-heading mt-2">{{ $stats['total_orders'] }}</p>
            </div>
            <div class="bg-dark-800 border border-dark-700 p-5">
                <p class="text-gray-400 text-xs uppercase tracking-widest">Active Orders</p>
                <p class="text-3xl text-white font-heading mt-2">{{ $stats['pending_orders'] }}</p>
            </div>
            <div class="bg-dark-800 border border-dark-700 p-5">
                <p class="text-gray-400 text-xs uppercase tracking-widest">Delivered</p>
                <p class="text-3xl text-white font-heading mt-2">{{ $stats['completed_orders'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-dark-800 border border-dark-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-heading text-xl text-white uppercase tracking-wide">Recent Orders</h2>
                    <a href="{{ route('account.orders') }}" class="text-brand-500 text-xs uppercase tracking-widest">View All</a>
                </div>

                @if($recentOrders->isEmpty())
                    <p class="text-gray-400">You have not placed any orders yet.</p>
                @else
                    <div class="space-y-3">
                        @foreach($recentOrders as $order)
                            <div class="border border-dark-700 bg-dark-900 p-4 flex items-center justify-between">
                                <div>
                                    <p class="text-white font-semibold">Order #{{ $order->id }}</p>
                                    <p class="text-gray-400 text-sm">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-300 text-xs uppercase">{{ $order->status }}</p>
                                    <p class="text-brand-500 font-semibold">Rs {{ number_format($order->total, 2) }}</p>
                                </div>
                                <a href="{{ route('account.orders.show', $order) }}" class="text-brand-500 text-sm">Details</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-dark-800 border border-dark-700 p-6">
                <h2 class="font-heading text-xl text-white uppercase tracking-wide mb-4">Quick Links</h2>
                <div class="space-y-3 text-sm">
                    <a href="{{ route('account.profile') }}" class="block border border-dark-700 px-4 py-3 text-gray-200 hover:border-brand-500 hover:text-white transition-colors">Profile Settings</a>
                    <a href="{{ route('account.orders') }}" class="block border border-dark-700 px-4 py-3 text-gray-200 hover:border-brand-500 hover:text-white transition-colors">Order History</a>
                    <a href="{{ route('wishlist.index') }}" class="block border border-dark-700 px-4 py-3 text-gray-200 hover:border-brand-500 hover:text-white transition-colors">Wishlist</a>
                    <a href="{{ route('cart.index') }}" class="block border border-dark-700 px-4 py-3 text-gray-200 hover:border-brand-500 hover:text-white transition-colors">Cart</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left border border-red-500/60 px-4 py-3 text-red-300 hover:bg-red-500 hover:text-white transition-colors">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
