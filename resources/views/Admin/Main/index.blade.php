@extends('Component.Landing.AdminLayout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold text-gray-700">Total Produk</h2>
        <p class="text-2xl mt-2">50</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold text-gray-700">Total Pesanan</h2>
        <p class="text-2xl mt-2">120</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold text-gray-700">Total Pengguna</h2>
        <p class="text-2xl mt-2">200</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold text-gray-700">Pendapatan</h2>
        <p class="text-2xl mt-2">Rp 25.000.000</p>
    </div>
</div>
@endsection
