@extends('Component.Landing.Layout')

@section('content')
<div class="max-w-xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6 text-center">Pilih Metode Pembayaran</h2>

    <div class="grid grid-cols-1 gap-4">

        {{-- QRIS --}}
        <form action="{{ route('payment.qris') }}" method="POST">
            @csrf
            <button class="w-full text-left">
                <div class="flex items-center gap-4 p-4 border rounded-lg hover:bg-gray-100 transition">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/0b/QRIS_logo.svg"
                         class="h-10" alt="QRIS">
                    <div>
                        <h3 class="text-lg font-semibold">QRIS</h3>
                        <p class="text-gray-500 text-sm">Pembayaran cepat dengan QR</p>
                    </div>
                </div>
            </button>
        </form>

        {{-- BCA VA --}}
        <form action="{{ route('payment.bca') }}" method="POST">
            @csrf
            <button class="w-full text-left">
                <div class="flex items-center gap-4 p-4 border rounded-lg hover:bg-gray-100 transition">
                    <img src="https://seeklogo.com/images/B/bca-bank-central-asia-logo-51233C9D4B-seeklogo.com.png"
                         class="h-10" alt="BCA">
                    <div>
                        <h3 class="text-lg font-semibold">BCA Virtual Account</h3>
                        <p class="text-gray-500 text-sm">Transfer melalui BCA</p>
                    </div>
                </div>
            </button>
        </form>

        {{-- BNI VA --}}
        <form action="{{ route('payment.bni') }}" method="POST">
            @csrf
            <button class="w-full text-left">
                <div class="flex items-center gap-4 p-4 border rounded-lg hover:bg-gray-100 transition">
                    <img src="https://seeklogo.com/images/B/bni-bank-negara-indonesia-logo-0DB45C0F72-seeklogo.com.png"
                         class="h-10" alt="BNI">
                    <div>
                        <h3 class="text-lg font-semibold">BNI Virtual Account</h3>
                        <p class="text-gray-500 text-sm">Transfer melalui BNI</p>
                    </div>
                </div>
            </button>
        </form>

        {{-- BRI VA --}}
        <form action="{{ route('payment.bri') }}" method="POST">
            @csrf
            <button class="w-full text-left">
                <div class="flex items-center gap-4 p-4 border rounded-lg hover:bg-gray-100 transition">
                    <img src="https://seeklogo.com/images/B/BRI-logo-472DD7A6B8-seeklogo.com.png"
                         class="h-10" alt="BRI">
                    <div>
                        <h3 class="text-lg font-semibold">BRI Virtual Account</h3>
                        <p class="text-gray-500 text-sm">Transfer melalui BRI</p>
                    </div>
                </div>
            </button>
        </form>

        {{-- Permata VA --}}
        <form action="{{ route('payment.permata') }}" method="POST">
            @csrf
            <button class="w-full text-left">
                <div class="flex items-center gap-4 p-4 border rounded-lg hover:bg-gray-100 transition">
                    <img src="https://seeklogo.com/images/P/permata-bank-logo-338309C3D9-seeklogo.com.png"
                         class="h-10" alt="Permata">
                    <div>
                        <h3 class="text-lg font-semibold">Permata Virtual Account</h3>
                        <p class="text-gray-500 text-sm">Transfer melalui Permata</p>
                    </div>
                </div>
            </button>
        </form>

    </div>

</div>
@endsection
