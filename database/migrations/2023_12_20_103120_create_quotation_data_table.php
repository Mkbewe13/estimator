<?php

use App\Enums\QuotationStatus;
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
        Schema::create('quotation_data', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description');
            $table->text('userflow');
            $table->text('requirements');
            $table->enum('status', [QuotationStatus::NEW, QuotationStatus::IN_PROGRESS, QuotationStatus::DONE])->default(QuotationStatus::NEW);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation');
    }
};
