@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-12">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="flex items-center justify-between mb-6">
            <h1 class="font-heading text-3xl text-white uppercase tracking-wide">Order #{{ $order->id }}</h1>
            <a href="{{ route('account.orders') }}" class="text-brand-500 uppercase text-sm tracking-widest">Back to Orders</a>
        </div>

        @if(session('success'))
            <div class="bg-green-600 text-white p-3 mb-4">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="bg-red-600 text-white p-3 mb-4">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-dark-800 border border-dark-700 p-6">
                <h2 class="font-heading text-xl text-white uppercase tracking-wide mb-4">Items</h2>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between border-b border-dark-700 pb-3">
                            <div>
                                <div class="text-white font-semibold">{{ $item->product_name }}</div>
                                <div class="text-gray-400 text-sm">Qty: {{ $item->quantity }}</div>
                            </div>
                            <div class="text-brand-500">Rs {{ number_format($item->line_total, 2) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-dark-800 border border-dark-700 p-6">
                <h2 class="font-heading text-xl text-white uppercase tracking-wide mb-4">Summary</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-300"><span>Status</span><span class="uppercase">{{ $order->status }}</span></div>
                    <div class="flex justify-between text-gray-300"><span>Payment</span><span class="uppercase">{{ $order->payment_status }}</span></div>
                    <div class="flex justify-between text-gray-300"><span>Method</span><span class="uppercase">{{ $order->payment_method }}</span></div>
                    <div class="flex justify-between text-gray-300"><span>Refund</span><span class="uppercase">{{ $order->refund_status }}</span></div>
                    <div class="flex justify-between text-white font-semibold pt-2 border-t border-dark-700"><span>Total</span><span>Rs {{ number_format($order->total, 2) }}</span></div>
                </div>

                @if(in_array($order->status, ['pending','processing']))
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="mt-5 space-y-3">
                        @csrf
                        <textarea name="reason" rows="2" class="w-full bg-dark-900 border border-dark-700 text-white p-2 text-sm" placeholder="Reason (optional)"></textarea>
                        <button type="submit" class="w-full border border-red-500 text-red-400 py-2 uppercase tracking-widest text-xs hover:bg-red-500 hover:text-white" onclick="return confirm('Cancel this order?')">Cancel Order</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection