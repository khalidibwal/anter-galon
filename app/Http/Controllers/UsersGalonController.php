<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersGalonController extends Controller
{
    // app/Http/Controllers/UsersGalonController.php
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:100',
        'email' => 'required|email|max:100|unique:users_galon,email',
        'password' => 'required|max:255',
        'phone' => 'nullable|max:20',
        'role' => 'required|in:customer,admin,courier',
    ]);

    \DB::table('users_galon')->insert([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password), // pastikan untuk mengenkripsi password
        'phone' => $request->phone,
        'role' => $request->role,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('antar.galon')->with('success', 'User berhasil ditambahkan.');
}

}
