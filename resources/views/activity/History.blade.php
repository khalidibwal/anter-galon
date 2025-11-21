<div class="container my-5">
    <h2 class="mb-4 text-center">Order History</h2>

    @if($orderItems->isEmpty())
        <p class="text-center">No orders found.</p>
    @else
        @php
            // Group order items berdasarkan order_id
            $ordersGrouped = $orderItems->groupBy('order_id');
        @endphp

        @foreach($ordersGrouped as $orderId => $items)
            <div class="mb-5">
                <h4 class="mb-3">Order ID: {{ $orderId }}</h4>

                <div class="row">
                    @php $total = 0; @endphp
                    @foreach($items as $item)
                        @php $total += $item->subtotal; @endphp
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm rounded-4 border border-dark">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->product->name ?? 'Unknown Product' }}</h5>
                                    <p class="card-text mb-1"><strong>Quantity:</strong> {{ $item->quantity }}</p>
                                    <p class="card-text mb-1"><strong>Price:</strong> Rp{{ number_format($item->price, 2) }}</p>
                                    <p class="card-text mb-1"><strong>Subtotal:</strong> Rp{{ number_format($item->subtotal, 2) }}</p>
                                    <p class="card-text"><small class="text-muted">Created at: {{ $item->created_at->format('d M Y H:i') }}</small></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card mt-2">
                    <div class="card-body text-end">
                        <h5>Total for Order {{ $orderId }}: Rp{{ number_format($total, 2) }}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
