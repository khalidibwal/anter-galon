<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard admin
    public function dashboard()
    {
        // Bisa return view blade admin dashboard
        return view('Admin.dashboard');
    }

    // Tambahkan method lain untuk fitur admin
}
