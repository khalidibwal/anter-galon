<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function method(){
        return view('payment.method');
    }
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

public function createVaBca(Request $request)
{
    $cart = session('cart', []);
    if (!$cart) return back()->with('error', 'Keranjang kosong!');

    $total = array_sum(array_map(fn($i) => $i['qty'] * $i['price'], $cart));
    $total += 200;

    $orderId = 'BCA-VA-' . time();

    $params = [
        "payment_type" => "bank_transfer",
        "transaction_details" => [
            "order_id"     => $orderId,
            "gross_amount" => intval($total),
        ],
        "bank_transfer" => [
            "bank" => "bca",
            "va_number" => "12345", // opsional (jika tidak isi → midtrans buat sendiri)
        ],
        "customer_details" => [
            "first_name" => "Customer",
            "email" => "customer@mail.com"
        ]
    ];

    try {
        $charge = \Midtrans\CoreApi::charge($params);
    } catch (\Exception $e) {
        return back()->with('error', 'Midtrans Error: ' . $e->getMessage());
    }

    session(["trx_$orderId" => [
        'status' => 'pending',
        'gross_amount' => $total,
    ]]);

    return view('payment.va', compact('charge'));
}

public function createVaBni(Request $request)
{
    $cart = session('cart', []);
    if (!$cart) return back()->with('error', 'Keranjang kosong!');

    $total = array_sum(array_map(fn($i) => $i['qty'] * $i['price'], $cart));
    $total += 200;

    $orderId = 'BNI-VA-' . time();

    $params = [
        "payment_type" => "bank_transfer",
        "transaction_details" => [
            "order_id" => $orderId,
            "gross_amount" => intval($total),
        ],
        "bank_transfer" => [
            "bank" => "bni",
        ]
    ];

    $charge = \Midtrans\CoreApi::charge($params);

    return view('payment.va', compact('charge'));
}

public function createVaBri(Request $request)
{
    $cart = session('cart', []);
    if (!$cart) return back()->with('error', 'Keranjang kosong!');

    $total = array_sum(array_map(fn($i) => $i['qty'] * $i['price'], $cart));
    $total += 200;

    $orderId = 'BRI-VA-' . time();

    $params = [
        "payment_type" => "bank_transfer",
        "transaction_details" => [
            "order_id" => $orderId,
            "gross_amount" => intval($total),
        ],
        "bank_transfer" => [
            "bank" => "bri",
        ]
    ];

    $charge = \Midtrans\CoreApi::charge($params);

    return view('payment.va', compact('charge'));
}

public function createVaPermata(Request $request)
{
    $cart = session('cart', []);
    if (!$cart) return back()->with('error', 'Keranjang kosong!');

    $total = array_sum(array_map(fn($i) => $i['qty'] * $i['price'], $cart));
    $total += 200;

    $orderId = 'PERMATA-VA-' . time();

    $params = [
        "payment_type" => "permata",
        "transaction_details" => [
            "order_id" => $orderId,
            "gross_amount" => intval($total),
        ],
        "permata_va" => [
            "recipient_name" => "My Shop"
        ]
    ];

    $charge = \Midtrans\CoreApi::charge($params);

    return view('payment.va', compact('charge'));
}






}
