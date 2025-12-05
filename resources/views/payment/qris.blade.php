@extends('Component.Landing.PaymentLayout')
@section('content')

<div class="max-w-md mx-auto bg-white shadow-lg rounded-xl p-6 mt-10">

    <h2 class="text-2xl font-bold text-center mb-4">Scan QRIS untuk Membayar</h2>

    <div class="flex justify-center mb-4">
        <img src="{{ $charge->actions[0]->url }}" 
             alt="QRIS" 
             class="w-64 rounded-lg shadow">
    </div>

    <div class="text-center space-y-1 mb-4">
        <p class="font-semibold text-gray-700">Order ID: {{ $charge->order_id }}</p>

        <!-- Detail harga -->
        @php
            $totalAmount = $charge->gross_amount; // total dari Midtrans
            $adminFee = 200; // biaya admin
            $subtotal = $totalAmount - $adminFee;
        @endphp

        <p class="text-gray-600 text-sm">Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
        <p class="text-gray-600 text-sm">Biaya Admin: Rp {{ number_format($adminFee, 0, ',', '.') }}</p>

        <p class="text-lg font-bold text-green-600">
            Total: Rp {{ number_format($totalAmount, 0, ',', '.') }}
        </p>
    </div>

    <!-- Countdown Timer -->
    <div class="text-center mb-4">
        <p class="text-gray-600">QR kadaluarsa dalam:</p>
        <p id="countdown" class="text-2xl font-bold text-red-600">--:--</p>
    </div>

    <!-- Status -->
    <div class="text-center">
        <p class="text-gray-700">Status Pembayaran:</p>
        <p id="payment-status"
            class="text-xl font-bold text-blue-600">
            Menunggu pembayaran...
        </p>
    </div>
</div>
@endsection

<script>
    // === COUNTDOWN EXPIRE: 30 menit ===
    let expiryMinutes = 30;
    let expiryTime = new Date().getTime() + expiryMinutes * 60 * 1000;

    function updateCountdown() {
        let now = new Date().getTime();
        let diff = expiryTime - now;

        if (diff <= 0) {
            document.getElementById("countdown").innerHTML = "Expired";
            document.getElementById("payment-status").innerHTML = "QR Kadaluarsa";
            document.getElementById("payment-status").classList.add("text-red-600");
            return;
        }

        let m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        let s = Math.floor((diff % (1000 * 60)) / 1000);

        document.getElementById("countdown").innerHTML =
            (m < 10 ? "0"+m : m) + ":" + (s < 10 ? "0"+s : s);
    }

    setInterval(updateCountdown, 1000);

    // === REALTIME CEK PEMBAYARAN ===
    // === REALTIME CEK PEMBAYARAN ===
function checkPayment() {
    fetch("/payment/status/{{ $charge->order_id }}")
        .then(res => res.json())
        .then(res => {
            if (res.status === "settlement" || res.status === "success") {

                document.getElementById("payment-status").innerHTML =
                    "Pembayaran Berhasil ✓";

                document.getElementById("payment-status").classList
                    .remove("text-blue-600");
                document.getElementById("payment-status").classList
                    .add("text-green-600");

                // Redirect ke halaman status order
                setTimeout(() => {
                    window.location.href = "{{ route('orders.show', $charge->order_id) }}";
                }, 1500);
            }
        });
}


    setInterval(checkPayment, 2000); // cek tiap 2 detik
</script>
