<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel user_depots
        Schema::create('user_depots', function (Blueprint $table) {
            $table->id(); // ID unik untuk tabel user_depots
            $table->foreignId('user_id') // Menyimpan ID pengguna
                  ->constrained('users') // Relasi ke tabel users
                  ->onDelete('cascade'); // Hapus data depot jika user dihapus
            $table->unsignedBigInteger('depot_id'); // ID depot
            $table->foreign('depot_id')->references('id')->on('user_addresses') // Relasi ke tabel user_addresses
                  ->onDelete('cascade'); // Hapus depot jika data user_address dihapus
            $table->timestamps(); // Tanggal pembuatan dan pembaruan data
        });
    }

    public function down(): void
    {
        // Menghapus tabel user_depots
        Schema::dropIfExists('user_depots');
    }
};
