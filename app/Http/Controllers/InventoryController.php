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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('from_warehouse');
            $table->unsignedBigInteger('to_warehouse');

            $table->string('product_name');
            $table->integer('quantity');

            $table->enum('status', [
                'Pending',
                'In Transit',
                'Completed'
            ])->default('Pending');

            $table->timestamps();

            $table->foreign('from_warehouse')
                  ->references('id')
                  ->on('warehouses')
                  ->onDelete('cascade');

            $table->foreign('to_warehouse')
                  ->references('id')
                  ->on('warehouses')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};