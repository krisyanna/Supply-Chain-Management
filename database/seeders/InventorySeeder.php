<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventory::truncate();

        foreach (Product::all() as $product) {

            $quantity = rand(20, 300);

            Inventory::create([
                'product_id' => $product->id,
                'quantity_on_hand' => $quantity,
                'reorder_level' => rand(10, 50),
                'status' => match (true) {
                    $quantity == 0 => 'out_of_stock',
                    $quantity <= 20 => 'low_stock',
                    $quantity >= 250 => 'overstock',
                    default => 'in_stock',
                },
            ]);

        }
    }
}