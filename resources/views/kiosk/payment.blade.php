@extends('layouts.app')
@section('title', 'Pilih Pembayaran')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col">

    <div class="bg-orange-500 text-white px-6 py-4 text-center">
        <h1 class="text-2xl font-bold">Pilih Metode Pembayaran</h1>
        <p class="opacity-80">Order #{{ $order->order_number }}</p>
    </div>

    <div class="flex-1 p-6 flex flex-col items-center justify-center gap-6">

        {{-- Order Summary --}}
        <div class="bg-white rounded-2xl shadow p-5 w-full max-w-md">
            <h2 class="font-bold text-lg mb-3 text-gray-700">Ringkasan Order</h2>
            @foreach($order->items as $item)
            <div class="flex justify-between py-2 border-b text-sm">
                <span class="text-gray-700">{{ $item->menu_name }} × {{ $item->quantity }}</span>
                <span class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
            <div class="flex justify-between pt-3 text-xl font-bold text-orange-500">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Payment Options --}}
        <div class="w-full max-w-md grid grid-cols-2 gap-4">

            {{-- Cash --}}
            <form method="POST" action="{{ route('payment.cash', $order) }}">
                @csrf
                <button type="submit"
                        class="w-full bg-white border-4 border-green-400 rounded-3xl p-6 flex flex-col items-center gap-3
                               active:scale-95 transition-transform touch-manipulation shadow-md hover:shadow-lg">
                    <span class="text-6xl">💵</span>
                    <span class="text-xl font-bold text-green-600">Cash</span>
                    <span class="text-sm text-gray-500 text-center">Bayar di kasir</span>
                </button>
            </form>

            {{-- QRIS --}}
            <form method="POST" action="{{ route('payment.qris', $order) }}">
                @csrf
                <button type="submit"
                        class="w-full bg-white border-4 border-blue-400 rounded-3xl p-6 flex flex-col items-center gap-3
                               active:scale-95 transition-transform touch-manipulation shadow-md hover:shadow-lg">
                    <span class="text-6xl">📱</span>
                    <span class="text-xl font-bold text-blue-600">QRIS</span>
                    <span class="text-sm text-gray-500 text-center">Scan & bayar</span>
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
