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
        
        Schema::create('delivery_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->enum('status_delivery', ['Pending', 'On The Way', 'Delivered', 'Returned'])->default('Pending');
            $table->text('description')->nullable();
            $table->longText('attachments')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('courier_id')->references('id')->on('users');
            $table->foreign('transaction_id')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_statuses');
    }
};
