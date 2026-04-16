<?php

namespace App\Http\Controllers;

use App\Events\OrderDone;
use App\Models\Order;

class KitchenController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->where('payment_status', 'paid')
            ->whereIn('order_status', ['waiting', 'processing'])
            ->latest()
            ->get();

        return view('kitchen.index', compact('orders'));
    }

    public function done(Order $order)
    {
        $order->update(['order_status' => 'done']);

        event(new OrderDone($order));

        return response()->json(['message' => 'Order marked as done.']);
    }

    public function orders()
    {
        $orders = Order::with('items')
            ->where('payment_status', 'paid')
            ->whereIn('order_status', ['waiting', 'processing'])
            ->latest()
            ->get();

        return response()->json($orders);
    }
}
