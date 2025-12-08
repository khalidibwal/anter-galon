<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <div class="bg-white w-64 flex-shrink-0 hidden md:flex flex-col shadow-lg">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800">Admin Panel</h2>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="" class="block px-4 py-2 rounded hover:bg-gray-200">Dashboard</a>
            <a href="" class="block px-4 py-2 rounded hover:bg-gray-200">Produk</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Pesanan</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Pengguna</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Laporan</a>
        </nav>
    </div>

    {{-- Mobile sidebar toggle --}}
    <div class="md:hidden flex-shrink-0">
        <button id="menu-btn" class="p-4 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    {{-- Mobile sidebar overlay --}}
    <div id="mobile-menu" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden md:hidden"></div>

    {{-- Mobile sidebar content --}}
    <div id="mobile-sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 z-50 md:hidden">
        <div class="p-6 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Admin Panel</h2>
            <button id="close-btn" class="text-gray-600 hover:text-gray-800">
                ✕
            </button>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="" class="block px-4 py-2 rounded hover:bg-gray-200">Dashboard</a>
            <a href="" class="block px-4 py-2 rounded hover:bg-gray-200">Produk</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Pesanan</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Pengguna</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-200">Laporan</a>
        </nav>
    </div>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col overflow-auto">
        {{-- Header --}}
        <header class="flex justify-between items-center bg-white shadow px-6 py-4">
            <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Selamat datang, {{ auth()->user()->name }}</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Logout</button>
                </form>
            </div>
        </header>

        {{-- Content --}}
        <main class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Example cards --}}
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="font-bold text-gray-700">Total Produk</h2>
                    <p class="text-2xl mt-2">50</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="font-bold text-gray-700">Total Pesanan</h2>
                    <p class="text-2xl mt-2">120</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="font-bold text-gray-700">Total Pengguna</h2>
                    <p class="text-2xl mt-2">200</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="font-bold text-gray-700">Pendapatan</h2>
                    <p class="text-2xl mt-2">Rp 25.000.000</p>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-lg font-bold mb-2">Aktivitas Terbaru</h2>
                <div class="bg-white rounded shadow p-4">
                    <ul class="space-y-2">
                        <li>Admin menambahkan produk "Galon Aqua 19L"</li>
                        <li>User membuat pesanan #12345</li>
                        <li>Admin memperbarui stock produk "Galon Le Minerale"</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>

    {{-- Script toggle mobile sidebar --}}
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const closeBtn = document.getElementById('close-btn');

        menuBtn.addEventListener('click', () => {
            mobileSidebar.classList.remove('-translate-x-full');
            mobileMenu.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
            mobileMenu.classList.add('hidden');
        });

        mobileMenu.addEventListener('click', () => {
            mobileSidebar.classList.add('-translate-x-full');
            mobileMenu.classList.add('hidden');
        });
    </script>
</body>
</html>
