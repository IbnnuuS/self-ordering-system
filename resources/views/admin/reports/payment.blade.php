@extends('layouts.admin')
@section('title', 'Laporan Pembayaran')
@section('page-title', 'Laporan Pembayaran')
@section('page-subtitle', 'Laporan / Pembayaran')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5">
    <form method="GET" action="{{ route('admin.reports.payment') }}" class="flex items-end gap-4">
        <div class="flex-1">
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ $startDate }}"
                   class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="flex-1">
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ $endDate }}"
                   class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-colors">
            <i class="fa-solid fa-filter mr-2"></i> Filter
        </button>
    </form>
</div>

{{-- Payment Method Summary --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-gray-800">Cash</h3>
                <p class="text-xs text-gray-400">Pembayaran Tunai</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-money-bill text-green-600 text-xl"></i>
            </div>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Jumlah Transaksi</span>
                <span class="font-bold text-gray-800">{{ $cashOrders }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total Pendapatan</span>
                <span class="font-bold text-green-600">Rp {{ number_format($cashRevenue, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-gray-800">QRIS</h3>
                <p class="text-xs text-gray-400">Pembayaran Digital</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-qrcode text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Jumlah Transaksi</span>
                <span class="font-bold text-gray-800">{{ $qrisOrders }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total Pendapatan</span>
                <span class="font-bold text-blue-600">Rp {{ number_format($qrisRevenue, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Pending Payments --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-bold text-gray-800">Pembayaran Pending</h2>
            <p class="text-sm text-gray-500">Order yang belum dibayar</p>
        </div>
        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
            {{ $pendingOrders->count() }} pending
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">No. Order</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Metode</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Items</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pendingOrders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $order->order_number }}</td>
                    <td class="px-4 py-3 text-gray-600 text-xs">{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $order->payment_method === 'cash' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ strtoupper($order->payment_method ?? '-') }}
                        </span>
                    </td>
                    <td class="px-4 py-3 font-semibold text-gray-800">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-xs">
                        {{ $order->items->count() }} item
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                        <i class="fa-solid fa-circle-check text-green-400 text-3xl mb-2"></i>
                        <p>Tidak ada pembayaran pending</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
