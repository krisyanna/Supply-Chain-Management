<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            ['warehouse_name' => 'Warehouse A', 'location' => 'Manila'],
            ['warehouse_name' => 'Warehouse B', 'location' => 'Quezon City'],
            ['warehouse_name' => 'Warehouse C', 'location' => 'Cebu'],
            ['warehouse_name' => 'Warehouse D', 'location' => 'Davao'],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::firstOrCreate(
                ['warehouse_name' => $warehouse['warehouse_name']],
                $warehouse
            );
        }
    }
}