<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Thông tin người nhận 
            $table->string('full_name');
            $table->string('phone');
            $table->text('address');
            $table->text('note')->nullable();

            // Thanh toán & Trạng thái
            $table->bigInteger('total_price');
            $table->string('payment_method')->default('cod'); // cod, vnpay
            $table->tinyInteger('payment_status')->default(0);
            $table->tinyInteger('status')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
