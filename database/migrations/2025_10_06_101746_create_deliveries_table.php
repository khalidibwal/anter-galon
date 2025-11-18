<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT PRIMARY KEY

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->unsignedBigInteger('courier_id');
            $table->foreign('courier_id')->references('id')->on('users_galon')->onDelete('cascade');

            $table->dateTime('pickup_time');
            $table->dateTime('delivered_time')->nullable();

            $table->enum('status', ['in_progress', 'delivered', 'failed'])->default('in_progress');

            $table->text('notes')->nullable();

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
};
