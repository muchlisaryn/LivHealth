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
        Schema::create('user_finances', function (Blueprint $table) {
            $table->id();
            $table->string('users_id')->constrained('users')->onDelete('casade')->onUpdate('casade');
            $table->string('bank_name_id')->constrained('bank_name')->onDelete('casade')->onUpdate('casade');
            $table->string('bank_account');
            $table->string('bank_account_name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_finances');
    }
};
