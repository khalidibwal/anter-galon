<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class PaymentController extends Controller
{
    // Halaman pilih metode pembayaran
    public function method()
    {
        return view('payment.method');
    }

    // Simpan order dan item
    private function saveOrderToDatabase($orderId, $total, $paymentType, $charge)
    {
        $user = Auth::user();
        $alamat = $user->alamatPengiriman;

        $paymentCode = $charge->va_numbers[0]->va_number 
                        ?? $charge->permata_va->va_number 
                        ?? $charge->qr_string 
                        ?? null;

        $order = Order::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'gross_amount' => $total,
            'payment_type' => $paymentType,
            'payment_code' => $paymentCode,
            'status' => 'pending',
            'alamat' => $alamat->alamat ?? 'Alamat belum diatur',
            'detail_alamat' => $alamat->detail_alamat ?? null,
            'latitude' => $alamat->latitude ?? null,
            'longitude' => $alamat->longitude ?? null,
            'waktu_pengantaran' => $alamat->waktu_pengantaran ?? null,
        ]);

        $cart = session('cart', []);
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_name' => $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item['qty'] * $item['price'],
            ]);
        }

        return $order;
    }

    // Proses pembayaran Midtrans (server-side)
    public function processPayment(Request $request)
{
    $cart = session('cart', []);
    if (!$cart) return back()->with('error', 'Keranjang kosong!');

    $total = array_sum(array_map(fn($i) => $i['qty'] * $i['price'], $cart)) + 200;
    $paymentType = $request->payment_type;
    $orderId = strtoupper($paymentType) . '-' . time();

    // Parameter Midtrans
    $params = [
        "payment_type" => ($paymentType === 'qris') ? 'qris' : 'bank_transfer',
        "transaction_details" => [
            "order_id" => $orderId,
            "gross_amount" => intval($total),
        ],
    ];

    if ($paymentType === 'qris') {
        $params['qris'] = ['acquirer' => 'gopay'];
    } elseif ($paymentType === 'permata') {
        $params['permata_va'] = ['recipient_name' => 'My Shop'];
    } else {
        $params['bank_transfer'] = ['bank' => $paymentType];
    }

    try {
        $charge = \Midtrans\CoreApi::charge($params);

        $this->saveOrderToDatabase($orderId, $total, $paymentType, $charge);

        session(['charge' => $charge]);

        // ===== Kondisi Redirect =====
        if ($paymentType === 'qris') {
            return redirect()->route('payment.qris.page'); // redirect QRIS
        } else {
            return redirect()->route('payment.va.page'); // redirect VA/bank
        }

    } catch (\Exception $e) {
        return back()->with('error', 'Midtrans Error: ' . $e->getMessage());
    }
}


    // Halaman VA / QRIS
    public function vaPage()
    {
        $charge = session('charge');
        if (!$charge) {
            return redirect()->route('payment.method')->with('error', 'Data pembayaran tidak ditemukan.');
        }

        return view('payment.va', compact('charge'));
    }
    public function qrisPage()
{
    $charge = session('charge');
    if (!$charge) {
        return redirect()->route('payment.method')->with('error', 'Data pembayaran tidak ditemukan.');
    }

    return view('payment.qris', compact('charge'));
}

}
