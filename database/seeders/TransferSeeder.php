<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transfer;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class TransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $warehouses = Warehouse::all();

        if ($products->count() == 0 || $warehouses->count() < 2) {
            return;
        }

        $statuses = [
            'Pending',
            'In Transit',
            'Completed',
        ];

        for ($i = 1; $i <= 15; $i++) {

            $from = $warehouses->random();

            do {
                $to = $warehouses->random();
            } while ($from->id == $to->id);

            $product = $products->random();

            Transfer::create([
                'product_id'      => $product->id,
                'from_warehouse'  => $from->id,
                'to_warehouse'    => $to->id,
                'quantity'        => rand(10, 150),
                'status'          => $statuses[array_rand($statuses)],
            ]);
        }
    }
}