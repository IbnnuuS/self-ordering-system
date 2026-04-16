<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Models\Order;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items', 'payment'])
            ->whereIn('payment_status', ['pending', 'paid'])
            ->latest()
            ->get();

        return view('kasir.index', compact('orders'));
    }

    public function confirmCash(Order $order)
    {
        if ($order->payment_method !== 'cash' || $order->payment_status === 'paid') {
            return back()->with('error', 'Order tidak valid untuk konfirmasi cash.');
        }

        $order->update([
            'payment_status' => 'paid',
            'order_status'   => 'waiting',
        ]);

        $order->payment()->update([
            'status'  => 'success',
            'paid_at' => now(),
        ]);

        event(new OrderPaid($order->load('items')));

        return back()->with('success', 'Pembayaran cash dikonfirmasi. Order masuk ke kitchen.');
    }

    public function orders()
    {
        $orders = Order::with(['items', 'payment'])
            ->whereIn('payment_status', ['pending', 'paid'])
            ->latest()
            ->get();

        return response()->json($orders);
    }
}
