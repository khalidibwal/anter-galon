<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
{
    $admin = auth()->user();

    if (!$admin->isAdmin()) {
        abort(403);
    }

    $depot = $admin->depot;

    if (!$depot) {
        abort(403, 'Admin belum memiliki depot');
    }

    $orders = Order::with('user')
        ->where('address_id', $depot->id)
        ->latest()
        ->paginate(10);

    return view('Admin.Orders.index', compact('orders'));
}


    public function updateDeliveryStatus(Request $request, Order $order)
    {
        $request->validate([
            'delivery_status' => 'required|string'
        ]);

        $order->update([
            'delivery_status' => $request->delivery_status
        ]);

        return back()->with('success', 'Delivery status updated successfully.');
    }
}
