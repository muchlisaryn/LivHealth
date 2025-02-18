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

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('programs_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('order_price');
            $table->integer('shipping_price');
            $table->integer('sub_total');
            $table->enum('status' , ['Pending', 'Paid Payment' , 'Payment Rejected', 'Confirmed' , 'Verified Payment', 'Cancelled'])->default('Pending');
            $table->longText('canceled_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('programs_id')->references('id')->on('programs');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
