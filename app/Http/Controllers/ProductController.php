<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index($orderId = null)
    {
        // Ambil semua produk yang masih ada stok
        $products = Product::where('stock', '>', 0)->get();

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
            ->get();

        return view('products.index', compact('products', 'orderItems', 'orderId', 'orders'));
    }
}
