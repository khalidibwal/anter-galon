<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;

class OrderHistoryController extends Controller
{
    /**
     * Tampilkan history order berdasarkan order_id
     */
    public function show($orderId)
    {
        // Ambil semua item order beserta data produk
        $orderItems = OrderItem::with('product')
            ->where('order_id', $orderId)
            ->get();

        // Kirim data ke view
        return view('activity.History', compact('orderItems'));
    }
}
