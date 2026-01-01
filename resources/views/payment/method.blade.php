@extends('Component.Landing.Layout')

@section('content')
<div class="max-w-xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6 text-center">Pilih Metode Pembayaran</h2>

    <div class="grid grid-cols-1 gap-4">

        @php
    $paymentMethods = [
        [
            'type' => 'qris',
            'name' => 'QRIS',
            'desc' => 'Pembayaran cepat dengan QR',
            'logo' => asset('images/payment/bca.png')
        ],
        [
            'type' => 'bca',
            'name' => 'BCA Virtual Account',
            'desc' => 'Transfer melalui BCA',
            'logo' => asset('images/payment/bca.png')
        ],
        [
            'type' => 'bni',
            'name' => 'BNI Virtual Account',
            'desc' => 'Transfer melalui BNI',
            'logo' => asset('images/payment/bni.png')
        ],
        [
            'type' => 'bri',
            'name' => 'BRI Virtual Account',
            'desc' => 'Transfer melalui BRI',
            'logo' => asset('images/payment/bri.png')
        ],
        [
            'type' => 'permata',
            'name' => 'Permata Virtual Account',
            'desc' => 'Transfer melalui Permata',
            'logo' => asset('images/payment/permata.png')
        ],
    ];
@endphp


        @foreach($paymentMethods as $method)
<form action="{{ route('payment.process') }}" method="POST">
    @csrf
    <input type="hidden" name="payment_type" value="{{ $method['type'] }}">
    <button type="submit" class="w-full text-left focus:outline-none">
        <div class="flex items-center gap-4 p-4 border rounded-lg hover:bg-gray-100 transition">
            <img src="{{ $method['logo'] }}" class="h-10" alt="{{ $method['name'] }}">
            <div>
                <h3 class="text-lg font-semibold">{{ $method['name'] }}</h3>
                <p class="text-gray-500 text-sm">{{ $method['desc'] }}</p>
            </div>
        </div>
    </button>
</form>
@endforeach


    </div>

</div>
@endsection
