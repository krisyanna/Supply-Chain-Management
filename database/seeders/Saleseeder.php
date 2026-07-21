<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        // Matches the "Monthly Sales Trend" screenshot: 10 months of totals
        // 450, 520, 580, 630, 710, 795, 810, 890, 900, 1000 units.
        // Seeded relative to *today* (oldest -> newest) so "last N months"
        // queries always find data, regardless of when this seeder runs.
        $monthlyTotals = [450, 520, 580, 630, 710, 795, 810, 890, 900, 1000];

        $products = Product::whereIn('sku', [
            'GPU-RTX5070', 'STG-ADATA1TB', 'CPU-RYZEN7', 'MEM-KINGSTONDDR5', 'GPU-RTX4060', 'STG-SAMSUNG990',
        ])->get()->keyBy('sku');

        // Rough share of each product within a month's total units.
        $weights = [
            'GPU-RTX5070' => 0.30,
            'STG-ADATA1TB' => 0.22,
            'CPU-RYZEN7' => 0.18,
            'MEM-KINGSTONDDR5' => 0.14,
            'GPU-RTX4060' => 0.10,
            'STG-SAMSUNG990' => 0.06,
        ];

        $monthCount = count($monthlyTotals);

        foreach ($monthlyTotals as $index => $total) {
            $monthStart = Carbon::now()->subMonths($monthCount - 1 - $index)->startOfMonth();

            foreach ($weights as $sku => $weight) {
                $product = $products->get($sku);
                if (! $product) {
                    continue;
                }

                $qty = (int) round($total * $weight);
                if ($qty <= 0) {
                    continue;
                }

                Sale::create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'revenue' => round($qty * $product->unit_price, 2),
                    'sold_at' => $monthStart->copy()->addDays(rand(0, 20)),
                ]);
            }
        }

        // Itemized recent sales rows to match the "Sales History" table screenshot.
        $recentRows = [
            ['sku' => 'GPU-RTX5070', 'qty' => 25, 'revenue' => 125000, 'daysAgo' => 0],
            ['sku' => 'STG-ADATA1TB', 'qty' => 20, 'revenue' => 85000, 'daysAgo' => 1],
            ['sku' => 'CPU-RYZEN7', 'qty' => 15, 'revenue' => 55000, 'daysAgo' => 2],
            ['sku' => 'MEM-KINGSTONDDR5', 'qty' => 12, 'revenue' => 40000, 'daysAgo' => 3],
            ['sku' => 'GPU-RTX4060', 'qty' => 9, 'revenue' => 35000, 'daysAgo' => 4],
            ['sku' => 'STG-SAMSUNG990', 'qty' => 7, 'revenue' => 28000, 'daysAgo' => 5],
        ];

        foreach ($recentRows as $row) {
            $product = $products->get($row['sku']);
            if (! $product) {
                continue;
            }

            Sale::create([
                'product_id' => $product->id,
                'quantity' => $row['qty'],
                'revenue' => $row['revenue'],
                'sold_at' => Carbon::now()->subDays($row['daysAgo']),
            ]);
        }
    }
}