<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\AdminController;

// Kiosk (customer)
Route::get('/', [KioskController::class, 'index'])->name('kiosk');
Route::get('/menu', [KioskController::class, 'menu'])->name('kiosk.menu');

// Order
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{order}/payment', [OrderController::class, 'payment'])->name('order.payment');
Route::get('/order/{order}/bill', [OrderController::class, 'bill'])->name('order.bill');

// Payment
Route::post('/payment/cash/{order}', [PaymentController::class, 'cash'])->name('payment.cash');
Route::post('/payment/qris/{order}', [PaymentController::class, 'qris'])->name('payment.qris');
Route::post('/payment/midtrans/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/{order}/status', [PaymentController::class, 'status'])->name('payment.status');

// Kasir
Route::prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/', [KasirController::class, 'index'])->name('index');
    Route::post('/confirm-cash/{order}', [KasirController::class, 'confirmCash'])->name('confirm-cash');
    Route::get('/orders', [KasirController::class, 'orders'])->name('orders');
});

// Kitchen
Route::prefix('kitchen')->name('kitchen.')->group(function () {
    Route::get('/', [KitchenController::class, 'index'])->name('index');
    Route::post('/done/{order}', [KitchenController::class, 'done'])->name('done');
    Route::get('/orders', [KitchenController::class, 'orders'])->name('orders');
});

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('menus', AdminController::class);
});
