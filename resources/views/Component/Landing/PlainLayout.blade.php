<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6 bg-slate-900">
            @yield('content')
        </main>

    </div>
</body>
</html>
