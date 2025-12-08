@extends('Component.Landing.Layout')
@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-10">
    <h1 class="text-2xl font-bold mb-10">Status Order #{{ $order->order_id }}</h1>

    <!-- Progress Bar -->
<div class="mb-20 relative mt-10" id="progress-bar-container">
    <!-- Background line -->
    <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-300 z-0 rounded"></div>

    <!-- Foreground line sampai current step -->
    <div class="absolute top-1/2 left-0 h-1 z-10 rounded"
         style="width: {{ $totalSteps > 1 ? ($currentStepIndex / ($totalSteps - 1) * 100) : 100 }}%;
                background: linear-gradient(to right, #22c55e {{ $currentStepIndex > 0 ? ($currentStepIndex / ($totalSteps - 1) * 100) : 0 }}%, #facc15 0%); 
                transform: translateY(-50%);">
    </div>

    <!-- Step Dots -->
    <div class="flex justify-between relative z-20">
        @foreach($deliverySteps as $key => $label)
            @php $stepIndex = $loop->index; @endphp
            <div class="flex flex-col items-center w-1/3">
                <div class="rounded-full w-8 h-8 flex items-center justify-center
                    @if($stepIndex < $currentStepIndex)
                        bg-green-500 text-white
                    @elseif($stepIndex == $currentStepIndex)
                        bg-yellow-400 text-white
                    @else
                        bg-gray-300 text-gray-500
                    @endif
                ">
                    {{ $stepIndex + 1 }}
                </div>
                <span class="text-xs mt-2 text-center
                    @if($stepIndex < $currentStepIndex)
                        text-green-600 font-semibold
                    @elseif($stepIndex == $currentStepIndex)
                        text-yellow-600 font-semibold
                    @else
                        text-gray-500
                    @endif
                ">
                    {{ $label }}
                </span>
            </div>
        @endforeach
    </div>
</div>



    <!-- Detail Order -->
    <div class="mb-6 space-y-2 mt-10">
        <p><strong>Total:</strong> Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</p>
        <p><strong>Payment Type:</strong> <span class="uppercase">{{ $order->payment_type ?? '-' }}</span></p>
        <p><strong>Payment Status:</strong> 
    <span class="font-semibold">
        {{ $order->status === 'settlement' ? 'Lunas' : ucfirst($order->status) }}
    </span>
</p>

        <p><strong>Delivery Status:</strong> <span class="font-semibold">{{ ucfirst($order->delivery_status) }}</span></p>
        <p>
            <strong>Order ID:</strong> 
            <span class="block sm:inline break-all sm:break-words overflow-x-auto whitespace-nowrap">
                {{ $order->order_id ?? '-' }}
            </span>
        </p>
        <p><strong>Delivery Address:</strong> {{ $order->alamat }}{{ $order->detail_alamat ? ', '.$order->detail_alamat : '' }}</p>
        <p><strong>Delivery Time:</strong> {{ $order->waktu_pengantaran ? \Carbon\Carbon::parse($order->waktu_pengantaran)->format('d M Y H:i') : '-' }}</p>
    </div>
</div>

@endsection

<script>
const orderId = "{{ $order->id }}";

function updateProgressBar() {
    fetch(`/order/${orderId}/status`)
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('progress-bar-container');
            const steps = Object.values(data.deliverySteps);
            const currentIndex = data.currentStepIndex;
            const totalSteps = steps.length;

            let html = `
            <div class="relative mb-10">
                <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-300 z-0 rounded"></div>
                <div class="absolute top-1/2 left-0 h-1 z-10 rounded"
                     style="width: ${totalSteps > 1 ? (currentIndex/(totalSteps-1)*100) : 100}%;
                            transform: translateY(-50%);
                            background: linear-gradient(to right, #22c55e ${currentIndex > 0 ? (currentIndex/(totalSteps-1)*100) : 0}%, #facc15 0%);
                     ">
                </div>
                <div class="flex justify-between relative z-20">
            `;
            steps.forEach((label, i) => {
                let circleClass = 'bg-gray-300 text-gray-500';
                let textClass = 'text-gray-500';
                if (i < currentIndex) {
                    circleClass = 'bg-green-500 text-white';
                    textClass = 'text-green-600 font-semibold';
                } else if (i == currentIndex) {
                    circleClass = 'bg-yellow-400 text-white';
                    textClass = 'text-yellow-600 font-semibold';
                }
                html += `
                <div class="flex flex-col items-center w-1/3">
                    <div class="rounded-full w-8 h-8 flex items-center justify-center ${circleClass}">
                        ${i+1}
                    </div>
                    <span class="text-xs mt-2 text-center ${textClass}">${label}</span>
                </div>`;
            });
            html += `</div></div>`;
            container.innerHTML = html;
        });
}

// polling setiap 5 detik
setInterval(updateProgressBar, 5000);
updateProgressBar();
</script>