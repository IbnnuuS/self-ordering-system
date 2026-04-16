<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:100',
        ]);

        $total = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $menu = Menu::findOrFail($item['menu_id']);
            $subtotal = $menu->price * $item['quantity'];
            $total += $subtotal;

            $orderItems[] = [
                'menu_id'   => $menu->id,
                'menu_name' => $menu->name,
                'price'     => $menu->price,
                'quantity'  => $item['quantity'],
                'subtotal'  => $subtotal,
                'notes'     => $item['notes'] ?? null,
            ];
        }

        $order = Order::create([
            'order_number'   => 'ORD-' . strtoupper(uniqid()),
            'total_amount'   => $total,
            'payment_status' => 'pending',
            'order_status'   => 'waiting',
            'customer_name'  => $request->customer_name,
        ]);

        $order->items()->createMany($orderItems);

        return redirect()->route('order.payment', $order);
    }

    public function payment(Order $order)
    {
        return view('kiosk.payment', compact('order'));
    }

    public function bill(Order $order)
    {
        $order->load('items');
        return view('kiosk.bill', compact('order'));
    }
}
