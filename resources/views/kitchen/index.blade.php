@extends('layouts.admin')
@section('title', 'Kitchen Display')
@section('page-title', 'Kitchen Display')
@section('page-subtitle', 'Operasional / Kitchen')

@section('content')
<div x-data="kitchenPage()">

    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
            <span class="text-sm text-gray-500">Auto-update aktif</span>
        </div>
    </div>
    <div id="orders-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($orders as $order)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 border-l-4
                    {{ $order->order_status === 'processing' ? 'border-l-yellow-400' : 'border-l-blue-400' }}"
             id="order-{{ $order->id }}">

            <div class="flex items-center justify-between mb-4">
                <div>
                    <span class="text-2xl font-bold text-gray-800">{{ $order->order_number }}</span>
                    <span class="ml-2 text-xs px-2 py-1 rounded-full font-semibold
                        {{ $order->payment_method === 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ strtoupper($order->payment_method) }}
                    </span>
                </div>
                <span class="text-gray-400 text-sm">{{ $order->created_at->format('H:i') }}</span>
            </div>

            <div class="space-y-2 mb-4">
                @foreach($order->items as $item)
                <div class="flex justify-between items-center bg-gray-50 rounded-xl px-3 py-2">
                    <span class="font-semibold text-gray-700">{{ $item->menu_name }}</span>
                    <span class="bg-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm">
                        {{ $item->quantity }}
                    </span>
                </div>
                @endforeach
            </div>

            <button onclick="markDone({{ $order->id }})"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl text-lg
                           active:scale-95 transition-all touch-manipulation">
                ✅ SELESAI
            </button>
        </div>
        @empty
        <div class="col-span-3 text-center py-20 text-gray-400">
            <div class="text-7xl mb-4">🍽️</div>
            <p class="text-2xl">Tidak ada order masuk</p>
        </div>
        @endforelse
    </div>
</div>

@endsection

@push('scripts')
<script>
function kitchenPage() {
    return {}
}

function markDone(orderId) {
    fetch(`/kitchen/done/${orderId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    }).then(r => r.json()).then(data => {
        const el = document.getElementById(`order-${orderId}`);
        if (el) {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        }
    });
}

// Realtime via polling setiap 10 detik sebagai fallback
setInterval(() => {
    fetch('/kitchen/orders')
        .then(r => r.json())
        .then(orders => {
            // Tambah order baru yang belum ada di DOM
            orders.forEach(order => {
                if (!document.getElementById(`order-${order.id}`)) {
                    location.reload();
                }
            });
        });
}, 10000);
</script>
@endpush
