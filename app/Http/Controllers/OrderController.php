<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UserAddress;

class OrderController extends Controller
{
    public function show($id)
    {
        $order = Order::with('items.product', 'user')->findOrFail($id);

        // Pastikan user hanya bisa melihat order miliknya
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Progress bar delivery steps + DONE
        $deliverySteps = [
            'on_the_way'  => 'Kurir menuju rumah Anda',
            'refill'      => 'Air galon sedang di Refil',
            'delivering'  => 'Kurir mengantar galon Anda',
            'done'        => 'Pesanan selesai'
        ];

        $stepKeys = array_keys($deliverySteps);
        $currentStepIndex = array_search($order->delivery_status ?? 'on_the_way', $stepKeys);
        $currentStepIndex = ($currentStepIndex === false) ? 0 : intval($currentStepIndex);
        $totalSteps = count($deliverySteps);

        return view('order.show', compact(
            'order',
            'deliverySteps',
            'currentStepIndex',
            'totalSteps'
        ));
    }
    private function deliverySteps()
{
    return [
        'accepted'     => 'Pesanan diterima',
        'on_the_way'   => 'Kurir menuju rumah Anda',
        'refill'       => 'Air galon sedang di refill',
        'delivering'   => 'Kurir mengantar galon Anda',
        'done'         => 'Pesanan selesai',
    ];
}

    public function showByOrderId($order_id)
{
    $order = Order::where('order_id', $order_id)->firstOrFail();

    // Pastikan user hanya bisa melihat order miliknya
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    // Sama seperti di show(), tambahkan ACCEPTED & DONE (TIDAK MENGHAPUS YANG LAMA)
    $deliverySteps = [
        'accepted'     => 'Pesanan diterima',          //  STEP BARU
        'on_the_way'   => 'Kurir menuju rumah Anda',
        'refill'       => 'Air galon sedang di Refil',
        'delivering'   => 'Kurir mengantar galon Anda',
        'done'         => 'Pesanan selesai'
    ];

    $stepKeys = array_keys($deliverySteps);

    // Status default tetap aman
    $currentDeliveryStatus = $order->delivery_status ?? 'on_the_way';

    // HANDLE CANCEL TANPA MERUSAK STEP
    if ($currentDeliveryStatus === 'cancelled') {
        $currentStepIndex = -1; // flag khusus cancel
    } else {
        $currentStepIndex = array_search($currentDeliveryStatus, $stepKeys);
        $currentStepIndex = ($currentStepIndex === false) ? 0 : intval($currentStepIndex);
    }

    $totalSteps = count($deliverySteps);
    $addressId = request('address_id');

    return view('order.show', compact(
        'order',
        'deliverySteps',
        'currentDeliveryStatus',
        'currentStepIndex',
        'totalSteps',
        'addressId'
    ));
}


    public function getStatus(Order $order)
{
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    if ($order->delivery_status === 'cancelled') {
        return response()->json([
            'cancelled' => true
        ]);
    }

    $deliverySteps = $this->deliverySteps();
    $stepKeys = array_keys($deliverySteps);

    $currentStepIndex = array_search(
        $order->delivery_status ?? 'accepted',
        $stepKeys
    );

    return response()->json([
        'cancelled' => false,
        'currentStepIndex' => $currentStepIndex,
        'deliverySteps' => $deliverySteps
    ]);
}


}
