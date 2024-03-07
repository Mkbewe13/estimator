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

            $statuses = array_column(QuotationStatus::cases(), 'value');

            $table->id();
            $table->text('name');
            $table->text('objectives');
            $table->text('features');
            $table->text('roles')->nullable();
            $table->text('integrations')->nullable();
            $table->text('db')->nullable();
            $table->text('design')->nullable();
            $table->text('deploy')->nullable();
            $table->text('scalability')->nullable();
            $table->text('maintenance')->nullable();
            $table->text('tech')->nullable();
            $table->enum('status', $statuses)->default(QuotationStatus::PREPARING->value);
            $table->softDeletes();
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
