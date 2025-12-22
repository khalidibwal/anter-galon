<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT PRIMARY KEY

            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);

            // Menambahkan kolom address_id untuk relasi ke user_addresses
            $table->unsignedBigInteger('address_id')->nullable(); // Nullable jika produk bisa tidak terkait alamat

            // Menambahkan foreign key untuk address_id
            $table->foreign('address_id')->references('id')->on('user_addresses')->onDelete('set null');
            
            // Menambahkan kolom user_id untuk relasi ke users
            $table->unsignedBigInteger('user_id'); // Menambahkan kolom user_id

            // Menambahkan foreign key untuk user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Menggunakan cascade agar produk terhapus saat user dihapus

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        // // Menghapus foreign key dan kolom address_id serta user_id sebelum menghapus tabel
        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropForeign(['address_id']); // Menghapus foreign key address_id
        //     $table->dropForeign(['user_id']); // Menghapus foreign key user_id
        //     $table->dropColumn('address_id'); // Menghapus kolom address_id
        //     $table->dropColumn('user_id'); // Menghapus kolom user_id
        // });

        // Menghapus tabel products
        Schema::dropIfExists('products');
    }
};
