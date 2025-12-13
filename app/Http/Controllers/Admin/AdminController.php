<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function dashboard()
{
    // Data untuk cards
    $totalProducts = Product::count();
    $totalOrders = Order::count();
    $totalUsers = User::count();
    $totalRevenue = Order::sum('gross_amount');

    // Data chart: pendapatan per bulan tahun ini
    $monthlyRevenue = Order::select(
            DB::raw('MONTH(waktu_pengantaran) as month'),
            DB::raw('SUM(gross_amount) as total')
        )
        ->whereYear('waktu_pengantaran', now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month'); // key: month, value: total

    return view('Admin.dashboard', compact(
        'totalProducts', 
        'totalOrders', 
        'totalUsers', 
        'totalRevenue',
        'monthlyRevenue'
    ));
}
}

