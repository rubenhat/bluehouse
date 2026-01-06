<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KasirAuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboard;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Kasir\OrderController as KasirOrderController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\LaporanController; // Tambahkan ini
use App\Http\Controllers\Admin\FilterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('home'); // Mengarah ke resources/views/home.blade.php
})->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/note', [CartController::class, 'addNote'])->name('cart.note');
Route::post('/cart/promo', [CartController::class, 'applyPromo'])->name('cart.promo');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

// Admin Authentication
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

// Kasir Authentication
Route::get('/kasir/login', [KasirAuthController::class, 'showLogin'])->name('kasir.login');
Route::post('/kasir/login', [KasirAuthController::class, 'login'])->name('kasir.login.submit');
Route::post('/kasir/logout', [KasirAuthController::class, 'logout'])
    ->name('kasir.logout');

// Kasir routes with middleware (jika ada middleware kasir)
Route::prefix('kasir')->name('kasir.')->group(function () {
    
    //Order kasir
    Route::get('/pesanan', [KasirOrderController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [KasirOrderController::class, 'show'])->name('pesanan.show');
    Route::patch('/orders/{id}/status', [KasirOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{order}', [KasirOrderController::class, 'destroy'])->name('orders.destroy');
});

// Admin routes with middleware (jika ada middleware admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Order Management Routes
    Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [AdminOrderController::class, 'show'])->name('pesanan.show');
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    // ✅ route khusus untuk PAID (payment_status)
    Route::patch('/orders/{order}/payment_status', [AdminOrderController::class, 'markAsPaid'])
        ->name('orders.markAsPaid');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Menu Management Routes
    Route::get('/menu', [AdminMenuController::class, 'index'])->name('menu.index');
    Route::post('/menu', [AdminMenuController::class, 'store'])->name('menu.store');
    Route::put('/menu/{id}', [AdminMenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [AdminMenuController::class, 'destroy'])->name('menu.destroy');
    Route::patch('/menu/{id}/toggle', [AdminMenuController::class, 'toggleStatus'])->name('menu.toggle');

    // API route untuk mengambil data menu (untuk modal edit)
    Route::get('/api/menu/{id}', [AdminMenuController::class, 'show'])->name('menu.show');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'exportPDF'])->name('laporan.export');

    Route::get('/filter', [FilterController::class, 'index'])->name('filter.index');
});




