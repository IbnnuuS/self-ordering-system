<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Kiosk (customer) - public
Route::get('/', [KioskController::class, 'index'])->name('kiosk');
Route::get('/menu', [KioskController::class, 'menu'])->name('kiosk.menu');

// Order - public
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{order}/payment', [OrderController::class, 'payment'])->name('order.payment');
Route::get('/order/{order}/bill', [OrderController::class, 'bill'])->name('order.bill');

// Payment - public
Route::post('/payment/cash/{order}', [PaymentController::class, 'cash'])->name('payment.cash');
Route::post('/payment/qris/{order}', [PaymentController::class, 'qris'])->name('payment.qris');
Route::post('/payment/midtrans/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/{order}/status', [PaymentController::class, 'status'])->name('payment.status');
Route::get('/payment/{order}/finish', [PaymentController::class, 'finish'])->name('payment.finish');

// Protected routes (require auth)
Route::middleware('auth')->group(function () {

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

        // Menu management
        Route::prefix('menus')->name('menus.')->group(function () {
            Route::get('/', [AdminMenuController::class, 'index'])->name('index');
            Route::post('/', [AdminMenuController::class, 'store'])->name('store');
            Route::put('/{menu}', [AdminMenuController::class, 'update'])->name('update');
            Route::delete('/{menu}', [AdminMenuController::class, 'destroy'])->name('destroy');
        });

        // User management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
            Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        });
    });
});
