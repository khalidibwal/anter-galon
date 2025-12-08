@extends('Component.Landing.AdminLayout')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-6">
        
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Login Admin
        </h2>

        {{-- ALERT ERROR --}}
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 text-sm rounded">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label class="text-gray-700 font-medium text-sm">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email Admin"
                    required
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                           focus:ring-blue-500 focus:border-blue-500 outline-none"
                >
            </div>

            {{-- Password --}}
            <div>
                <label class="text-gray-700 font-medium text-sm">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password"
                    required
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 
                           focus:ring-blue-500 focus:border-blue-500 outline-none"
                >
            </div>

            {{-- Submit Button --}}
            <button 
                type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold 
                       hover:bg-blue-700 transition"
            >
                Login Admin
            </button>

        </form>
    </div>
</div>
@endsection