<?php

// GalonController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalonController extends Controller
{
    public function index()
    {
        $galons = [
            [
                'id' => 1,
                'name' => 'Galon Aqua 19L',
                'description' => 'Galon isi ulang air mineral Aqua 19 liter.',
                'price' => 25000,
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Aqua_galon.png/440px-Aqua_galon.png',
            ],
            [
                'id' => 2,
                'name' => 'Galon Vit 19L',
                'description' => 'Galon isi ulang air mineral Vit 19 liter.',
                'price' => 22000,
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/3/38/Vit_water_19L.jpg',
            ],
            // Tambah galon lain sesuai kebutuhan
        ];

        return view('index', compact('galons'));
    }

    public function showMap(){
        return view('Home.pilih-lokasi');
    }

    public function order($id)
    {
        // Logic pemesanan galon (dummy)
        return "Kamu memesan galon dengan ID: $id";
    }
    public function toRegister(){
         if (Auth::check()) {
        // User sudah login, redirect ke index
        return redirect()->route('antar.galon');
    }
        return view('Auth.Register');
    }
}

