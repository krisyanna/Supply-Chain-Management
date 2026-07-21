<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->foreignId('warehouse_id')
                ->nullable()
                ->after('category_id')
                ->constrained('warehouses')
                ->nullOnDelete();

            $table->integer('stock')
                ->default(0)
                ->after('unit_price');

            $table->integer('reserved')
                ->default(0)
                ->after('stock');

            $table->enum('status', [
                'Healthy',
                'Low Stock'
            ])->default('Healthy')->after('reserved');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropForeign(['warehouse_id']);

            $table->dropColumn([
                'warehouse_id',
                'stock',
                'reserved',
                'status'
            ]);
        });
    }
};