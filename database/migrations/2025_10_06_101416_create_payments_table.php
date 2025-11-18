<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT PRIMARY KEY

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->enum('method', ['cash', 'transfer', 'ewallet'])->default('cash');
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');

            $table->decimal('amount', 10, 2);
            $table->dateTime('paid_at')->nullable();

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
