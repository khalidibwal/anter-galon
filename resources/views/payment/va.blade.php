@extends('Component.Landing.PaymentLayout')
@section('content')

<div class="max-w-sm w-full mx-auto mt-8 bg-white shadow-md rounded-xl p-5 sm:p-6">

    <h2 class="text-lg sm:text-xl font-bold text-center mb-5">Virtual Account</h2>

    <div class="space-y-4">

        {{-- Bank --}}
        <div class="flex justify-between items-center border-b pb-2">
            <span class="text-gray-600 text-sm sm:text-base">Bank</span>
            <span class="font-semibold text-sm sm:text-base">{{ strtoupper($charge->va_numbers[0]->bank) }}</span>
        </div>

        {{-- VA Number --}}
        <div class="flex justify-between items-center border-b pb-2">
            <span class="text-gray-600 text-sm sm:text-base">VA Number</span>
            <span class="font-semibold text-blue-600 text-sm sm:text-base">
                {{ $charge->va_numbers[0]->va_number }}
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

    {{-- Copy VA Number Button --}}
    <div class="mt-5 text-center">
        <button id="copyButton"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm sm:text-base hover:bg-blue-700 transition">
            Copy VA Number
        </button>
    </div>

    {{-- Teks hanya muncul setelah copy --}}
    <div class="mt-3 text-center text-green">
        <p id="copyMessage" class="text-xs sm:text-sm text-gray-500 hidden">Virtual account telah di salin</p>
    </div>

</div>

{{-- Script untuk menampilkan teks setelah copy --}}
<script>
    const copyButton = document.getElementById('copyButton');
    const copyMessage = document.getElementById('copyMessage');

    copyButton.addEventListener('click', () => {
        const vaNumber = '{{ $charge->va_numbers[0]->va_number }}';
        navigator.clipboard.writeText(vaNumber).then(() => {
            copyMessage.classList.remove('hidden');
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
        });
    });
</script>

@endsection
