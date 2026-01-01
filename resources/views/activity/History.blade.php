


<div class="max-w-6xl mx-auto px-4 py-10">

    <h1 class="text-2xl font-bold mb-6">Riwayat Pesanan</h1>

    @if($orders->count() === 0)
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            Belum ada pesanan.
        </div>
    @else

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pembayaran</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @foreach($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-mono text-gray-800">
                        {{ $order->order_id }}
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-600">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </td>

                    <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                        Rp {{ number_format($order->gross_amount, 0, ',', '.') }}
                    </td>

                    <td class="px-4 py-3 text-sm uppercase text-gray-600">
                        {{ $order->payment_type ?? '-' }}
                    </td>

                    <td class="px-4 py-3">
                        {{-- Payment Status --}}
                        @php
                            $statusColor = match($order->status) {
                                'settlement', 'paid' => 'bg-green-100 text-green-700',
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'failed', 'expired' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-600'
                            };
                        @endphp

                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $statusColor }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('order.show', $order->id) }}"
                           class="inline-block text-sm px-4 py-1.5 rounded bg-blue-500 text-white hover:bg-blue-600">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    @endif
</div>

