@extends('Component.Landing.AdminLayout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-blue-900 p-4 rounded shadow border border-blue-800">
        <h2 class="font-semibold text-slate-200">Total Produk</h2>
        <p class="text-2xl mt-2 font-bold text-slate-100">{{ $totalProducts }}</p>
    </div>

    <div class="bg-blue-900 p-4 rounded shadow border border-blue-800">
        <h2 class="font-semibold text-slate-200">Total Pesanan</h2>
        <p class="text-2xl mt-2 font-bold text-slate-100">{{ $totalOrders }}</p>
    </div>

    <div class="bg-blue-900 p-4 rounded shadow border border-blue-800">
        <h2 class="font-semibold text-slate-200">Total Pengguna</h2>
        <p class="text-2xl mt-2 font-bold text-slate-100">{{ $totalUsers }}</p>
    </div>

    <div class="bg-blue-900 p-4 rounded shadow border border-blue-800">
        <h2 class="font-semibold text-slate-200">Pendapatan</h2>
        <p class="text-2xl mt-2 font-bold text-slate-100">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="mt-6 bg-blue-900 p-4 rounded shadow border border-blue-800">
    <h2 class="text-slate-200 font-semibold mb-4">Pendapatan per Bulan</h2>
    <canvas id="revenueBarChart" class="bg-blue-900"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueBarChart').getContext('2d');
const revenueBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            @foreach(range(1,12) as $m)
                "{{ \Carbon\Carbon::create()->month($m)->format('M') }}",
            @endforeach
        ],
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: [
                @foreach(range(1,12) as $m)
                    {{ $monthlyRevenue[$m] ?? 0 }},
                @endforeach
            ],
            backgroundColor: '#3b82f6',
            hoverBackgroundColor: '#60a5fa',
            borderRadius: 6, // Membuat sudut bar melengkung
            barPercentage: 0.6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: { color: '#e0f2fe', font: { weight: 'bold' } }
            },
            tooltip: {
                backgroundColor: '#1e3a8a',
                titleColor: '#fff',
                bodyColor: '#fff',
                padding: 10,
                cornerRadius: 6,
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: {
            x: {
                ticks: { color: '#e0f2fe', font: { weight: 'bold' } },
                grid: { color: 'rgba(255,255,255,0.1)' }
            },
            y: {
                ticks: {
                    color: '#e0f2fe',
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                },
                grid: { color: 'rgba(255,255,255,0.1)' }
            }
        }
    }
});
</script>


</div>
@endsection
