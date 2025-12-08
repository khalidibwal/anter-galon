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
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\Admin\AdminController; // buat controller admin nanti

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

Route::get('/admin/login', [AuthController::class, 'adminLoginForm'])
    ->middleware('guest:admin')
    ->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'storeAdminLogin'])
    ->middleware('guest:admin');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');
});


// 🔒 Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    
Route::get('/user/lokasi', [UserAddressController::class, 'edit'])
    ->name('user.lokasi.edit')
    ->middleware('auth');

    Route::post('/user/lokasi', [LocationController::class, 'update'])
        ->name('user.lokasi.update');

    
Route::post('/user/alamat/simpan', [UserAddressController::class, 'store'])
    ->name('user.alamat.store')
    ->middleware('auth');

    Route::get('/payment/redirect', function () {
    return view('payment.redirect-payment'); // nanti buat file blade
})->middleware('auth')->name('payment.redirect');

//Order shown
Route::get('/orders/{order_id}', [OrderController::class, 'showByOrderId'])->name('orders.show');
Route::get('/order/{order}/status', [OrderController::class, 'getStatus'])->name('order.status');
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

});


// 💧 Daftar produk galon (halaman utama produk)
Route::get('/produk-galon/{orderId?}', [ProductController::class, 'index'])->name('produk.index');


// 🛒 Tambah produk ke cart (POST)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

//checkout product ke whatapp
Route::post('/checkout/whatsapp', [CheckoutController::class, 'whatsapp'])->name('checkout.whatsapp');

Route::get('/payment/method', [PaymentController::class, 'method'])->name('payment.method');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/va', [PaymentController::class, 'vaPage'])->name('payment.va.page');
Route::get('/payment/qris', [PaymentController::class, 'qrisPage'])->name('payment.qris.page');


// QRIS
Route::post('/payment/qris', [PaymentController::class, 'createQris'])->name('payment.qris');

// Virtual Account
Route::post('/payment/va/bca', [PaymentController::class, 'createVaBca'])->name('payment.bca');
Route::post('/payment/va/bni', [PaymentController::class, 'createVaBni'])->name('payment.bni');
Route::post('/payment/va/bri', [PaymentController::class, 'createVaBri'])->name('payment.bri');
Route::post('/payment/va/permata', [PaymentController::class, 'createVaPermata'])->name('payment.permata');



//payment status
Route::get('/payment/status/{orderId}', function ($orderId) {
    $order = \App\Models\Order::where('order_id', $orderId)->first();

    if (!$order) {
        return response()->json(['status' => 'pending']);
    }

    // Untuk sandbox, langsung set settlement
    if ($order->status === 'pending') {
        $order->status = 'settlement';
        $order->save();
    }

    return response()->json(['status' => $order->status]);
});



//MIDTRANS PAYMENT GATEWAY DO NOT REMOVE !!!!
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle']);


