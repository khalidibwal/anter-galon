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

                    <form action="{{ route('cart.add') }}" method="POST" class="product-form flex flex-col items-start gap-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex items-center gap-2 mb-2">
                            <button type="button" class="decrease bg-gray-300 hover:bg-gray-400 text-gray-800 px-2 py-1 rounded">-</button>
                            <input type="number"
                                   name="qty"
                                   value="1"
                                   min="1"
                                   max="{{ $product->stock }}"
                                   class="qty-input w-16 border border-gray-300 rounded-md px-2 py-1 text-center focus:ring-blue-500 focus:border-blue-500 transition">
                            <button type="button" class="increase bg-gray-300 hover:bg-gray-400 text-gray-800 px-2 py-1 rounded">+</button>
                        </div>

                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded-md font-medium transition">
                            Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Ambil semua tombol + dan -
    const decreases = document.querySelectorAll('.decrease');
    const increases = document.querySelectorAll('.increase');

    decreases.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const form = e.target.closest('form');
            const input = form.querySelector('.qty-input');
            const min = parseInt(input.min) || 1;
            let value = parseInt(input.value) || 1;
            if(value > min) input.value = value - 1;
        });
    });

    increases.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const form = e.target.closest('form');
            const input = form.querySelector('.qty-input');
            const max = parseInt(input.max) || 999;
            let value = parseInt(input.value) || 1;
            if(value < max) input.value = value + 1;
        });
    });
});
</script>
