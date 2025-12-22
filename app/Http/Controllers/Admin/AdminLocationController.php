<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAddress;
use App\Models\UserDepot;

class AdminLocationController extends Controller
{
    public function edit()
    {
        // Ambil alamat depot (label = depot)
        $depot = UserAddress::where('label', 'depot')->first();

        return view('Admin.Maps.index', compact('depot'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // Update atau buat alamat depot
        $depot = UserAddress::updateOrCreate(
            [
                'label' => 'depot',
                'user_id' => Auth::guard('admin')->id(), // Menyaring berdasarkan user_id admin yang sedang login
            ],
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'alamat' => $request->alamat,
                'detail_alamat' => $request->detail_alamat,
            ]
        );

        // Pastikan data depot di tabel user_depots diperbarui atau dibuat
        // Menggunakan ID depot (UserAddress) sebagai depot_id di tabel user_depots
        UserDepot::updateOrCreate(
            [
                'user_id' => Auth::guard('admin')->id(), // User yang sedang login
                'depot_id' => $depot->id, // Menggunakan ID depot dari UserAddress yang baru saja disimpan
            ]
        );

        return back()->with('success', 'Lokasi depot berhasil disimpan');
    }
}
