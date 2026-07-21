<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            // Forecasting
            CategorySeeder::class,
            ProductSeeder::class,
            SaleSeeder::class,
            ForecastSeeder::class,

            // Warehouse
            WarehouseSeeder::class,
            WarehouseZoneSeeder::class,

            // Logistics
            TransferSeeder::class,
            LogisticsShipmentSeeder::class,

            // Procurement
            ProcurementSeeder::class,

            // Reports
            ReportSeeder::class,
            ReportTemplateSeeder::class,           

            // Others
            InvoiceSeeder::class,
        ]);
    }
}