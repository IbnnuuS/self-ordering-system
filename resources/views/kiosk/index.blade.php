@extends('layouts.app')
@section('title', 'Selamat Datang')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-400 to-red-500 flex flex-col items-center justify-center p-8">
    <div class="text-center text-white mb-12">
        <div class="text-8xl mb-6">🍽️</div>
        <h1 class="text-5xl font-bold mb-4">Selamat Datang!</h1>
        <p class="text-2xl opacity-90">Pesan makanan & minuman favoritmu di sini</p>
    </div>

    <a href="{{ route('kiosk.menu') }}"
       class="bg-white text-orange-500 font-bold text-3xl px-16 py-8 rounded-3xl shadow-2xl
              hover:bg-orange-50 active:scale-95 transition-all duration-150 touch-manipulation">
        🛒 Mulai Pesan
    </a>

    <p class="text-white opacity-70 mt-8 text-lg">Sentuh tombol untuk memulai</p>
</div>
@endsection
