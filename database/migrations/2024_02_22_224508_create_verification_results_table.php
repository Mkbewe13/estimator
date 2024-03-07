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
        Schema::create('verification_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_data_id');
            $table->json('result_data');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            $table->foreign('quotation_data_id')->references('id')->on('quotation_data');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_results');
    }
};
