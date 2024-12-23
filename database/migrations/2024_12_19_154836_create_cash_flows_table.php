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
 

        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('finance_id');
            $table->enum('type' , ['income', 'expense']);
            $table->integer('total')->default(0);
            $table->text('description');
            $table->longText('attachments');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('finance_id')->references('id')->on('user_finances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_flows');
    }
};
