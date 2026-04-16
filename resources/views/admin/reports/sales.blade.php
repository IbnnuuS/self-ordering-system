@extends('layouts.admin')
@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')
@section('page-subtitle', 'Laporan / Penjualan')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5">
    <form method="GET" action="{{ route('admin.reports.sales') }}" class="flex items-end gap-4">
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

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-sack-dollar text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-receipt text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-chart-simple text-orange-600 text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase">Rata-rata Transaksi</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($averageOrder, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Daily Breakdown --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
    <h2 class="font-bold text-gray-800 mb-4">Rincian Harian</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Jumlah Order</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Pendapatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($dailySales as $day)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($day->date)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $day->total_orders }} transaksi</td>
                    <td class="px-4 py-3 font-semibold text-green-600">
                        Rp {{ number_format($day->revenue, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-8 text-center text-gray-400">
                        Tidak ada data penjualan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
