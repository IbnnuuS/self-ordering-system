@extends('layouts.app')
@section('title', 'Kasir')

@section('content')
<div class="min-h-screen bg-gray-100" x-data="kasirPage()">

    <div class="bg-gray-800 text-white px-6 py-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold">🏪 Kasir</h1>
        <div class="flex gap-3 text-sm">
            <a href="{{ route('kitchen.index') }}" class="bg-green-600 px-4 py-2 rounded-lg">Kitchen</a>
            <a href="{{ route('admin.index') }}" class="bg-gray-600 px-4 py-2 rounded-lg">Admin</a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 m-4 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded-xl">
        {{ session('error') }}
    </div>
    @endif

    <div class="p-4">
        {{-- Filter Tabs --}}
        <div class="flex gap-2 mb-4">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-gray-800 text-white' : 'bg-white text-gray-600'"
                    class="px-4 py-2 rounded-xl font-semibold transition-colors">Semua</button>
            <button @click="filter = 'cash'" :class="filter === 'cash' ? 'bg-green-600 text-white' : 'bg-white text-gray-600'"
                    class="px-4 py-2 rounded-xl font-semibold transition-colors">Cash Pending</button>
            <button @click="filter = 'paid'" :class="filter === 'paid' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600'"
                    class="px-4 py-2 rounded-xl font-semibold transition-colors">Sudah Bayar</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-2xl shadow p-4"
                 x-show="filter === 'all' ||
                         (filter === 'cash' && '{{ $order->payment_method }}' === 'cash' && '{{ $order->payment_status }}' === 'pending') ||
                         (filter === 'paid' && '{{ $order->payment_status }}' === 'paid')">

                <div class="flex items-center justify-between mb-3">
                    <span class="font-bold text-gray-800">{{ $order->order_number }}</span>
                    <div class="flex gap-2">
                        <span class="text-xs px-2 py-1 rounded-full font-semibold
                            {{ $order->payment_method === 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ strtoupper($order->payment_method ?? '-') }}
                        </span>
                        <span class="text-xs px-2 py-1 rounded-full font-semibold
                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $order->payment_status === 'paid' ? 'LUNAS' : 'PENDING' }}
                        </span>
                    </div>
                </div>

                <div class="text-sm text-gray-600 mb-3">
                    @foreach($order->items as $item)
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <span>{{ $item->menu_name }} × {{ $item->quantity }}</span>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-between">
                    <span class="font-bold text-orange-500 text-lg">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>

                    @if($order->payment_method === 'cash' && $order->payment_status === 'pending')
                    <form method="POST" action="{{ route('kasir.confirm-cash', $order) }}">
                        @csrf
                        <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded-xl font-bold text-sm active:scale-95 transition-transform">
                            ✓ Konfirmasi Cash
                        </button>
                    </form>
                    @elseif($order->payment_status === 'paid')
                    <span class="text-green-600 font-semibold text-sm">
                        {{ $order->order_status === 'done' ? '✅ Selesai' : '🍳 Diproses' }}
                    </span>
                    @endif
                </div>

                <p class="text-xs text-gray-400 mt-2">{{ $order->created_at->format('H:i') }}</p>
            </div>
            @endforeach
        </div>

        @if($orders->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <div class="text-6xl mb-4">📋</div>
            <p class="text-xl">Belum ada order</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function kasirPage() {
    return {
        filter: 'all',
    }
}

// Auto refresh setiap 15 detik
setInterval(() => location.reload(), 15000);
</script>
@endpush
@endsection
