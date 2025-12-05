<div class="space-y-4">
    @forelse($orders as $order)
        <div class="p-4 bg-white rounded shadow flex justify-between items-center">
            <div>
                <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
                <p><strong>User:</strong> {{ $order->user->name ?? '-' }}</p>
                <p><strong>Amount:</strong> Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Delivery Status:</strong> {{ ucfirst($order->delivery_status) }}</p>
            </div>
            <div>
                <a href="{{ route('order.show', $order->id) }}" 
                   class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                   Lihat Detail
                </a>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Belum ada order yang tersedia.</p>
    @endforelse
</div>
