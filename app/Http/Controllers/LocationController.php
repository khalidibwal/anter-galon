<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
 public function edit()
    {
        $user = Auth::user();
        return view('Location.UserLocation', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $user = Auth::user();
        $user->latitude  = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

        return redirect()->route('payment.redirect');

    }
}
