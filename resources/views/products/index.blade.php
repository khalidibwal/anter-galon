@extends('Component.Landing.Layout')

@section('content')
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    {{-- Tabs --}}
    <div class="max-w-6xl mx-auto px-4 py-6">
        <div class="flex border-b border-gray-200 space-x-6 relative">
            <button 
                class="tab-btn py-2 px-6 font-medium text-gray-600 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-400 transition duration-300 ease-in-out"
                id="tab1Button" onclick="openTab('tab1')">
                Pilih Produk
            </button>
            <button 
                class="tab-btn py-2 px-6 font-medium text-gray-600 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-400 transition duration-300 ease-in-out"
                id="tab2Button" onclick="openTab('tab2')">
                Riwayat
            </button>
            <button class="tab-btn py-2 px-6 font-medium text-gray-600 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-400 transition duration-300 ease-in-out" 
            id="tab3Button" onclick="openTab('tab3')">
    Status Pesanan
</button>

        </div>
    </div>

    {{-- Tab Contents --}}
    <main class="flex-1 max-w-6xl mx-auto px-4 py-6">
        {{-- Tab 1 --}}
        <div id="tab1" class="tab-content">
            @include('products.Component.Notification')
            @include('products.Component.ProductList')
            @include('products.Component.CartTable')
        </div>

        {{-- Tab 2 --}}
        <div id="tab2" class="tab-content hidden">
            @include('activity.History')
        </div>
        {{-- Tab 3 --}}
  
<div id="tab3" class="tab-content hidden">
    @if($orders && $orders->count() > 0)
        @include('order.orderList')
    @else
        <p class="text-gray-500">Belum ada order yang tersedia.</p>
    @endif
</div>


    </main>

    @extends('products.Component.Modal.Delete')

    <script>
        function openTab(tabId) {
            // Hide all tab contents
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.add('hidden'));

            // Reset all buttons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => {
                btn.classList.remove('border-blue-500', 'text-blue-600', 'font-semibold');
                btn.classList.add('border-transparent', 'text-gray-600', 'font-medium');
            });

            // Show selected tab content
            document.getElementById(tabId).classList.remove('hidden');

            // Highlight the selected tab
            const selectedButton = document.getElementById(tabId + 'Button');
            selectedButton.classList.add('border-blue-500', 'text-blue-600', 'font-semibold');
            selectedButton.classList.remove('border-transparent', 'text-gray-600', 'font-medium');
        }

        // Initialize default tab
        document.addEventListener('DOMContentLoaded', () => {
            openTab('tab1');
        });
    </script>

   <script>
    function openDeleteModal(productId) {
        const modal = document.getElementById('deleteModal');
        const input = document.getElementById('deleteProductId');
        input.value = productId; // set product_id
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>



</body>
@endsection
