@extends('layouts.frontend')

@section('content')
<div class="bg-dark-900 py-10 border-b border-dark-800">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-heading font-bold uppercase tracking-wide text-white">Checkout</h1>
        <p class="text-gray-400 mt-2">Complete your order with secure payment options.</p>
    </div>
</div>

<div class="bg-dark-900 py-12">
    <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            @if(session('error'))
                <div class="bg-red-600 text-white p-4 mb-6 text-sm font-heading uppercase tracking-wide">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="bg-green-700/60 border border-green-500 text-white p-4 mb-6 text-sm font-heading uppercase tracking-wide">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="bg-red-700/60 border border-red-500 text-white p-4 mb-6">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!$codProvider && !$razorpayProvider)
                <div class="bg-yellow-700/50 border border-yellow-500 text-yellow-100 p-4">
                    No payment method is active. Please contact admin.
                </div>
            @else
                <form id="checkout-form" action="{{ route('checkout.place') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="bg-dark-800 border border-dark-700 p-6">
                        <h2 class="font-heading text-xl text-white uppercase tracking-wide mb-4">Billing Address</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="billing_name" value="{{ old('billing_name', $user->name) }}" placeholder="Full Name" class="bg-dark-900 border border-dark-700 text-white px-4 py-3" required>
                            <input type="email" name="billing_email" value="{{ old('billing_email', $user->email) }}" placeholder="Email" class="bg-dark-900 border border-dark-700 text-white px-4 py-3" required>
                            <input type="text" name="billing_phone" value="{{ old('billing_phone') }}" placeholder="Phone" class="bg-dark-900 border border-dark-700 text-white px-4 py-3" required>
                            <input type="text" name="billing_line1" value="{{ old('billing_line1') }}" placeholder="Address Line" class="bg-dark-900 border border-dark-700 text-white px-4 py-3" required>
                            <input type="text" name="billing_city" value="{{ old('billing_city') }}" placeholder="City" class="bg-dark-900 border border-dark-700 text-white px-4 py-3" required>
                            <input type="text" name="billing_state" value="{{ old('billing_state') }}" placeholder="State" class="bg-dark-900 border border-dark-700 text-white px-4 py-3" required>
                            <input type="text" name="billing_zip" value="{{ old('billing_zip') }}" placeholder="ZIP Code" class="bg-dark-900 border border-dark-700 text-white px-4 py-3" required>
                            <input type="text" name="billing_country" value="{{ old('billing_country', 'India') }}" placeholder="Country" class="bg-dark-900 border border-dark-700 text-white px-4 py-3" required>
                        </div>
                    </div>

                    <div class="bg-dark-800 border border-dark-700 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="font-heading text-xl text-white uppercase tracking-wide">Shipping Address</h2>
                            <label class="inline-flex items-center gap-2 text-gray-300 text-sm">
                                <input id="shipping_same_as_billing" type="checkbox" name="shipping_same_as_billing" value="1" checked>
                                Same as billing
                            </label>
                        </div>

                        <div id="shipping-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                            <input type="text" name="shipping_name" value="{{ old('shipping_name') }}" placeholder="Full Name" class="bg-dark-900 border border-dark-700 text-white px-4 py-3">
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}" placeholder="Phone" class="bg-dark-900 border border-dark-700 text-white px-4 py-3">
                            <input type="text" name="shipping_line1" value="{{ old('shipping_line1') }}" placeholder="Address Line" class="bg-dark-900 border border-dark-700 text-white px-4 py-3">
                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" placeholder="City" class="bg-dark-900 border border-dark-700 text-white px-4 py-3">
                            <input type="text" name="shipping_state" value="{{ old('shipping_state') }}" placeholder="State" class="bg-dark-900 border border-dark-700 text-white px-4 py-3">
                            <input type="text" name="shipping_zip" value="{{ old('shipping_zip') }}" placeholder="ZIP Code" class="bg-dark-900 border border-dark-700 text-white px-4 py-3">
                            <input type="text" name="shipping_country" value="{{ old('shipping_country') }}" placeholder="Country" class="bg-dark-900 border border-dark-700 text-white px-4 py-3">
                        </div>
                    </div>

                    <div class="bg-dark-800 border border-dark-700 p-6">
                        <h2 class="font-heading text-xl text-white uppercase tracking-wide mb-4">Payment Method</h2>
                        <div class="space-y-3">
                            @if($codProvider)
                                <label class="flex items-center gap-3 bg-dark-900 border border-dark-700 p-4 cursor-pointer">
                                    <input type="radio" name="payment_method" value="cod" {{ old('payment_method', $codProvider ? 'cod' : 'razorpay') === 'cod' ? 'checked' : '' }}>
                                    <span class="text-white font-heading uppercase tracking-wide">Cash on Delivery</span>
                                </label>
                            @endif

                            @if($razorpayProvider)
                                <label class="flex items-center gap-3 bg-dark-900 border border-dark-700 p-4 cursor-pointer">
                                    <input type="radio" name="payment_method" value="razorpay" {{ old('payment_method', $codProvider ? 'cod' : 'razorpay') === 'razorpay' ? 'checked' : '' }}>
                                    <span class="text-white font-heading uppercase tracking-wide">Razorpay (UPI/Card/Netbanking)</span>
                                </label>
                            @endif
                        </div>
                    </div>

                    <button id="place-order-btn" type="submit" class="btn-brand px-8 py-4 text-sm tracking-widest inline-flex items-center gap-2">
                        Place Order <i class="bi bi-shield-check"></i>
                    </button>
                </form>
            @endif
        </div>

        <div>
            <div class="bg-dark-800 border border-dark-700 p-6 sticky top-24">
                <h3 class="font-heading text-xl text-white uppercase tracking-wide mb-4">Order Summary</h3>
                <div class="space-y-3 mb-5 border-b border-dark-700 pb-4">
                    @foreach($cartItems as $item)
                        <div class="flex justify-between gap-4 text-sm">
                            <div class="text-gray-300">
                                {{ optional($item->product)->name ?? 'Product' }}
                                <span class="text-gray-500">x {{ $item->quantity }}</span>
                            </div>
                            <div class="text-white font-semibold">Rs {{ number_format($item->quantity * $item->price, 2) }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-5 border-b border-dark-700 pb-4">
                    <form action="{{ route('checkout.coupon.apply') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="coupon_code" value="{{ old('coupon_code', $appliedCoupon['code'] ?? '') }}" placeholder="Coupon code" class="w-full bg-dark-900 border border-dark-700 text-white px-3 py-2 text-sm uppercase tracking-wider">
                        <button type="submit" class="px-4 py-2 border border-brand-500 text-brand-500 text-xs font-heading uppercase tracking-widest hover:bg-brand-500 hover:text-white transition">Apply</button>
                    </form>

                    @if($appliedCoupon)
                        <div class="mt-3 flex items-center justify-between text-xs text-green-400 uppercase tracking-wider">
                            <span>{{ $appliedCoupon['code'] }} applied</span>
                            <form action="{{ route('checkout.coupon.remove') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Remove</button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="space-y-2 text-sm border-b border-dark-700 pb-4 mb-4">
                    <div class="flex justify-between text-gray-300">
                        <span>Subtotal</span>
                        <span>Rs {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-300">
                        <span>Discount</span>
                        <span>- Rs {{ number_format($discount, 2) }}</span>
                    </div>
                </div>

                <div class="flex justify-between items-center text-lg font-heading uppercase tracking-wide">
                    <span class="text-gray-300">Total</span>
                    <span class="text-brand-500">Rs {{ number_format($grandTotal, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if($razorpayProvider)
    @push('scripts')
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    @endpush
@endif

@push('scripts')
<script>
(function () {
    const form = document.getElementById('checkout-form');
    if (!form) {
        return;
    }

    const shippingCheckbox = document.getElementById('shipping_same_as_billing');
    const shippingFields = document.getElementById('shipping-fields');
    const submitButton = document.getElementById('place-order-btn');

    const toggleShipping = () => {
        shippingFields.classList.toggle('hidden', shippingCheckbox.checked);
    };

    shippingCheckbox.addEventListener('change', toggleShipping);
    toggleShipping();

    form.addEventListener('submit', async function (event) {
        const paymentMethod = form.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod || paymentMethod.value !== 'razorpay') {
            return;
        }

        event.preventDefault();
        submitButton.disabled = true;
        submitButton.classList.add('opacity-60', 'cursor-not-allowed');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            });

            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Unable to initiate Razorpay payment.');
            }

            const options = {
                key: data.razorpay.key,
                amount: data.razorpay.amount,
                currency: data.razorpay.currency,
                name: '{{ config('app.name', 'Laravel') }}',
                description: 'Order #' + data.order.id,
                order_id: data.razorpay.order_id,
                handler: async function (paymentResponse) {
                    const verify = await fetch('{{ route('checkout.razorpay.verify') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            order_id: data.order.id,
                            razorpay_order_id: paymentResponse.razorpay_order_id,
                            razorpay_payment_id: paymentResponse.razorpay_payment_id,
                            razorpay_signature: paymentResponse.razorpay_signature
                        })
                    });

                    const verifyData = await verify.json();
                    if (!verify.ok) {
                        throw new Error(verifyData.message || 'Payment verification failed.');
                    }

                    window.location.href = verifyData.redirect_url;
                },
                prefill: {
                    name: document.querySelector('input[name="billing_name"]').value,
                    email: document.querySelector('input[name="billing_email"]').value,
                    contact: document.querySelector('input[name="billing_phone"]').value
                },
                theme: {
                    color: '#E63946'
                },
                modal: {
                    ondismiss: function () {
                        submitButton.disabled = false;
                        submitButton.classList.remove('opacity-60', 'cursor-not-allowed');
                    }
                }
            };

            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function () {
                alert('Payment failed. Please try again.');
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-60', 'cursor-not-allowed');
            });
            rzp.open();
        } catch (error) {
            alert(error.message || 'Something went wrong.');
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-60', 'cursor-not-allowed');
        }
    });
})();
</script>
@endpush