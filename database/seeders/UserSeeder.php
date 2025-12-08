<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Antar Galon',
            'email' => 'admin@gmail.com',
            'alamat' => 'Kantor Pusat',
            'latitude' => null,
            'longitude' => null,
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

    }
}
