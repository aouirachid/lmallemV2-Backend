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
        Schema::create('handy_men', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ice');
            $table->string('specializedField');
            $table->bigInteger('accountNumber');
            $table->string('status');
            $table->timestamps();
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handy_men');
    }
};
