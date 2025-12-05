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
    {{-- Tombol Pembayaran QRIS Midtrans --}}
        {{-- <form id="qrisForm" action="{{ route('payment.method') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md inline-block">
                Checkout Payment
            </button>
        </form> --}}
        <a href="{{ route('user.lokasi.edit') }}"
   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md inline-block mt-5">
    Checkout Payment
</a>


    @else
        {{-- Jika belum login, tampilkan tombol login --}}
        <a href="{{ route('login') }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded-md inline-block mt-10">
            Daftar/Login untuk Checkout
        </a>
    @endif
@endif