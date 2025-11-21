<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;

class ProductController extends Controller
{
    public function index($orderId = null)
{
    $products = Product::where('stock', '>', 0)->get();

    $orderItems = OrderItem::with('order', 'product')
        ->whereIn('product_id', $products->pluck('id'))
        ->when($orderId, function($query, $orderId) {
            return $query->where('order_id', $orderId);
        })
        ->get();

    return view('products.index', compact('products', 'orderItems', 'orderId'));
}
}
