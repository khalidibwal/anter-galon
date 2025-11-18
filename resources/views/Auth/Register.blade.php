@extends('Component.Landing.Layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 sm:py-16 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-white p-6 sm:p-8 rounded-2xl shadow-md sm:shadow-xl space-y-6 sm:space-y-8">
        
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Daftar Sebagai Mitra</h2>
            <p class="mt-2 text-sm sm:text-base text-gray-500">Isi formulir di bawah untuk bergabung</p>
        </div>

        <!-- Error Handling -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                <strong class="font-semibold">Terjadi kesalahan!</strong>
                <ul class="list-disc pl-4 mt-1 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('users_galon.store') }}" method="POST" class="space-y-5 sm:space-y-6">
            @csrf

            <!-- Nama -->
            <div>
                <label for="name" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" id="name"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 px-3 py-2 sm:px-4 sm:py-3 text-gray-800 text-sm sm:text-base"
                    maxlength="100" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 px-3 py-2 sm:px-4 sm:py-3 text-gray-800 text-sm sm:text-base"
                    maxlength="100" required>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" id="password"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 px-3 py-2 sm:px-4 sm:py-3 text-gray-800 text-sm sm:text-base"
                    maxlength="255" required>
            </div>

            <!-- Telepon -->
            <div>
                <label for="phone" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Telepon</label>
                <input type="text" name="phone" id="phone"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 px-3 py-2 sm:px-4 sm:py-3 text-gray-800 text-sm sm:text-base"
                    maxlength="20">
            </div>

            <!-- Peran -->
            <div>
                <label for="role" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Peran</label>
                <select name="role" id="role"
                    class="w-full rounded-lg border-gray-300 bg-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 px-3 py-2 sm:px-4 sm:py-3 text-gray-800 text-sm sm:text-base"
                    required>
                    <option value="customer" selected>Pelanggan</option>
                    <option value="admin">Admin</option>
                    <option value="courier">Kurir</option>
                </select>
            </div>

            <!-- Tombol -->
            <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2.5 sm:py-3 rounded-lg shadow-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition duration-200 text-sm sm:text-base">
                Simpan
            </button>

            <p class="text-center text-xs sm:text-sm text-gray-500 mt-3">
                Sudah punya akun? 
                <a href="{{ route('galon.auth') }}" class="text-blue-600 hover:underline">Masuk di sini</a>
            </p>
        </form>
    </div>
</div>
@endsection
