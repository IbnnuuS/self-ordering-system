@extends('layouts.app')
@section('title', 'Struk')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center p-4">

    {{-- Print Area --}}
    <div id="bill" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">
        <div class="text-center mb-4">
            <h1 class="text-2xl font-bold">🍽️ Self Ordering</h1>
            <p class="text-gray-500 text-sm">{{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="border-t border-dashed pt-3 mb-3">
            <p class="text-sm text-gray-600">No. Order: <strong>{{ $order->order_number }}</strong></p>
            @if($order->customer_name)
            <p class="text-sm text-gray-600">Nama: <strong>{{ $order->customer_name }}</strong></p>
            @endif
            <p class="text-sm text-gray-600">Pembayaran:
                <strong class="{{ $order->payment_method === 'cash' ? 'text-green-600' : 'text-blue-600' }}">
                    {{ strtoupper($order->payment_method) }}
                </strong>
            </p>
        </div>

        <div class="border-t border-dashed pt-3 mb-3">
            @foreach($order->items as $item)
            <div class="flex justify-between text-sm py-1">
                <span>{{ $item->menu_name }} × {{ $item->quantity }}</span>
                <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        <div class="border-t border-dashed pt-3 mb-4">
            <div class="flex justify-between font-bold text-lg">
                <span>TOTAL</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->payment_method === 'cash')
        {{-- Barcode untuk cash --}}
        <div class="text-center border-t border-dashed pt-4">
            <p class="text-sm text-gray-600 mb-2">Tunjukkan ke kasir untuk pembayaran</p>
            <div class="bg-gray-100 rounded-xl p-3 inline-block">
                <img src="https://barcode.tec-it.com/barcode.ashx?data={{ $order->order_number }}&code=Code128&dpi=96"
                     alt="Barcode {{ $order->order_number }}"
                     class="h-16 mx-auto">
                <p class="text-xs font-mono mt-1">{{ $order->order_number }}</p>
            </div>
            <p class="text-orange-500 font-bold mt-3 text-lg">Silakan ke kasir →</p>
        </div>
        @else
        <div class="text-center border-t border-dashed pt-4">
            <p class="text-green-600 font-bold text-xl">✅ Pembayaran Berhasil!</p>
            <p class="text-gray-500 text-sm mt-1">Silakan duduk, pesanan sedang diproses</p>
        </div>
        @endif
    </div>

    {{-- Buttons --}}
    <div class="mt-6 flex gap-4 w-full max-w-sm">
        <button onclick="window.print()"
                class="flex-1 bg-gray-700 text-white font-bold py-4 rounded-2xl text-lg active:scale-95 transition-transform">
            🖨️ Cetak
        </button>
        <a href="{{ route('kiosk') }}"
           class="flex-1 bg-orange-500 text-white font-bold py-4 rounded-2xl text-lg text-center active:scale-95 transition-transform">
            🏠 Selesai
        </a>
    </div>

</div>

@push('styles')
<style>
@media print {
    body * { visibility: hidden; }
    #bill, #bill * { visibility: visible; }
    #bill { position: absolute; left: 0; top: 0; width: 100%; }
    button, a { display: none !important; }
}
</style>
@endpush
@endsection
