<?php

namespace App\Services;

use App\Models\Product;
use Carbon\Carbon;

class ForecastService
{
    public function topGrowingProducts($limit = 4)
    {
        $products = Product::with('sales')->get();

        return $products->map(function ($product) {

            $latestSale = $product->sales()
                ->orderByDesc('sold_at')
                ->first();

            if (!$latestSale) {
                return null;
            }

            $latestMonth = Carbon::parse($latestSale->sold_at)->startOfMonth();
            $previousMonth = $latestMonth->copy()->subMonth();

            $currentSales = $product->sales()
                ->whereBetween('sold_at', [
                    $latestMonth,
                    $latestMonth->copy()->endOfMonth()
                ])
                ->sum('quantity');

            $previousSales = $product->sales()
                ->whereBetween('sold_at', [
                    $previousMonth,
                    $previousMonth->copy()->endOfMonth()
                ])
                ->sum('quantity');

            if ($previousSales > 0) {
                $growth = (($currentSales - $previousSales) / $previousSales) * 100;
            } elseif ($currentSales > 0) {
                $growth = 100;
            } else {
                $growth = 0;
            }

            // Simple forecast formula
          $forecast = round($currentSales * (1 + ($growth / 100)));

return [
    'product' => $product->name,
    'current_sales' => $currentSales,
    'previous_sales' => $previousSales,
    'growth_percent' => round($growth, 1),
    'forecast_units' => max(0, $forecast),
];
        })
        ->filter()
        ->sortByDesc('growth_percent')
        ->take($limit)
        ->values();
    }
}