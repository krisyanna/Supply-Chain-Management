<?php

namespace Database\Seeders;

use App\Models\Forecast;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ForecastSeeder extends Seeder
{
    public function run(): void
    {
        $month = Carbon::now()->startOfMonth();

        foreach (Product::with('sales')->get() as $product) {
            $monthly = $product->sales()
                ->selectRaw("DATE_FORMAT(sold_at, '%Y-%m') as ym, SUM(quantity) as units")
                ->where('sold_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
                ->groupBy('ym')->orderBy('ym')
                ->pluck('units')->map(fn ($v) => (int) $v)->values()->all();

            if (empty($monthly)) {
                continue; // no sales history yet for this product - skip forecasting it
            }

            $currentSales = end($monthly);
            $forecastUnits = (int) round($this->projectNextValue($monthly));
            $growth = $currentSales > 0
                ? round((($forecastUnits - $currentSales) / $currentSales) * 100, 2)
                : 0;

            Forecast::updateOrCreate(
                ['product_id' => $product->id, 'month' => $month],
                [
                    'current_sales' => $currentSales,
                    'forecast_units' => $forecastUnits,
                    'growth_percent' => $growth,
                    'status' => $this->statusLabel($growth),
                    'recommendation' => $this->recommendation($growth),
                ]
            );
        }
    }

    /** Simple average-growth projection - same approach as ForecastService, kept here so seeding doesn't depend on app services. */
    protected function projectNextValue(array $series): float
    {
        if (count($series) < 2) {
            return $series[0] ?? 0;
        }

        $growthRates = [];
        for ($i = 1; $i < count($series); $i++) {
            if ($series[$i - 1] > 0) {
                $growthRates[] = ($series[$i] - $series[$i - 1]) / $series[$i - 1];
            }
        }

        $avgGrowth = count($growthRates) ? array_sum($growthRates) / count($growthRates) : 0;

        return max(0, end($series) * (1 + $avgGrowth));
    }

    protected function statusLabel(float $growth): string
    {
        return match (true) {
            $growth >= 30 => 'High Demand',
            $growth >= 15 => 'Growing',
            $growth >= 5 => 'Stable Growth',
            $growth >= 0 => 'Steady',
            default => 'Declining',
        };
    }

    protected function recommendation(float $growth): string
    {
        if ($growth >= 20) {
            return 'Increase production by 20 units';
        }

        if ($growth >= 5) {
            return 'Increase production by 10 units';
        }

        return 'Maintain current inventory';
    }
}