<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.detail');
// Order routes, dành cho customer
Route::prefix('order')->name('order.')->group(function () {
    Route::post('/buy-now', [App\Http\Controllers\OrderController::class, 'buyNow'])->name('buyNow');
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('store');
    Route::get('/checkout/success', [OrderController::class, 'vnpayReturn'])->name('vnpay_return');
});

// routes/web.php

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.orders.index');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminOrderController::class, 'detail'])->name('detail');
        Route::post('/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('update_status');
    });
});


require __DIR__ . '/auth.php';
