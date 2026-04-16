@extends('layouts.admin')
@section('title', 'Settings')
@section('page-title', 'Settings')
@section('page-subtitle', 'Home / Settings')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-1">Pengaturan Toko</h2>
    <p class="text-sm text-gray-500 mb-6">Kelola informasi toko dan WiFi</p>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Store Info --}}
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 flex items-center gap-2">
                    <i class="fa-solid fa-store text-indigo-600"></i> Informasi Toko
                </h3>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Toko</label>
                    <input type="text" name="store_name" value="{{ $settings['store_name'] ?? '' }}"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                           placeholder="Self Ordering System" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
                    <textarea name="store_address" rows="3"
                              class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                              placeholder="Jl. Contoh No. 123, Kota" required>{{ $settings['store_address'] ?? '' }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Telepon</label>
                    <input type="text" name="store_phone" value="{{ $settings['store_phone'] ?? '' }}"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                           placeholder="0812-3456-7890" required>
                </div>
            </div>

            {{-- WiFi Info --}}
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-700 flex items-center gap-2">
                    <i class="fa-solid fa-wifi text-indigo-600"></i> Informasi WiFi
                </h3>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">SSID (Nama WiFi)</label>
                    <input type="text" name="wifi_ssid" value="{{ $settings['wifi_ssid'] ?? '' }}"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                           placeholder="SelfOrder_WiFi">
                    <p class="text-xs text-gray-400 mt-1">Akan ditampilkan di struk cetak</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password WiFi</label>
                    <input type="text" name="wifi_password" value="{{ $settings['wifi_password'] ?? '' }}"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                           placeholder="welcome123">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin ditampilkan</p>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mt-4">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-info text-blue-600 mt-0.5"></i>
                        <div class="text-sm text-blue-700">
                            <p class="font-semibold mb-1">Info</p>
                            <p>Informasi ini akan muncul di struk cetak untuk memudahkan customer mengakses WiFi toko.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6 pt-6 border-t border-gray-100">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-colors">
                <i class="fa-solid fa-save mr-2"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

@endsection
