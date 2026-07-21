<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->date('month'); // first day of the month this forecast is for
            $table->unsignedInteger('current_sales')->default(0); // most recent actual units, for display
            $table->unsignedInteger('forecast_units')->default(0);
            $table->decimal('growth_percent', 6, 2)->default(0);
            $table->string('status')->nullable(); // e.g. "High Demand", "Growing", "Stable Growth"
            $table->string('recommendation')->nullable(); // e.g. "Increase production by 20 units"
            $table->timestamps();

            $table->unique(['product_id', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forecasts');
    }
};