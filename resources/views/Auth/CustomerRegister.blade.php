@extends('Component.Landing.Layout')

@section('content')
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white w-full max-w-md p-8 rounded-xl shadow">

        <h2 class="text-2xl font-bold text-center mb-6">✨ Daftar Akun Baru</h2>

        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc ml-4 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Notifikasi Success --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="name" required
                       class="w-full border rounded p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" required
                       class="w-full border rounded p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Alamat --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Alamat</label>
                <textarea name="alamat" rows="3" required
                          class="w-full border rounded p-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full border rounded p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border rounded p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md font-semibold">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Sudah punya akun?  
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login di sini</a>
        </p>

    </div>

</body>
@endsection
