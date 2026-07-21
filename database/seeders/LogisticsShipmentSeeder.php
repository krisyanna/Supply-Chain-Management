<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LogisticsShipment;

class LogisticsShipmentSeeder extends Seeder
{
    /**
     * Seed the shipments database.
     */
    public function run()
    {
        LogisticsShipment::truncate();

        $originalData = [
            [
                'shipment_code' => 'ABC-01234',
                'driver_name' => 'Erich De Torres',
                'route_path' => 'Cavite - Laguna',
                'estimated_arrival' => 'Estimated 13 Sept 2026',
                'status' => 'En Route',
                'meta_info' => '4h 22m left',
                'phone_number' => '+63 912 575 4567',
                'origin_address' => '2118 Ridge St. Cavite, 3564',
                'destination_address' => '137 Gomez St, Brgy 2, Laguna City',
                'cargo_details' => 'Vertex [Mother Board] Ryzen-5',
                'quantity' => 10,
                'payment_status' => 'Paid',
                'delivery_cost' => 17000.00,
                'schedule_category' => 'paid'
            ],
            [
                'shipment_code' => 'DEF-56789',
                'driver_name' => 'Kristy Ann Paracale',
                'route_path' => 'Manila - Bulacan',
                'estimated_arrival' => 'Estimated 13 Sept 2026',
                'status' => 'En Route',
                'meta_info' => '9h 52m left',
                'phone_number' => '+63 911 200 4911',
                'origin_address' => '742 Evergreen Terrace, Manila, 1000',
                'destination_address' => '456 Oak St, AP 456, Manila City',
                'cargo_details' => 'Ryzen-9 Core Kit Combo',
                'quantity' => 2,
                'payment_status' => 'COD',
                'delivery_cost' => 5500.00,
                'schedule_category' => 'pendings'
            ],
            [
                'shipment_code' => 'GHI-10111',
                'driver_name' => 'Juliana Aquino',
                'route_path' => 'Pangasinan - Laguna',
                'estimated_arrival' => '13 Sept 2026',
                'status' => 'Delivered',
                'meta_info' => '0h 00m left',
                'phone_number' => '+63 923 104 2231',
                'origin_address' => '456 Shaw Blvd, Mandaluyong, 1550',
                'destination_address' => '789 Pine Blvd, Batangas City',
                'cargo_details' => 'Groceries Logistics Bundle',
                'quantity' => 5,
                'payment_status' => 'Pending',
                'delivery_cost' => 12350.00,
                'schedule_category' => 'cod'
            ]
        ];

        foreach ($originalData as $data) {
            LogisticsShipment::create($data);
        }
    }
}