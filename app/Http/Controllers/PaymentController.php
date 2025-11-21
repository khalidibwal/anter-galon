<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
   public function createQris(Request $request)
{
    $cart = session('cart', []);

    if (!$cart) return back()->with('error', 'Keranjang kosong!');

    $total = 0;
    foreach ($cart as $item) $total += $item['qty'] * $item['price'];

    // Tambahkan admin fee
    $total += 200;

    $orderId = 'ORDER-' . time();

    $params = [
        "payment_type" => "qris",
        "transaction_details" => [
            "order_id"     => $orderId,
            "gross_amount" => intval($total),
        ],
        "qris" => [
            "acquirer" => "gopay"
        ]
    ];

    $charge = \Midtrans\CoreApi::charge($params);

    // Simpan transaksi di DB / session untuk status
    session()->put("trx_{$orderId}", [
        'status' => 'pending',
        'gross_amount' => $total,
    ]);

    return view('payment.qris', ['data' => $charge]);
}



}
