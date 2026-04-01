@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-20">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="bg-dark-800 border border-dark-700 p-8 md:p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-green-600/20 border border-green-500 text-green-400 flex items-center justify-center mx-auto mb-5">
                <i class="bi bi-check2-circle text-3xl"></i>
            </div>
            <h1 class="font-heading text-3xl md:text-4xl font-bold uppercase tracking-wide text-white mb-3">Order Confirmed</h1>
            <p class="text-gray-300 mb-8">Thank you. Your order has been placed successfully.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left bg-dark-900 border border-dark-700 p-5 mb-8">
                <div>
                    <div class="text-xs uppercase tracking-widest text-gray-500 mb-1">Order ID</div>
                    <div class="text-white font-semibold">#{{ $order->id }}</div>
                </div>
                <div>
                    <div class="text-xs uppercase tracking-widest text-gray-500 mb-1">Payment Method</div>
                    <div class="text-white font-semibold">{{ strtoupper($order->payment_method ?? 'N/A') }}</div>
                </div>
                <div>
                    <div class="text-xs uppercase tracking-widest text-gray-500 mb-1">Payment Status</div>
                    <div class="text-white font-semibold">{{ strtoupper($order->payment_status ?? 'N/A') }}</div>
                </div>
                <div>
                    <div class="text-xs uppercase tracking-widest text-gray-500 mb-1">Total</div>
                    <div class="text-brand-500 font-semibold">Rs {{ number_format($order->total, 2) }}</div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('orders.show', $order) }}" class="px-8 py-3 text-sm font-heading font-semibold tracking-widest uppercase border border-brand-500 text-brand-500 hover:bg-brand-500 hover:text-white transition-colors inline-flex items-center justify-center gap-2">
                    View Order <i class="bi bi-receipt"></i>
                </a>
                <a href="{{ route('products.index') }}" class="btn-brand px-8 py-3 text-sm tracking-widest inline-flex items-center justify-center gap-2">
                    Continue Shopping <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('home') }}" class="px-8 py-3 text-sm font-heading font-semibold tracking-widest uppercase border border-dark-600 text-white hover:border-brand-500 hover:text-brand-500 transition-colors inline-flex items-center justify-center gap-2">
                    Back to Home <i class="bi bi-house"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection