<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            // Lokasi / koordinat
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Alamat otomatis dari geocoder
            $table->string('alamat')->nullable();

            // Catatan detail yang diisi user
            $table->text('detail_alamat')->nullable();

            // Waktu pengantaran
            $table->datetime('waktu_pengantaran')->nullable();

            // Label alamat (rumah / kantor / lainnya)
            $table->string('label')->nullable();

            $table->timestamps();

            // Relasi
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
};
