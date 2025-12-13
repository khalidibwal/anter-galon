@extends('Component.Landing.AdminLayout')

@section('title', 'Orders')
@section('page-title', 'Order List')

@section('content')

{{-- Alert --}}
@if(session('success'))
    <div class="mb-4 rounded-md bg-green-900/40 px-4 py-3 text-sm text-green-300">
        {{ session('success') }}
    </div>
@endif

<div class="bg-blue-950 rounded-lg shadow border border-blue-900 overflow-x-auto">
    <table class="min-w-full divide-y divide-blue-900 text-sm">
        <thead class="bg-blue-900/40 text-slate-300">
            <tr>
                <th class="px-4 py-3 text-left">Order ID</th>
                <th class="px-4 py-3 text-left">Customer</th>
                <th class="px-4 py-3 text-left">Total</th>
                <th class="px-4 py-3 text-left">Delivery Status</th>
                <th class="px-4 py-3 text-center">Action</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-blue-900">
            @forelse($orders as $order)
                <tr class="hover:bg-blue-900/30 transition">
                    <td class="px-4 py-3 text-slate-200">
                        {{ $order->order_id }}
                    </td>

                    <td class="px-4 py-3 text-slate-300">
                        {{ $order->user->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-slate-300">
                        Rp {{ number_format($order->gross_amount) }}
                    </td>

                    <td class="px-4 py-3">
                        <form action="{{ route('orders.updateDeliveryStatus', $order) }}"
                              method="POST"
                              class="flex items-center gap-2">
                            @csrf
                            @method('PUT')

                            <select name="delivery_status"
                                    class="rounded-md bg-blue-900 border border-blue-800
                                           px-3 py-1 text-sm text-slate-200
                                           focus:ring focus:ring-blue-500">

                                <option value="on_the_way"
                                    {{ $order->delivery_status === 'on_the_way' ? 'selected' : '' }}>
                                    kurir ambil galon
                                </option>

                                <option value="refill"
                                    {{ $order->delivery_status === 'refill' ? 'selected' : '' }}>
                                    Sedang mengisi galon
                                </option>

                                <option value="delivering"
                                    {{ $order->delivery_status === 'delivering' ? 'selected' : '' }}>
                                    galon Sedang Diantar
                                </option>

                                <option value="done"
                                    {{ $order->delivery_status === 'done' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                            </select>
                    </td>

                    <td class="px-4 py-3 text-center">
                            <button type="submit"
                                    class="rounded-md bg-blue-600 px-3 py-1.5 text-xs
                                           font-medium text-white hover:bg-blue-700 transition">
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5"
                        class="px-4 py-6 text-center text-slate-400">
                        No orders found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-4 flex justify-center">
    {{ $orders->links() }}
</div>

@endsection
