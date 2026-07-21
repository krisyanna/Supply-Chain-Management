<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use App\Models\WarehouseZone;
use Illuminate\Database\Seeder;

class WarehouseZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            [
                'zone_name' => 'Receiving Area',
                'description' => 'Incoming deliveries and inspection',
                'capacity' => 500,
            ],
            [
                'zone_name' => 'Storage Area',
                'description' => 'Main storage for inventory',
                'capacity' => 3000,
            ],
            [
                'zone_name' => 'Picking Area',
                'description' => 'Order picking and packing',
                'capacity' => 1000,
            ],
            [
                'zone_name' => 'Dispatch Area',
                'description' => 'Outgoing shipments',
                'capacity' => 800,
            ],
        ];

        foreach (Warehouse::all() as $warehouse) {

            foreach ($zones as $zone) {

                WarehouseZone::create([
                    'warehouse_id' => $warehouse->id,
                    'zone_name'    => $zone['zone_name'],
                    'description'  => $zone['description'],
                    'capacity'     => $zone['capacity'],
                ]);

            }

        }
    }
}