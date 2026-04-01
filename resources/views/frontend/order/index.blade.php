@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="font-heading text-3xl text-white uppercase tracking-wide">My Orders</h1>
            <a href="{{ route('products.index') }}" class="text-brand-500 uppercase text-sm tracking-widest">Shop More</a>
        </div>

        @if(session('success'))
            <div class="bg-green-600 text-white p-3 mb-4">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="bg-red-600 text-white p-3 mb-4">{{ session('error') }}</div>
        @endif

        <div class="bg-dark-800 border border-dark-700 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-dark-900 text-gray-300 uppercase tracking-widest text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Order</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Payment</th>
                        <th class="px-4 py-3 text-left">Total</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-t border-dark-700">
                            <td class="px-4 py-3 text-white font-semibold">#{{ $order->id }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-gray-200 uppercase">{{ $order->status }}</td>
                            <td class="px-4 py-3 text-gray-200 uppercase">{{ $order->payment_status }}</td>
                            <td class="px-4 py-3 text-brand-500 font-semibold">Rs {{ number_format($order->total, 2) }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('account.orders.show', $order) }}" class="text-brand-500">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
</div>
@endsection