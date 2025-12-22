<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Controller ProductController
public function index(Request $request, $orderId = null)
{
    // Ambil address_id dari query string, jika ada
    $addressId = $request->query('address_id');
    //  dd($addressId);

    // Simpan address_id ke session jika ada
    if ($addressId) {
        session(['address_id' => $addressId]);
    }

    // Ambil semua produk yang masih ada stok
    $productsQuery = Product::where('stock', '>', 0);

    // Jika address_id ada, filter produk sesuai dengan address_id
    if ($addressId) {
        // Filter produk berdasarkan address_id
        $productsQuery->where('address_id', $addressId);
    }

    // Ambil produk sesuai query
    $products = $productsQuery->get();

    // Ambil order items untuk produk yang ada, bisa filter berdasarkan order tertentu
    $orderItems = OrderItem::with('order', 'product')
        ->whereIn('product_id', $products->pluck('id'))
        ->when($orderId, function($query, $orderId) {
            return $query->where('order_id', $orderId);
        })
        ->get();

    // Ambil order milik user yang login, beserta items dan produk
    $orders = Order::with(['items.product', 'user'])
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    // Cek apakah user punya order yang belum 'done'
    $hasPendingDelivery = false;
    if (Auth::check()) {
        $hasPendingDelivery = Order::where('user_id', Auth::id())
            ->where('delivery_status', '!=', 'done')
            ->exists();
    }

    return view('products.index', compact(
        'products', 
        'orderItems', 
        'orderId', 
        'orders', 
        'hasPendingDelivery'
    ));
}

}
