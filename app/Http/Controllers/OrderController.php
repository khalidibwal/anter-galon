<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat order miliknya
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Delivery steps untuk progress bar
        $deliverySteps = [
            'on_the_way' => 'Kurir menuju rumah Anda',
            'refill' => 'Air galon sedang di Refil',
            'delivering' => 'Kurir mengantar galon Anda'
        ];

        $stepKeys = array_keys($deliverySteps);

        // Ambil status delivery yang bisa diupdate admin
        $currentDeliveryStatus = $order->delivery_status ?? 'on_the_way';
        $currentStepIndex = array_search($currentDeliveryStatus, $stepKeys);
        $currentStepIndex = ($currentStepIndex === false) ? 0 : intval($currentStepIndex);
        $totalSteps = count($deliverySteps);

        return view('order.show', compact(
            'order', 
            'deliverySteps', 
            'currentDeliveryStatus', 
            'currentStepIndex', 
            'totalSteps'
        ));
    }

    public function showByOrderId($order_id)
    {
        $order = Order::where('order_id', $order_id)->firstOrFail();

        // Pastikan user hanya bisa melihat order miliknya
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Sama seperti di show()
        $deliverySteps = [
            'on_the_way' => 'Kurir menuju rumah Anda',
            'refill' => 'Air galon sedang di Refil',
            'delivering' => 'Kurir mengantar galon Anda'
        ];

        $stepKeys = array_keys($deliverySteps);
        $currentDeliveryStatus = $order->delivery_status ?? 'on_the_way';
        $currentStepIndex = array_search($currentDeliveryStatus, $stepKeys);
        $currentStepIndex = ($currentStepIndex === false) ? 0 : intval($currentStepIndex);
        $totalSteps = count($deliverySteps);

        return view('order.show', compact(
            'order', 
            'deliverySteps', 
            'currentDeliveryStatus', 
            'currentStepIndex', 
            'totalSteps'
        ));
    }
    public function getStatus(Order $order)
{
    if ($order->user_id !== auth()->id()) {
        abort(403);
    }

    $deliverySteps = [
        'on_the_way' => 'Kurir menuju rumah Anda',
        'refill' => 'Air galon sedang di Refil',
        'delivering' => 'Kurir mengantar galon Anda'
    ];

    $stepKeys = array_keys($deliverySteps);
    $currentStepIndex = array_search($order->delivery_status ?? 'on_the_way', $stepKeys);
    $currentStepIndex = ($currentStepIndex === false) ? 0 : intval($currentStepIndex);

    return response()->json([
        'currentStepIndex' => $currentStepIndex,
        'deliverySteps' => $deliverySteps
    ]);
}
}
