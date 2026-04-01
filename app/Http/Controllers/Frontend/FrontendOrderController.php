<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderInventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FrontendOrderController extends Controller
{
    public function __construct(private readonly OrderInventoryService $inventoryService)
    {
    }

    public function index(): View
    {
        $orders = Order::with(['items', 'refunds'])
            ->where('user_id', Auth::id())
            ->latest('id')
            ->paginate(10);

        return view('frontend.order.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load(['items', 'paymentProvider', 'paymentTransactions', 'refunds']);

        return view('frontend.order.show', compact('order'));
    }

    public function cancel(Request $request, Order $order): RedirectResponse
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        if (! in_array($order->status, ['pending', 'processing'], true)) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'This order can no longer be cancelled.');
        }

        $order->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->input('reason', 'Cancelled by customer'),
            'cancelled_at' => now(),
        ]);

        $this->inventoryService->restockForOrder($order);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order cancelled successfully. If payment was prepaid, refund will be initiated by admin.');
    }
}
