@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Home / Dashboard')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-receipt text-indigo-600 text-xl"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total Order Hari Ini</p>
            <p class="text-3xl font-bold text-gray-800">{{ $todayOrders }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Semua status</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-sack-dollar text-green-600 text-xl"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Pendapatan Hari Ini</p>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
            <p class="text-xs text-green-500 mt-0.5">Order lunas</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-clock text-yellow-600 text-xl"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Order Pending</p>
            <p class="text-3xl font-bold text-gray-800">{{ $pendingOrders }}</p>
            <p class="text-xs text-yellow-500 mt-0.5">Menunggu konfirmasi</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-bowl-food text-orange-600 text-xl"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total Menu Aktif</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalMenus }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Tersedia di kiosk</p>
        </div>
    </div>
</div>

{{-- Chart + Recent Activity --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6">

    {{-- Chart --}}
    <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-bold text-gray-800">Laporan Order</h2>
                <p class="text-xs text-gray-400">7 hari terakhir</p>
            </div>
        </div>
        <canvas id="orderChart" height="100"></canvas>
    </div>

    {{-- Recent Activity --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-bold text-gray-800">Order Terbaru</h2>
                <p class="text-xs text-gray-400">Hari ini</p>
            </div>
        </div>
        <div class="space-y-3">
            @forelse($recentOrders as $order)
            <div class="flex items-start gap-3">
                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0
                    {{ $order->payment_status === 'paid' ? 'bg-green-400' : 'bg-yellow-400' }}"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-700 truncate">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-400">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }} •
                        {{ strtoupper($order->payment_method ?? '-') }}
                    </p>
                </div>
                <span class="text-xs text-gray-400 flex-shrink-0">{{ $order->created_at->diffForHumans() }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Belum ada order hari ini</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Bottom: Payment Split + Top Menu --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

    {{-- Payment Method Split --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h2 class="font-bold text-gray-800 mb-1">Metode Pembayaran</h2>
        <p class="text-xs text-gray-400 mb-4">Bulan ini</p>
        <div class="flex items-center gap-6">
            <canvas id="paymentChart" width="140" height="140"></canvas>
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    <span class="text-sm text-gray-600">Cash</span>
                    <span class="ml-auto font-bold text-gray-800">{{ $cashCount }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-400"></div>
                    <span class="text-sm text-gray-600">QRIS</span>
                    <span class="ml-auto font-bold text-gray-800">{{ $qrisCount }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Menu --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h2 class="font-bold text-gray-800 mb-1">Menu Terlaris</h2>
        <p class="text-xs text-gray-400 mb-4">Berdasarkan total order</p>
        <div class="space-y-3">
            @foreach($topMenus as $index => $item)
            <div class="flex items-center gap-3">
                <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center flex-shrink-0">
                    {{ $index + 1 }}
                </span>
                <span class="flex-1 text-sm text-gray-700 truncate">{{ $item->menu_name }}</span>
                <span class="text-sm font-bold text-gray-800">{{ $item->total_qty }}x</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Order Chart (7 hari)
const orderCtx = document.getElementById('orderChart').getContext('2d');
new Chart(orderCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Jumlah Order',
            data: {!! json_encode($chartData) !!},
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99,102,241,0.08)',
            borderWidth: 2.5,
            pointBackgroundColor: '#6366f1',
            pointRadius: 4,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { stepSize: 1 } },
            x: { grid: { display: false } }
        }
    }
});

// Payment Doughnut
const payCtx = document.getElementById('paymentChart').getContext('2d');
new Chart(payCtx, {
    type: 'doughnut',
    data: {
        labels: ['Cash', 'QRIS'],
        datasets: [{
            data: [{{ $cashCount }}, {{ $qrisCount }}],
            backgroundColor: ['#4ade80', '#60a5fa'],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: false,
        plugins: { legend: { display: false } },
        cutout: '70%',
    }
});
</script>
@endpush
