<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        
        // Ambil alamat terbaru user, kalau belum ada, NULL
        $alamat = $user->addresses()->latest()->first();

        return view('Location.UserLocation', compact('user', 'alamat'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'latitude'           => 'required|numeric',
            'longitude'          => 'required|numeric',
            'detail_alamat'      => 'nullable|string',
            'waktu_pengantaran'  => 'nullable|date',
            'alamat'             => 'nullable|string',
            'label'              => 'nullable|string|max:50',
        ]);

        UserAddress::create([
            'user_id'           => Auth::id(),
            'latitude'          => $request->latitude,
            'longitude'         => $request->longitude,
            'alamat'            => $request->alamat,
            'detail_alamat'     => $request->detail_alamat,
            'waktu_pengantaran' => $request->waktu_pengantaran,
            'label'             => $request->label,
        ]);

        return redirect()->route('payment.redirect');
    }
}
