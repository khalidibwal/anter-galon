<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('order_id')->unique(); // order ID dari Midtrans
        $table->integer('gross_amount');
        $table->string('payment_type')->nullable();
        $table->string('payment_code')->nullable(); // VA number atau qris string
        $table->string('status')->default('pending'); // pending, paid, failed, expired
        $table->string('delivery_status')->default('on_the_way'); // admin dapat update ini
        // Alamat user (ambil dari tabel alamat agar tidak berubah)
        $table->text('alamat');
        $table->text('detail_alamat')->nullable();
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();
        $table->datetime('waktu_pengantaran')->nullable();

        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
