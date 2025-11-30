<header class="bg-gradient-to-r from-blue-700 to-blue-500 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        {{-- Logo diganti tulisan --}}
        <div class="text-2xl md:text-3xl font-extrabold tracking-tight text-center">
            Pembayaran
        </div>

        {{-- Tombol Menu (Mobile) --}}
       
    </div>
</header>

{{-- Script Toggle Menu --}}
<script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
