<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $qty = (int) $request->qty;
        if ($qty < 1) $qty = 1;

        // Cek stok
        if ($qty > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', $product->name . ' ditambahkan ke keranjang!');
    }
    public function remove(Request $request)
{
    $productId = $request->product_id;

    $cart = session()->get('cart', []);

    // Hapus item jika ada dalam cart
    if(isset($cart[$productId])) {
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    return back()->with('error', 'Produk tidak ditemukan dalam keranjang.');
}

}
