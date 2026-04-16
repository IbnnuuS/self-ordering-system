<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center p-4">

    {{-- Print Area --}}
    <div id="bill" class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">
        <div class="text-center mb-4">
            <h1 class="text-2xl font-bold">🍽️ {{ \App\Models\Setting::get('store_name', 'Self Ordering System') }}</h1>
            <p class="text-gray-500 text-sm">{{ \App\Models\Setting::get('store_address', 'Jl. Contoh No. 123, Kota') }}</p>
            <p class="text-gray-500 text-sm">{{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="border-t border-dashed pt-3 mb-3">
            <p class="text-sm text-gray-600">Invoice: <strong>{{ $order->order_number }}</strong></p>
            <p class="text-sm text-gray-600">Date: {{ $order->created_at->format('d/m/Y H:i') }}</p>
            @if($order->customer_name)
            <p class="text-sm text-gray-600">Customer: <strong>{{ $order->customer_name }}</strong></p>
            @endif
            <p class="text-sm text-gray-600">Payment:
                <strong class="{{ $order->payment_method === 'cash' ? 'text-green-600' : 'text-blue-600' }}">
                    {{ strtoupper($order->payment_method) }}
                </strong>
            </p>
        </div>

        <div class="border-t border-dashed pt-3 mb-3">
            @foreach($order->items as $item)
            <div class="item-row">
                <span class="qty">{{ $item->quantity }}x</span>
                <span class="item-name">{{ $item->menu_name }}</span>
                <span class="item-price">{{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        <div class="border-t border-dashed pt-3 mb-4">
            <div class="total-row">
                <span class="total-label">TOTAL:</span>
                <span class="total-price">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->payment_method === 'cash')
        {{-- Barcode untuk cash --}}
        <div class="text-center border-t border-dashed pt-4">
            <p class="text-sm text-gray-600 mb-2">Tunjukkan ke kasir untuk pembayaran</p>
            <div class="bg-gray-100 rounded-xl p-3 inline-block">
                <img src="https://barcode.tec-it.com/barcode.ashx?data={{ $order->order_number }}&code=Code128&dpi=96"
                     alt="Barcode {{ $order->order_number }}"
                     class="h-16 mx-auto barcode-img">
                <p class="text-xs font-mono mt-1">{{ $order->order_number }}</p>
            </div>
            <p class="text-orange-500 font-bold mt-3 text-lg">→ Silakan ke kasir ←</p>
        </div>
        @else
        <div class="text-center border-t border-dashed pt-4">
            <p class="text-green-600 font-bold text-xl">✓ Pembayaran Berhasil!</p>
            <p class="text-gray-500 text-sm mt-1">Pesanan sedang diproses</p>
        </div>
        @endif

        <div class="border-t border-dashed pt-3 mt-3">
            <p class="text-center text-sm text-gray-600">Terima kasih atas kunjungan Anda!</p>
            @if(\App\Models\Setting::get('wifi_ssid'))
            <div class="border-t border-dashed mt-3 pt-3">
                <p class="text-center text-sm font-bold text-gray-700">Wi-Fi Access</p>
                <p class="text-center text-xs text-gray-600">SSID: <strong>{{ \App\Models\Setting::get('wifi_ssid') }}</strong></p>
                @if(\App\Models\Setting::get('wifi_password'))
                <p class="text-center text-xs text-gray-600">Pass: <strong>{{ \App\Models\Setting::get('wifi_password') }}</strong></p>
                @endif
            </div>
            @endif
            <p class="text-center text-xs text-gray-400 mt-2">***</p>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="mt-6 flex gap-4 w-full max-w-sm no-print">
        <a href="{{ route('kiosk') }}"
           class="w-full bg-orange-500 text-white font-bold py-4 rounded-2xl text-lg text-center active:scale-95 transition-transform">
            🏠 Selesai
        </a>
    </div>

</div>

<style>
/* Screen View - Modern UI with flex */
.item-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 14px;
}

.item-row .qty {
    width: 15%;
}

.item-row .item-name {
    flex: 1;
}

.item-row .item-price {
    width: 30%;
    text-align: right;
}

.total-row {
    display: flex;
    justify-content: space-between;
    font-weight: bold;
    font-size: 18px;
}

.total-row .total-label {
    flex: 1;
    text-align: right;
    padding-right: 10px;
}

.total-row .total-price {
    width: 40%;
    text-align: right;
}

/* Print View - Thermal Receipt Style */
@media print {
    @page {
        margin: 0;
        size: 80mm auto;
    }

    body {
        margin: 0;
        padding: 5px;
        background: white;
        font-family: 'Courier New', Courier, monospace;
        font-size: 12px;
        width: 80mm;
    }

    body * {
        visibility: hidden;
    }

    #bill, #bill * {
        visibility: visible;
    }

    #bill {
        position: absolute;
        left: 0;
        top: 0;
        width: 80mm;
        padding: 5px;
        margin: 0;
        box-shadow: none !important;
        border-radius: 0 !important;
        background: white !important;
        font-family: 'Courier New', Courier, monospace;
        font-size: 12px;
    }

    /* Reset colors */
    #bill * {
        color: #000 !important;
        background: transparent !important;
    }

    /* Header */
    #bill h1 {
        font-size: 14px !important;
        font-weight: bold;
        margin: 0 !important;
    }

    #bill .text-center p {
        font-size: 10px !important;
        margin: 1px 0 !important;
    }

    #bill .mb-4, #bill .mb-3 {
        margin-bottom: 5px !important;
    }

    #bill .pt-3, #bill .pt-4 {
        padding-top: 5px !important;
    }

    #bill .mt-3 {
        margin-top: 5px !important;
    }

    /* Border */
    #bill .border-t {
        border-top: 1px dashed #000 !important;
        margin: 5px 0 !important;
        border-radius: 0 !important;
    }

    /* Info text */
    #bill .text-sm {
        font-size: 11px !important;
        line-height: 1.3 !important;
    }

    #bill .text-xs {
        font-size: 10px !important;
    }

    /* Items with float layout */
    #bill .item-row {
        display: block !important;
        overflow: hidden;
        margin-bottom: 2px !important;
        font-size: 11px !important;
    }

    #bill .item-row .qty {
        float: left;
        width: 10%;
    }

    #bill .item-row .item-name {
        float: left;
        width: 60%;
    }

    #bill .item-row .item-price {
        float: right;
        width: 30%;
        text-align: right;
    }

    /* Total row */
    #bill .total-row {
        display: block !important;
        overflow: hidden;
        font-size: 14px !important;
        font-weight: bold;
        margin-top: 5px !important;
    }

    #bill .total-row .total-label {
        float: left;
        width: 60%;
        text-align: right;
        padding-right: 5px;
    }

    #bill .total-row .total-price {
        float: right;
        width: 40%;
        text-align: right;
    }

    /* Barcode */
    #bill .bg-gray-100 {
        background: transparent !important;
        border-radius: 0 !important;
        padding: 5px 0 !important;
    }

    #bill .barcode-img {
        max-width: 60mm !important;
        height: 40px !important;
        margin: 5px auto !important;
    }

    #bill .font-mono {
        font-size: 10px !important;
        margin-top: 3px !important;
    }

    #bill .text-orange-500,
    #bill .text-green-600 {
        font-size: 12px !important;
        font-weight: bold !important;
    }

    #bill .text-lg {
        font-size: 12px !important;
    }

    #bill .text-xl {
        font-size: 13px !important;
    }

    /* Hide buttons */
    .no-print {
        display: none !important;
    }
}
</style>

<script>
// Auto print saat halaman dibuka
window.onload = function() {
    window.print();
};
</script>

</body>
</html>
