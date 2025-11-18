@extends('Component.Landing.Layout')

@section('content')
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">


    {{-- Main Content --}}
    <main class="flex-1 max-w-6xl mx-auto px-4 py-10">
        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-6 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Section Produk --}}
        <section>
            <h2 class="text-xl font-bold mb-4">🧴 Pilih Galon Anda</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-5 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ $product->description }}</p>
                        </div>

                        <div>
                            <p class="font-bold text-blue-600 mb-1 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mb-4">Stok: {{ $product->stock }}</p>

                            <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="number"
                                       name="qty"
                                       value="1"
                                       min="1"
                                       max="{{ $product->stock }}"
                                       class="w-20 border border-gray-300 rounded-md px-2 py-1 text-center focus:ring-blue-500 focus:border-blue-500 transition">

                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded-md font-medium transition">
                                    + Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Section Keranjang --}}
        <section class="mt-12 bg-white p-6 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">🛒 <span>Keranjang Belanja</span></h2>

            @php $cart = session('cart', []); @endphp

            @if(count($cart))
                <div class="overflow-x-auto">
                   <table class="w-full text-left border-collapse">
    <thead class="bg-gray-100 border-b">
        <tr>
            <th class="py-3 px-4">Produk</th>
            <th class="py-3 px-4 text-center">Qty</th>
            <th class="py-3 px-4 text-right">Harga</th>
            <th class="py-3 px-4 text-right">Subtotal</th>
            <th class="py-3 px-4 text-center">Aksi</th>   {{-- Tambahan --}}
        </tr>
    </thead>
    <tbody>
        @foreach($cart as $key => $item)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4">{{ $item['name'] }}</td>
                <td class="py-3 px-4 text-center">{{ $item['qty'] }}</td>
                <td class="py-3 px-4 text-right">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                <td class="py-3 px-4 text-right font-medium">Rp {{ number_format($item['qty'] * $item['price'], 0, ',', '.') }}</td>
                
                {{-- Tombol Hapus --}}
                <td class="py-3 px-4 text-center">
    <button 
        type="button"
        onclick="openDeleteModal('{{ $key }}')"
        class="bg-red-500 hover:bg-red-600 text-black px-3 py-1 rounded">
        Hapus
    </button>
</td>

            </tr>
        @endforeach
    </tbody>
</table>
@php
    $total = 0;
    foreach($cart as $item){
        $total += $item['qty'] * $item['price'];
    }
@endphp

<div class="text-right mt-4">
    <h3 class="text-lg font-semibold">Total Keseluruhan:</h3>
    <p class="text-xl font-bold text-blue-600">
        Rp {{ number_format($total, 0, ',', '.') }}
    </p>
</div>


                </div>
            @else
                <p class="text-gray-600">Keranjang masih kosong. Yuk pilih galon di atas dulu!</p>
            @endif
        </section>
            @if(count($cart))
    @if(auth()->check())
        {{-- Form langsung ke WhatsApp --}}
        <form action="{{ route('checkout.whatsapp') }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-black px-4 py-2 rounded-md inline-block mt-10">
                Checkout Pesanan ke WhatsApp
            </button>
        </form>
    @else
        {{-- Jika belum login, tampilkan tombol login --}}
        <a href="{{ route('login') }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-md inline-block mt-10">
            Daftar/Login untuk Checkout
        </a>
    @endif
@endif


    </main>




{{-- Modal Konfirmasi Hapus --}}
<div id="deleteModal" 
     class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">

    <div class="bg-white p-6 rounded-lg shadow max-w-sm">
        <h2 class="text-lg font-semibold mb-3">Konfirmasi Hapus</h2>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus produk ini dari keranjang?</p>

        <form id="deleteForm" method="POST" action="{{ route('cart.remove') }}">
            @csrf
            <input type="hidden" name="product_id" id="deleteProductId">

            <div class="flex justify-end space-x-3">
                <button type="button" 
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-black">
                    Batal
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-red-600 rounded hover:bg-red-700">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>



<script>
    function openDeleteModal(productId) {
        document.getElementById('deleteProductId').value = productId;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

<script>
    function openCheckoutModal() {
        const modal = document.getElementById('checkoutModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCheckoutModal() {
        const modal = document.getElementById('checkoutModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>



</body>
@endsection