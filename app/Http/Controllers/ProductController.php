<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, $orderId = null)
    {
        /**
         * 1. Ambil address_id dari query ATAU session
         */
        $addressId = $request->query('address_id') ?? session('address_id');

        /**
         * 2. Jika ada di query, simpan/update ke session
         */
        if ($request->has('address_id')) {
            session(['address_id' => $addressId]);
        }

        /**
         * 3. Wajib pilih depot dulu
         * (hindari produk tampil semua)
         */
        if (!$addressId) {
            return redirect()
                ->route('map.depot')
                ->with('error', 'Silakan pilih depot terlebih dahulu');
        }

        /**
         * 4. Ambil produk berdasarkan depot + stok
         */
        $products = Product::where('stock', '>', 0)
            ->where('address_id', $addressId)
            ->get();

        /**
         * 5. Ambil order items terkait produk
         */
        $orderItems = OrderItem::with('order', 'product')
            ->whereIn('product_id', $products->pluck('id'))
            ->when($orderId, fn ($q) => $q->where('order_id', $orderId))
            ->get();

        /**
         * 6. Ambil semua order user
         */
        $orders = Order::with(['items.product', 'user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        /**
         * 7. Cek apakah ada pengiriman yang belum selesai
         */
        $hasPendingDelivery = Auth::check()
            ? Order::where('user_id', Auth::id())
                ->where('delivery_status', '!=', 'done')
                ->exists()
            : false;

        /**
         * 8. History order
         */
        $history = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('products.index', compact(
            'products',
            'orderItems',
            'orderId',
            'orders',
            'hasPendingDelivery',
            'history'
        ));
    }
}
