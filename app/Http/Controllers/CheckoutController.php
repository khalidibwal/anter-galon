<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Handle WhatsApp checkout request.
     */
    public function whatsapp(Request $request)
    {
        // Ambil data user login
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }


        // Ambil keranjang dari session
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        // Hitung total & buat pesan WhatsApp
        $total = 0;
        $message = "Halo Admin, saya ingin melakukan pemesanan galon:\n\n";
        foreach ($cart as $item) {
            $subtotal = $item['price'] * $item['qty'];
            $total += $subtotal;
            $message .= "• {$item['name']} x{$item['qty']} — Rp " . number_format($subtotal, 0, ',', '.') . "\n";
        }

        $message .= "\n*Total Pembayaran:* Rp " . number_format($total, 0, ',', '.') . "\n";
        $message .= "*Nama:* {$user->name}\n";
        $message .= "*Alamat:* {$user->alamat}\n";

        // Simpan ke database orders
        $order = Order::create([
            'user_id' => $user->id,
            'courier_id' => null,
            'address' => $user->alamat,
            'status' => 'pending',
            'order_time' => now(),
            'notes' => null,
        ]);

        // Redirect ke WhatsApp toko
        $nomorToko = "6289662097013";
        return redirect("https://wa.me/{$nomorToko}?text=" . urlencode($message));
    }
}
