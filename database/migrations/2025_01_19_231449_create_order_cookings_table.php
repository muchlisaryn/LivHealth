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
        Schema::create('order_cookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_program_id');
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('chef_id')->nullable();
            $table->enum('status', ['New', 'In Progress', 'Completed' , 'On Hold' , 'Ready for Pickup'])->default('New');

            $table->foreign('chef_id')->references('id')->on('users');
            $table->foreign('user_program_id')->references('id')->on('program_plans');
            $table->foreign('menu_id')->references('id')->on('menuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_cookings');
    }
};
