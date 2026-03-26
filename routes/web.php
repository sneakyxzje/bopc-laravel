<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index']);
// Order routes, dành cho customer
Route::prefix('order')->name('order.')->group(function () {
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('store');
    Route::get('/checkout/success', [OrderController::class, 'vnpayReturn'])->name('vnpay_return');
});

Route::prefix('admin/orders')->name('admin.orders.')->group(function () {
    Route::get('/', [AdminOrderController::class, 'index'])->name('index');
    Route::get('/{id}', [AdminOrderController::class, 'detail'])->name('detail');
    Route::post('/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('update_status');
});
