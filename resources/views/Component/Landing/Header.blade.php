<header class="bg-gradient-to-r from-blue-700 to-blue-500 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        {{-- Logo --}}
        <a href="{{ route('antar.galon') }}" class="text-2xl md:text-3xl font-extrabold tracking-tight flex items-center gap-2">
            <img style="width: 170px; height: 150px; object-fit: contain;" src="{{ asset('images/Logo/logo-refilin3.png') }}" alt="Gambar">
        </a>

        {{-- Tombol Menu (Mobile) --}}
        <button id="menu-toggle" class="md:hidden focus:outline-none focus:ring-2 focus:ring-white p-2 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- Navigasi Desktop --}}
        <nav id="nav-menu" class="hidden md:flex space-x-8 text-lg font-medium">
            <a href="{{ route('antar.galon') }}" class="hover:text-blue-200 transition duration-300">Beranda</a>
            <a href="#layanan" class="hover:text-blue-200 transition duration-300">Layanan</a>
            <a href="{{ route('galon.auth') }}"
                class="bg-white text-blue-700 px-5 py-2 rounded-full hover:bg-blue-100 transition duration-300 shadow-md font-semibold">
                Daftar
            </a>
        </nav>
    </div>

    {{-- Navigasi Mobile --}}
    <div id="mobile-menu" class="hidden md:hidden bg-blue-600 border-t border-blue-500">
        <nav class="flex flex-col items-center space-y-3 py-4 text-lg">
            <a href="{{ route('antar.galon') }}" class="hover:text-blue-200 transition duration-300">Beranda</a>
            <a href="#layanan" class="hover:text-blue-200 transition duration-300">Layanan</a>
            <a href="{{ route('galon.auth') }}"
                class="bg-white text-blue-700 px-5 py-2 rounded-full hover:bg-blue-100 transition duration-300 shadow-md font-semibold">
                Daftar
            </a>
        </nav>
    </div>
</header>

{{-- Script Toggle Menu --}}
<script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
