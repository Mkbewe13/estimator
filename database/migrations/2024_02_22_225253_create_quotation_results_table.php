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
        Schema::create('quotation_results', function (Blueprint $table) {
            $table->id();
            $table->json('result');
            $table->unsignedBigInteger('quotation_data_id');
            $table->enum('project_side', ['frontend', 'backend']);
            $table->timestamps();

            $table->foreign('quotation_data_id')->references('id')->on('quotation_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_results');
    }
};
