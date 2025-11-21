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