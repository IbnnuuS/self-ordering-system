@extends('layouts.app')
@section('title', 'Bayar QRIS')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center p-6"
     x-data="qrisPage()" x-init="startPolling()">

    <div class="bg-white rounded-3xl shadow-xl p-8 w-full max-w-sm text-center">
        <h1 class="text-2xl font-bold mb-2">Scan QRIS</h1>
        <p class="text-gray-500 mb-1">Order #{{ $order->order_number }}</p>
        <p class="text-2xl font-bold text-orange-500 mb-6">
            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
        </p>

        {{-- Midtrans Snap --}}
        <div id="snap-container" class="mb-4">
            <button id="pay-button"
                    class="w-full bg-blue-500 text-white font-bold text-xl py-4 rounded-2xl active:scale-95 transition-transform">
                📱 Buka QR Code
            </button>
        </div>

        <div x-show="status === 'pending'" class="text-gray-500 text-sm">
            <div class="animate-pulse">⏳ Menunggu pembayaran...</div>
        </div>

        <div x-show="status === 'paid'" class="text-green-600">
            <div class="text-5xl mb-2">✅</div>
            <p class="font-bold text-xl">Pembayaran Berhasil!</p>
            <p class="text-sm text-gray-500 mt-1">Mengalihkan ke struk...</p>
        </div>

        <div x-show="status === 'failed'" class="text-red-500">
            <div class="text-5xl mb-2">❌</div>
            <p class="font-bold">Pembayaran Gagal</p>
            <a href="{{ route('order.payment', $order) }}" class="text-sm underline">Coba lagi</a>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
function qrisPage() {
    return {
        status: 'pending',
        pollInterval: null,

        startPolling() {
            document.getElementById('pay-button').addEventListener('click', () => {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: (result) => {
                        this.status = 'paid';
                        clearInterval(this.pollInterval);
                        setTimeout(() => {
                            window.location.href = '{{ route('order.bill', $order) }}';
                        }, 2000);
                    },
                    onPending: (result) => {
                        this.status = 'pending';
                    },
                    onError: (result) => {
                        this.status = 'failed';
                    },
                    onClose: () => {
                        // user closed popup, keep polling
                    }
                });
            });

            this.pollInterval = setInterval(() => {
                fetch('{{ route('payment.status', $order) }}')
                    .then(r => r.json())
                    .then(data => {
                        if (data.payment_status === 'paid') {
                            this.status = 'paid';
                            clearInterval(this.pollInterval);
                            setTimeout(() => {
                                window.location.href = '{{ route('order.bill', $order) }}';
                            }, 2000);
                        } else if (data.payment_status === 'failed') {
                            this.status = 'failed';
                            clearInterval(this.pollInterval);
                        }
                    });
            }, 3000);
        }
    }
}
</script>
@endpush
@endsection
