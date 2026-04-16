<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function cash(Order $order)
    {
        $order->update(['payment_method' => 'cash']);

        Payment::create([
            'order_id' => $order->id,
            'method'   => 'cash',
            'amount'   => $order->total_amount,
            'status'   => 'pending',
        ]);

        return redirect()->route('order.bill', $order);
    }

    public function qris(Order $order)
    {
        $order->update(['payment_method' => 'qris']);

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'payment_type' => 'qris',
            'qris' => [
                'acquirer' => 'gopay',
            ],
            'customer_details' => [
                'first_name' => $order->customer_name ?? 'Customer',
            ],
            'item_details' => $order->items->map(fn($item) => [
                'id'       => $item->menu_id,
                'price'    => (int) $item->price,
                'quantity' => $item->quantity,
                'name'     => $item->menu_name,
            ])->toArray(),
            'callbacks' => [
                'finish' => route('payment.finish', $order),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            Payment::create([
                'order_id'       => $order->id,
                'method'         => 'qris',
                'amount'         => $order->total_amount,
                'status'         => 'pending',
                'transaction_id' => $snapToken,
            ]);

            return view('kiosk.qris', compact('order', 'snapToken'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat transaksi QRIS: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        try {
            $notification = new Notification();

            $orderId       = $notification->order_id;
            $statusCode    = $notification->status_code;
            $grossAmount   = $notification->gross_amount;
            $signatureKey  = $notification->signature_key;
            $transactionStatus = $notification->transaction_status;
            $paymentType   = $notification->payment_type;

            $serverKey = config('midtrans.server_key');
            $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signatureKey !== $expectedSignature) {
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $order = Order::where('order_number', $orderId)->first();
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $payment = $order->payment;

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                $order->update([
                    'payment_status' => 'paid',
                    'order_status'   => 'waiting',
                ]);
                $payment?->update([
                    'status'  => 'success',
                    'paid_at' => now(),
                    'midtrans_response' => $request->all(),
                ]);

                event(new OrderPaid($order->load('items')));
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->update(['payment_status' => 'failed']);
                $payment?->update(['status' => 'failed']);
            }

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function status(Order $order)
    {
        return response()->json([
            'payment_status' => $order->payment_status,
            'order_status'   => $order->order_status,
        ]);
    }

    public function finish(Order $order)
    {
        // Cek status langsung ke Midtrans API
        try {
            $status = \Midtrans\Transaction::status($order->order_number);

            if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                $order->update([
                    'payment_status' => 'paid',
                    'order_status'   => 'waiting',
                ]);

                $payment = $order->payment;
                $payment?->update([
                    'status'  => 'success',
                    'paid_at' => now(),
                    'midtrans_response' => json_decode(json_encode($status), true),
                ]);

                event(new OrderPaid($order->load('items')));
            }
        } catch (\Exception $e) {
            \Log::error('Midtrans status check failed: ' . $e->getMessage());
        }

        return redirect()->route('order.bill', $order);
    }
}
