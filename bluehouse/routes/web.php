<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', function () {
    return view('home');
});

//ADMIN
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// halaman dashboard admin (hanya setelah login)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('admin')->name('admin.dashboard');


//MENU
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

//CART
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/note', [CartController::class, 'note'])->name('cart.note');

//CHECKOUT
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', function () {
    return view('checkout.success');
})->name('checkout.success');




