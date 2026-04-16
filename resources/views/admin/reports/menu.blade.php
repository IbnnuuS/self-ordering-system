@extends('layouts.admin')
@section('title', 'Laporan Menu')
@section('page-title', 'Laporan Menu')
@section('page-subtitle', 'Laporan / Menu')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5">
    <form method="GET" action="{{ route('admin.reports.menu') }}" class="flex items-end gap-4">
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

{{-- Top Menu Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-bold text-gray-800">Menu Terlaris</h2>
            <p class="text-sm text-gray-500">Berdasarkan jumlah terjual</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Peringkat</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Menu</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Jumlah Terjual</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($topMenus as $index => $menu)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm
                            {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' : ($index === 1 ? 'bg-gray-100 text-gray-700' : ($index === 2 ? 'bg-orange-100 text-orange-700' : 'bg-gray-50 text-gray-500')) }}">
                            {{ $index + 1 }}
                        </span>
                    </td>
                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $menu->menu_name }}</td>
                    <td class="px-4 py-3 text-gray-600">
                        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $menu->total_qty }} porsi
                        </span>
                    </td>
                    <td class="px-4 py-3 font-semibold text-green-600">
                        Rp {{ number_format($menu->total_revenue, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                        Tidak ada data menu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
