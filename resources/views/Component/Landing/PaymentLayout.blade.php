<!-- resources/views/Component/Landing/Layout.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Isi Ulang Galon</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-blue-50 font-sans text-gray-800">

    {{-- Header --}}
    @include('Component.Landing.PaymentHeader')

    {{-- Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('Component.Landing.Footer')

</body>
</html>
