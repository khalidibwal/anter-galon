<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GalonController;
use App\Http\Controllers\UsersGalonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\GoogleController;

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

    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

// 🔒 Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// 💧 Daftar produk galon (halaman utama produk)
Route::get('/produk-galon/{orderId?}', [ProductController::class, 'index'])->name('produk.index');


// 🛒 Tambah produk ke cart (POST)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

//checkout product ke whatapp
Route::post('/checkout/whatsapp', [CheckoutController::class, 'whatsapp'])->name('checkout.whatsapp');

//payment method
Route::post('/payment/method', [PaymentController::class, 'method'])->name('payment.method');

// QRIS
Route::post('/payment/qris', [PaymentController::class, 'createQris'])->name('payment.qris');

// Virtual Account
Route::post('/payment/va/bca', [PaymentController::class, 'createVaBca'])->name('payment.bca');
Route::post('/payment/va/bni', [PaymentController::class, 'createVaBni'])->name('payment.bni');
Route::post('/payment/va/bri', [PaymentController::class, 'createVaBri'])->name('payment.bri');
Route::post('/payment/va/permata', [PaymentController::class, 'createVaPermata'])->name('payment.permata');



//payment status
Route::get('/payment/status/{orderId}', function ($orderId) {

    $trxKey = "trx_{$orderId}";
    $trx = session($trxKey);

    if (!$trx) return response()->json(['status' => 'pending']);

    // Untuk sandbox: auto-settlement
    if ($trx['status'] === 'pending') {
        $trx['status'] = 'settlement';
        session([$trxKey => $trx]);
    }

    return response()->json(['status' => $trx['status']]);
});

Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle']);


