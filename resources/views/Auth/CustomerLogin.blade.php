@extends('Component.Landing.Layout')

@section('content')
<div class="min-h-screen flex items-start justify-center pt-20 bg-gray-50 text-gray-800">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md mt-10">
        <h2 class="text-2xl font-bold mb-6 text-center">Login Akun</h2>

        {{-- Notifikasi sukses / error --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form login email/password --}}
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700">Password</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 rounded-md transition">
                Login
            </button>
        </form>

        {{-- Atau login dengan Google --}}
        <div class="mt-6 text-center">
            <span class="text-gray-500">atau</span>
        </div>

        <a href="{{ route('google.redirect') }}"
           class="w-full inline-flex justify-center items-center mt-4 bg-red-500 hover:bg-red-600 text-white font-medium py-2 rounded-md transition">
            <svg class="w-5 h-5 mr-2" viewBox="0 0 533.5 544.3">
                <path fill="#fff"
                      d="M533.5 278.4c0-18.2-1.5-35.7-4.3-52.7H272v99.7h146.9c-6.4 34.5-25.2 63.8-53.9 83.5v69.2h87.1c50.8-46.8 80.4-115.7 80.4-199.7z"/>
                <path fill="#fff"
                      d="M272 544.3c72.6 0 133.6-24.1 178.2-65.3l-87.1-69.2c-24.2 16.2-55.3 25.8-91.1 25.8-69.9 0-129.3-47.3-150.6-111.1H34.2v69.7c44.4 88.1 135.3 150.1 237.8 150.1z"/>
                <path fill="#fff"
                      d="M121.3 323.5c-10.5-31.5-10.5-65.8 0-97.3V156.5H34.2c-44.5 88.1-44.5 192.5 0 280.6l87.1-69.6z"/>
                <path fill="#fff"
                      d="M272 107.9c37.6 0 71.3 12.9 97.9 38.1l73.3-73.3C405.5 25.3 344.5 0 272 0 169.5 0 78.6 62 34.2 150.1l87.1 69.7c21.3-63.8 80.7-111.9 150.6-111.9z"/>
            </svg>
            Login dengan Google
        </a>

        <p class="mt-4 text-center text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Daftar di sini</a>
        </p>
    </div>

</div>
@endsection
