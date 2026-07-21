<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'RTX 5070', 'sku' => 'GPU-RTX5070', 'category' => 'Graphics Card', 'price' => 32999, 'qty' => 0, 'status' => 'out_of_stock'],
            ['name' => 'RTX 4060', 'sku' => 'GPU-RTX4060', 'category' => 'Graphics Card', 'price' => 18999, 'qty' => 42, 'status' => 'in_stock'],
            ['name' => 'ADATA SSB 1TB', 'sku' => 'STG-ADATA1TB', 'category' => 'Storage', 'price' => 3999, 'qty' => 8, 'status' => 'low_stock'],
            ['name' => 'ADATA 1TB LEGEND', 'sku' => 'STG-LEGEND1TB', 'category' => 'Storage', 'price' => 4299, 'qty' => 60, 'status' => 'in_stock'],
            ['name' => 'ADATA 15GB DDR4', 'sku' => 'MEM-ADATA15DDR4', 'category' => 'Memory', 'price' => 1899, 'qty' => 55, 'status' => 'in_stock'],
            ['name' => 'Samsung 990 Pro', 'sku' => 'STG-SAMSUNG990', 'category' => 'Storage', 'price' => 5499, 'qty' => 30, 'status' => 'in_stock'],
            ['name' => 'Ryzen 7', 'sku' => 'CPU-RYZEN7', 'category' => 'Processor', 'price' => 14999, 'qty' => 120, 'status' => 'overstock'],
            ['name' => 'AMD Ryzen™ 5', 'sku' => 'CPU-RYZEN5', 'category' => 'Processor', 'price' => 9999, 'qty' => 45, 'status' => 'in_stock'],
            ['name' => 'Kingston DDR5', 'sku' => 'MEM-KINGSTONDDR5', 'category' => 'Memory', 'price' => 2799, 'qty' => 70, 'status' => 'restocked'],
            ['name' => '16GB DDR5 RAM', 'sku' => 'MEM-16GBDDR5', 'category' => 'Memory', 'price' => 2999, 'qty' => 65, 'status' => 'restocked'],
            ['name' => 'PCX ASUS PRIME', 'sku' => 'MBD-ASUSPRIME', 'category' => 'Motherboard', 'price' => 6999, 'qty' => 25, 'status' => 'in_stock'],
            ['name' => 'DDR3 RAM', 'sku' => 'MEM-DDR3-GEN', 'category' => 'Memory', 'price' => 899, 'qty' => 15, 'status' => 'reserved'],
        ];

        foreach ($products as $p) {
            $product = Product::firstOrCreate(
                ['sku' => $p['sku']],
                [
                    'name' => $p['name'],
                    'category_id' => Category::where('name', $p['category'])->first()?->id,
                    'unit_price' => $p['price'],
                ]
            );

            Inventory::firstOrCreate(
                ['product_id' => $product->id],
                [
                    'quantity_on_hand' => $p['qty'],
                    'reorder_level' => 10,
                    'status' => $p['status'],
                ]
            );
        }
    }
}