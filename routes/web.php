<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GalonController;
use App\Http\Controllers\UsersGalonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Route utama aplikasi antar galon
*/

// 🔁 Redirect dari root ke halaman utama
Route::redirect('/', '/antargalon');

// 📦 Halaman utama (index)
Route::get('/antargalon', [GalonController::class, 'index'])->name('antar.galon');

// 🔐 Halaman register/login (hanya untuk guest)
Route::get('/antargalon/auth', [GalonController::class, 'toRegister'])
    ->middleware('guest') // hanya bisa diakses jika belum login
    ->name('galon.auth');

// 👥 Resource CRUD untuk Users Galon (wajib login)
Route::middleware('auth')->group(function () {
    Route::resource('users_galon', UsersGalonController::class);
});

Route::middleware('guest')->group(function () {
    // Form register
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegister']);

    // Form login
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'storeLogin']);
});

// 🔒 Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// 💧 Daftar produk galon (halaman utama produk)
Route::get('/produk-galon', [ProductController::class, 'index'])->name('produk.index');

// 🛒 Tambah produk ke cart (POST)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

//checkout product ke whatapp
Route::post('/checkout/whatsapp', [CheckoutController::class, 'whatsapp'])->name('checkout.whatsapp');


