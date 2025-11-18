<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle WhatsApp checkout request.
     */
    public function whatsapp(Request $request)
    {
        // Validasi input dari modal
        $request->validate([
            'nama'   => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
        ]);

        // Ambil data session keranjang
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        $nama    = $request->nama;
        $alamat  = $request->alamat;
        $total   = 0;

        // Header pesan
        $message = "Halo Admin, saya ingin melakukan pemesanan galon:\n\n";

        // Detail produk
        foreach ($cart as $item) {
            $subtotal = $item['price'] * $item['qty'];
            $total   += $subtotal;

            $message .= "• {$item['name']} x{$item['qty']} — Rp " . number_format($subtotal, 0, ',', '.') . "\n";
        }

        // Total & biodata
        $message .= "\n🧾 *Total Pembayaran:* Rp " . number_format($total, 0, ',', '.') . "\n";
        $message .= "👤 *Nama:* {$nama}\n";
        $message .= "📍 *Alamat:* {$alamat}\n";

        // Nomor WA toko
        $nomorToko = "6289662097013";

        // Redirect ke WhatsApp
        return redirect("https://wa.me/{$nomorToko}?text=" . urlencode($message));
    }
}
