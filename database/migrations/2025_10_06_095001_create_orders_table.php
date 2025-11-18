<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT PRIMARY KEY

            // user_id sebagai foreign key ke users_galon(id)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // courier_id nullable, foreign key ke users_galon(id)
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->foreign('courier_id')->references('id')->on('users')->onDelete('set null');

            // address_id foreign key ke addresses(id)
            $table->text('address');

            // status enum
            $table->enum('status', ['pending', 'assigned', 'on_delivery', 'completed', 'cancelled'])
                ->default('pending');

            $table->dateTime('order_time');
            $table->dateTime('delivery_time')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
