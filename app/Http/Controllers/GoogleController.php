<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    // Redirect user ke Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function callback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Cari user berdasarkan email atau google_id
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(Str::random(16)), // password random
            ]
        );

        Auth::login($user);

        // Cek apakah address_id ada di session
        $addressId = session('address_id', null);

        // Redirect ke produk.index dan tambahkan address_id jika ada
        return redirect()->route('produk.index', ['address_id' => $addressId])
            ->with('success', 'Login menggunakan Google berhasil!');
    }
}
