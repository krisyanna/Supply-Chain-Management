<?php

namespace Database\Seeders;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProcurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            'TechSource Trading',
            'PC Express Philippines',
            'Gigaware Solutions',
            'MicroHub Distribution',
            'Vertex Components',
        ];

        foreach ($suppliers as $name) {

            $supplier = Supplier::create([
                'name' => $name,
            ]);

            for ($i = 1; $i <= 3; $i++) {

                $orderDate = Carbon::now()->subDays(rand(5, 60));

                PurchaseOrder::create([
                    'po_number'     => 'PO-' . rand(10000, 99999),
                    'supplier_id'   => $supplier->id,
                    'order_date'    => $orderDate,
                    'delivery_date' => $orderDate->copy()->addDays(rand(2, 10)),
                    'status'        => collect([
                        'Pending',
                        'Completed',
                    ])->random(),
                    'grand_total'   => rand(25000, 180000),
                ]);
            }
        }
    }
}