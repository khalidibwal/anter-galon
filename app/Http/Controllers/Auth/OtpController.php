<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
{
    $request->validate([
        'phone' => 'required'
    ]);

    $otp = rand(100000, 999999);

    PhoneOtp::create([
        'phone' => $request->phone,
        'otp' => $otp,
        'expires_at' => now()->addMinutes(5)
    ]);

    // TODO: Ganti dengan SMS Gateway (Twilio, Fonnte, dll)
    // SmsService::send($request->phone, "Kode OTP Anda: $otp");

    return response()->json([
        'message' => 'OTP dikirim',
        'debug_otp' => $otp // ⚠ Hanya untuk testing
    ]);
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'phone' => 'required',
        'otp' => 'required'
    ]);

    $otpData = PhoneOtp::where('phone', $request->phone)
        ->where('otp', $request->otp)
        ->where('expires_at', '>=', now())
        ->first();

    if (!$otpData) {
        return response()->json(['message' => 'OTP salah atau kadaluarsa'], 401);
    }

    // cari user berdasarkan nomor HP
    $user = User::firstOrCreate(
        ['phone' => $request->phone],
        ['name' => 'User ' . $request->phone] // default jika belum ada user
    );

    Auth::login($user);

    return response()->json([
        'message' => 'Login berhasil',
        'user' => $user
    ]);
}


}
