@extends('Component.Landing.PaymentLayout')
@section('content')

<div class="max-w-sm w-full mx-auto mt-8 bg-white shadow-md rounded-xl p-5 sm:p-6">
    <h2 class="text-lg sm:text-xl font-bold text-center mb-5">Virtual Account / QRIS</h2>

    <div class="space-y-4">

        {{-- Bank / Metode --}}
        <div class="flex justify-between items-center border-b pb-2">
            <span class="text-gray-600 text-sm sm:text-base">Bank / Metode</span>
            <span class="font-semibold text-sm sm:text-base">
                {{ $charge->va_numbers[0]->bank ?? (isset($charge->permata_va) ? 'Permata' : (isset($charge->qr_string) ? 'QRIS' : 'Lainnya')) }}
            </span>
        </div>

        {{-- VA / QRIS Number --}}
        <div class="flex justify-between items-center border-b pb-2">
            <span class="text-gray-600 text-sm sm:text-base">Nomor</span>
            <span class="font-semibold text-blue-600 text-sm sm:text-base">
                @if(isset($charge->va_numbers[0]->va_number))
                    {{ $charge->va_numbers[0]->va_number }}
                @elseif(isset($charge->permata_va?->va_number))
                    {{ $charge->permata_va->va_number }}
                @elseif(isset($charge->qr_string))
                    {{ $charge->qr_string }}
                @else
                    -
                @endif
            </span>
        </div>

        {{-- Biaya Admin --}}
        <div class="flex justify-between items-center border-b pb-2">
            <span class="text-gray-600 text-sm sm:text-base">Biaya Admin</span>
            <span class="font-semibold text-red-600 text-sm sm:text-base">
                Rp 200
            </span>
        </div>

        {{-- Total Bayar --}}
        <div class="flex justify-between items-center border-b pb-2">
            <span class="text-gray-600 text-sm sm:text-base">Total Bayar</span>
            <span class="font-bold text-green-600 text-sm sm:text-base">
                Rp {{ number_format($charge->gross_amount) }}
            </span>
        </div>

        {{-- Status --}}
        <div class="flex justify-between items-center">
            <span class="text-gray-600 text-sm sm:text-base">Status</span>
            <span class="font-semibold text-sm sm:text-base 
                @if($charge->transaction_status === 'pending') text-yellow-600 
                @elseif($charge->transaction_status === 'settlement') text-green-600
                @else text-gray-700 @endif">
                {{ ucfirst($charge->transaction_status) }}
            </span>
        </div>
    </div>

    {{-- Copy Button --}}
    <div class="mt-5 text-center">
        <button id="copyButton"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm sm:text-base hover:bg-blue-700 transition">
            Copy Nomor
        </button>
    </div>

    <div class="mt-3 text-center text-green">
        <p id="copyMessage" class="text-xs sm:text-sm text-gray-500 hidden">Nomor telah disalin</p>
    </div>
</div>

<script>
const copyButton = document.getElementById('copyButton');
const copyMessage = document.getElementById('copyMessage');

// Tentukan nomor VA / QRIS dengan aman
let vaNumber = '-';
@if(isset($charge->va_numbers[0]->va_number))
    vaNumber = '{{ $charge->va_numbers[0]->va_number }}';
@elseif(isset($charge->permata_va?->va_number))
    vaNumber = '{{ $charge->permata_va->va_number }}';
@elseif(isset($charge->qr_string))
    vaNumber = '{{ $charge->qr_string }}';
@endif

copyButton.addEventListener('click', () => {
    navigator.clipboard.writeText(vaNumber).then(() => {
        copyMessage.classList.remove('hidden');
    }).catch(err => console.error('Gagal menyalin: ', err));
});
</script>

@endsection
