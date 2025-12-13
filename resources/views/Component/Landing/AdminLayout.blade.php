<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-900 flex h-screen overflow-hidden text-slate-100">

    {{-- Sidebar Desktop --}}
    <aside class="bg-blue-950 w-64 hidden md:flex flex-col border-r border-blue-900">
        <div class="p-6 border-b border-blue-900">
            <h2 class="text-xl font-bold text-blue-400">
                Admin Panel
            </h2>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-1 text-sm">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2 rounded-md hover:bg-blue-900 hover:text-blue-300 transition">
                Dashboard
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="block px-4 py-2 rounded-md hover:bg-blue-900 hover:text-blue-300 transition">
                Produk
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="block px-4 py-2 rounded-md hover:bg-blue-900 hover:text-blue-300 transition">
                Pesanan
            </a>

            <a href="#"
               class="block px-4 py-2 rounded-md hover:bg-blue-900 hover:text-blue-300 transition">
                Pengguna
            </a>

            <a href="#"
               class="block px-4 py-2 rounded-md hover:bg-blue-900 hover:text-blue-300 transition">
                Laporan
            </a>
        </nav>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Header --}}
        <header class="bg-blue-900 border-b border-blue-800 px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-slate-100">
                @yield('page-title', 'Dashboard')
            </h1>

            <div class="flex items-center gap-4 text-sm">
                @if(auth('admin')->check())
                    <span class="text-slate-300">
                        {{ auth('admin')->user()->name }}
                    </span>

                    <form action="{{ route('logout.admin') }}" method="POST">
                        @csrf
                        <button
                            class="bg-red-600 px-3 py-1 rounded-md text-white hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                @endif
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6 bg-slate-900">
            @yield('content')
        </main>

    </div>
</body>
</html>
