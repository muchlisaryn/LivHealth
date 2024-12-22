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
            $table->integer('total_price');
            $table->enum('status' , ['Pending', 'Confirmed', 'Preparing', 'Delivered', 'Canceled'])->default('Pending');
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
