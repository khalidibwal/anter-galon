<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UserAddress; // Import model UserAddress
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Menampilkan produk yang terkait dengan user yang sedang login dan memuat alamat
        $products = Product::with('address')
            ->where('user_id', $user->id) // Filter produk berdasarkan user_id
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('Admin.Products.index', compact('products'));
    }

    public function create()
    {
        // Mengambil alamat yang tersedia untuk dropdown
        $addresses = UserAddress::all();
        return view('Admin.Products.create', compact('addresses'));
    }

    public function store(Request $request)
    {
        // Menambahkan validasi untuk address_id
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'address_id' => 'required|exists:user_addresses,id', // Validasi address_id wajib
        ]);

        // Menambahkan user_id dari yang sedang login
        $data = $request->all();
        $data['user_id'] = auth()->id();  // Menambahkan ID pengguna yang sedang login

        // Menyimpan produk baru dengan user_id dan address_id
        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        // Mengambil alamat yang tersedia untuk dropdown
        $addresses = UserAddress::all();
        return view('Admin.Products.edit', compact('product', 'addresses'));
    }

    public function update(Request $request, Product $product)
    {
        // Menambahkan validasi untuk address_id
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'address_id' => 'nullable|exists:user_addresses,id', // Validasi address_id
        ]);

        // Memperbarui produk dengan data baru dan memastikan user_id tetap ada
        $data = $request->all();
        $data['user_id'] = $product->user_id;  // Menjaga user_id yang sudah ada pada produk yang sedang diperbarui

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
