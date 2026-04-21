<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\ProductReviewController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tim-kiem', [ControllersProductController::class, 'search'])->name('search');
Route::get('/san-pham/{slug}', [ControllersProductController::class, 'show'])->name('product.detail');
Route::get('/danh-muc/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addItem'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'updateItem'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

// Order routes, dành cho customer
Route::prefix('order')->name('order.')->group(function () {
    Route::post('/calculate-shipping', [OrderController::class, 'calculateShipping'])->name('calculate.shipping');
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('store');
    Route::get('/checkout/success', [OrderController::class, 'vnpayReturn'])->name('vnpay_return');

    // Tra cứu đơn hàng cho Guest
    Route::get('/tra-cuu', [OrderController::class, 'tracking'])->name('tracking');
    Route::post('/tra-cuu', [OrderController::class, 'doTracking'])->name('do_tracking');

    // Chi tiết order cho guest
    Route::get('/view/{id}', [OrderController::class, 'showDetails'])->name('details');
});

// Lịch sử đơn hàng cho Thành viên
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.history')->middleware('auth');

// Review routes
Route::post('/reviews', [ProductReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

// routes/web.php

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/trash', [ProductController::class, 'trash'])->name('trash');          // danh sách đã xóa
        Route::patch('/{id}/restore', [ProductController::class, 'restore'])->name('restore'); // khôi phục
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ProductController::class, 'update'])->name('update');
        Route::delete('/images/{id}', [ProductController::class, 'deleteImage'])->name('delete_image');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminOrderController::class, 'detail'])->name('detail');
        Route::post('/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('update_status');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle_status');
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::post('/', [BrandController::class, 'store'])->name('store');
        Route::put('/{id}', [BrandController::class, 'update'])->name('update');
        Route::delete('/{id}', [BrandController::class, 'destroy'])->name('destroy');
    });

    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
});


require __DIR__ . '/auth.php';
