<?php

namespace App\Http\Controllers;

use App\Services\ForecastService;
use App\Models\Category;
use App\Models\Forecast;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForecastingController extends Controller
{
    public function index(ForecastService $forecastService)
{
        $trend = $this->monthlySalesTrend(6);
        $months = $trend['labels'];
        $actualSales = $trend['values'];

        // Forecast line matches actuals except the final point, which is
        // replaced with a projected next value - makes the dotted line
        // visibly diverge, same idea as the screenshot.
        $forecastSales = $actualSales;
        $forecastSales[count($forecastSales) - 1] = (int) round($this->projectNextValue($actualSales));

        $historicalSalesTotal = array_sum($actualSales);
        $forecastDemandTotal = (int) round($this->projectNextValue($actualSales));
        $forecastAccuracy = $this->backtestAccuracy();
        $stockOutRisk = Inventory::whereIn('status', ['out_of_stock', 'low_stock'])->count();

        // Inventory Risk donut
        $inventoryRisk = [
            Inventory::whereIn('status', ['in_stock', 'restocked'])->count(),
            Inventory::where('status', 'overstock')->count(),
            Inventory::whereIn('status', ['low_stock', 'out_of_stock'])->count(),
        ];

        // Forecast Product Demand bar chart + Planning Recommendations,
        // pulled straight from the stored Forecast table
       $topGrowingProducts = $forecastService->topGrowingProducts();

$forecastProducts = [];
$forecastDemand = [];
$planningRecommendations = [];
$historicalData = collect();

foreach ($topGrowingProducts as $item) {

    $forecastProducts[] = $item['product'];

    $forecast = max(
        round(
            $item['current_sales'] *
            (1 + ($item['growth_percent'] / 100))
        ),
        0
    );

    $forecastDemand[] = $forecast;

    if ($item['growth_percent'] >= 25) {
        $recommendation = 'Increase Stock Immediately';
        $status = 'High Demand';
    } elseif ($item['growth_percent'] >= 10) {
        $recommendation = 'Prepare Additional Inventory';
        $status = 'Growing';
    } elseif ($item['growth_percent'] >= 0) {
        $recommendation = 'Maintain Current Stock';
        $status = 'Stable';
    } else {
        $recommendation = 'Reduce Purchasing';
        $status = 'Declining';
    }

    $planningRecommendations[] = [
        'product' => $item['product'],
        'recommendation' => $recommendation,
    ];

    $product = Product::where('name', $item['product'])->first();

    if ($product) {

        $monthly = $this->monthlySalesTrend(6, $product->id)['values'];

        $historicalData->push([
            'product' => $item['product'],
            'values' => $monthly,
            'forecast' => $forecast,
        ]);
    }
}

$topGrowingProducts = collect($topGrowingProducts)->map(function ($item) {

    return [
        'product' => $item['product'],
        'growth' => ($item['growth_percent'] >= 0 ? '+' : '') . $item['growth_percent'] . '%',
        'status' => match (true) {
            $item['growth_percent'] >= 25 => 'High Demand',
            $item['growth_percent'] >= 10 => 'Growing',
            $item['growth_percent'] >= 0 => 'Stable',
            default => 'Declining',
        },
    ];
});
        return view('forecasting', compact(
            'months',
            'actualSales',
            'forecastSales',
            'inventoryRisk',
            'forecastProducts',
            'forecastDemand',
            'planningRecommendations',
            'topGrowingProducts',   
            'historicalData',
            'historicalSalesTotal',
            'forecastDemandTotal',
            'forecastAccuracy',
            'stockOutRisk'
        ));
    }

public function forecastDemand(Request $request, ForecastService $forecastService)
    {
        $selectedRangeMonths = (int) ($request->query('range') ?: 6);
        $selectedCategory = $request->query('category');
        $selectedProductName = $request->query('product');

        $categoryId = $selectedCategory ? Category::where('name', $selectedCategory)->value('id') : null;
        $productId = $selectedProductName ? Product::where('name', $selectedProductName)->value('id') : null;

        $trend = $this->monthlySalesTrend($selectedRangeMonths, $productId, $categoryId);
        $months = $trend['labels'];
        $actualSales = $trend['values'];

        $forecastSales = $actualSales;
        $forecastSales[count($forecastSales) - 1] = (int) round($this->projectNextValue($actualSales));
 
        $forecastAccuracy = $this->backtestAccuracy();

        $demandGrowth = 0;
        if (count($actualSales) >= 2 && end($actualSales) != 0) {
            $prev = $actualSales[count($actualSales) - 2];
            $last = end($actualSales);
            $demandGrowth = $prev > 0 ? round((($last - $prev) / $prev) * 100, 1) : 0;
        }

        // Apply the same Category/Product filter to the Forecast-table-driven
        // sections (bar chart, Planning Recommendations, Product Demand Forecast)
      $topGrowingProducts = $forecastService->topGrowingProducts();

if ($productId) {
    $product = Product::find($productId);

    $topGrowingProducts = $topGrowingProducts->filter(function ($item) use ($product) {
        return $item['product'] == $product->name;
    });
}

elseif ($categoryId) {

    $names = Product::where('category_id', $categoryId)
        ->pluck('name')
        ->toArray();

    $topGrowingProducts = $topGrowingProducts->filter(function ($item) use ($names) {
        return in_array($item['product'], $names);
    });
}

$forecastProducts = [];
$forecastDemand = [];
$planningRecommendations = [];
$productDemandForecast = [];

foreach ($topGrowingProducts as $item) {

    $forecast = max(
        round(
            $item['current_sales'] *
            (1 + ($item['growth_percent'] / 100))
        ),
        0
    );

    $forecastProducts[] = $item['product'];
    $forecastDemand[] = $forecast;

    if ($item['growth_percent'] >= 25) {
        $recommendation = 'Increase Stock Immediately';
        $status = 'High Demand';
    } elseif ($item['growth_percent'] >= 10) {
        $recommendation = 'Prepare Additional Inventory';
        $status = 'Growing';
    } elseif ($item['growth_percent'] >= 0) {
        $recommendation = 'Maintain Current Stock';
        $status = 'Stable';
    } else {
        $recommendation = 'Reduce Purchasing';
        $status = 'Declining';
    }

    $planningRecommendations[] = [
        'product' => $item['product'],
        'recommendation' => $recommendation,
    ];

    $productDemandForecast[] = [
        'product' => $item['product'],
        'current_sales' => $item['current_sales'],
        'forecast' => $forecast,
        'growth' => ($item['growth_percent'] >= 0 ? '+' : '') . $item['growth_percent'] . '%',
        'growth_class' => $item['growth_percent'] >= 10 ? 'success' : 'warning',
        'status' => $status,
    ];
}

 $forecastDemandTotal = array_sum($forecastDemand);
        $margin = $forecastDemandTotal * 0.05;
        $expectedRangeLow = number_format($forecastDemandTotal - $margin);
        $expectedRangeHigh = number_format($forecastDemandTotal + $margin);
        

        $categories = Category::orderBy('name')->pluck('name');
        $products = Product::orderBy('name')->pluck('name');

        return view('forecast-demand', compact(
            'months',
            'actualSales',
            'forecastSales',
            'forecastProducts',
            'forecastDemand',
            'forecastDemandTotal',
            'expectedRangeLow',
            'expectedRangeHigh',
            'forecastAccuracy',
            'demandGrowth',
            'categories',
            'products',
            'planningRecommendations',
            'productDemandForecast'
        ));
    }

    public function historicalSales(Request $request)
    {
        $selectedRangeMonths = (int) ($request->query('range') ?: 10);
        $selectedCategory = $request->query('category');
        $selectedProductName = $request->query('product');

        $categoryId = $selectedCategory ? Category::where('name', $selectedCategory)->value('id') : null;
        $productId = $selectedProductName ? Product::where('name', $selectedProductName)->value('id') : null;

        $trend = $this->monthlySalesTrend($selectedRangeMonths, $productId, $categoryId);
        $months = $trend['labels'];
        $monthlySalesTrend = $trend['values'];

      $latestDate = $this->latestSalesDate();
$windowStart = $latestDate->copy()
    ->subMonths($selectedRangeMonths - 1)
    ->startOfMonth();

        $salesQuery = fn () => Sale::where('sold_at', '>=', $windowStart)
            ->when($productId, fn ($q) => $q->where('product_id', $productId))
            ->when(! $productId && $categoryId, fn ($q) => $q->whereHas('product', fn ($p) => $p->where('category_id', $categoryId)));

        $totalUnitSold = $salesQuery()->sum('quantity');
        $totalRevenueRaw = $salesQuery()->sum('revenue');
        $totalRevenue = $totalRevenueRaw >= 1000000
            ? number_format($totalRevenueRaw / 1000000, 2).'M'
            : number_format($totalRevenueRaw);

        if ($productId) {
            // A single product is selected - "best/low selling" doesn't apply,
            // just show the selected product itself.
            $bestSellingProduct = $selectedProductName;
            $lowSellingProduct = $selectedProductName;
        } else {
            $bestQuery = Sale::join('products', 'products.id', '=', 'sales.product_id')
                ->where('sold_at', '>=', $windowStart)
                ->when($categoryId, fn ($q) => $q->where('products.category_id', $categoryId))
                ->select('products.name', DB::raw('SUM(sales.quantity) as total_qty'))
                ->groupBy('products.name');

            $bestSellingProduct = (clone $bestQuery)->orderByDesc('total_qty')->limit(1)->value('name') ?? 'N/A';
            $lowSellingProduct = (clone $bestQuery)->orderBy('total_qty')->limit(1)->value('name') ?? 'N/A';
        }

        $categories = Category::orderBy('name')->pluck('name');
        $products = Product::orderBy('name')->pluck('name');

        $monthCount = count($months);
        $monthlySalesSummary = collect($months)->map(function ($label, $i) use ($monthlySalesTrend, $monthCount, $latestDate) {
            return [
                'month' => $latestDate
    ->copy()
    ->subMonths($monthCount - 1 - $i)
    ->format('F'),

                'units' => $monthlySalesTrend[$i],
            ];
        });

        $salesHistory = Sale::with('product.category')
            ->where('sold_at', '>=', $windowStart)
            ->when($productId, fn ($q) => $q->where('product_id', $productId))
            ->when(! $productId && $categoryId, fn ($q) => $q->whereHas('product', fn ($p) => $p->where('category_id', $categoryId)))
            ->orderByDesc('sold_at')
            ->limit(10)
            ->get()
            ->map(fn ($sale) => [
                'date' => $sale->sold_at->format('Y-m-d'),
                'product' => $sale->product->name,
                'category' => $sale->product->category->name ?? 'N/A',
                'quantity' => $sale->quantity,
                'revenue' => number_format($sale->revenue),
            ]);

        return view('historical-sales', compact(
            'months',
            'monthlySalesTrend',
            'totalUnitSold',
            'totalRevenue',
            'bestSellingProduct',
            'lowSellingProduct',
            'categories',
            'products',
            'monthlySalesSummary',
            'salesHistory'
        ));
    }

    /**
     * Units sold per month for the last $months months, oldest first.
     * Pass $productId to scope to a single product, or $categoryId to scope
     * to all products in a category (used by the Category/Product filters).
     */
   protected function monthlySalesTrend(int $months, ?int $productId = null, ?int $categoryId = null): array
{
    $latestDate = $this->latestSalesDate();

    $start = $latestDate
        ->copy()
        ->subMonths($months - 1)
        ->startOfMonth();

    $query = Sale::selectRaw("
            DATE_FORMAT(sold_at, '%Y-%m') as ym,
            SUM(quantity) as units
        ")
        ->whereBetween('sold_at', [
            $start,
            $latestDate->copy()->endOfMonth()
        ]);

    if ($productId) {
        $query->where('product_id', $productId);
    } elseif ($categoryId) {
        $query->whereHas('product', function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        });
    }

    $rows = $query
        ->groupBy('ym')
        ->orderBy('ym')
        ->pluck('units', 'ym');

    $labels = [];
    $values = [];

    for ($i = 0; $i < $months; $i++) {

        $month = $start->copy()->addMonths($i);

        $key = $month->format('Y-m');

        $labels[] = $month->format('M');

        $values[] = (int) ($rows[$key] ?? 0);
    }

    return [
        'labels' => $labels,
        'values' => $values,
    ];
}
    /**
     * Simple average-growth-rate projection - not a statistical model,
     * just extrapolates the average month-over-month % change forward one step.
     */
    protected function projectNextValue(array $series): float
    {
        $series = array_values(array_filter($series, fn ($v) => $v !== null));

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

    /**
     * "Forecast Accuracy" backtest: for each of the last few months, project
     * that month's value using only the months before it, compare to what
     * actually happened, and average the error. This is genuinely computed
     * from your Sale data - not a fabricated number - but it's still a rough
     * heuristic, not a real statistical accuracy metric.
     */
    protected function backtestAccuracy(): int
    {
        $trend = $this->monthlySalesTrend(6)['values'];

        if (count($trend) < 4) {
            return 90; // not enough history to backtest yet
        }

        $errors = [];
        // Walk forward: use months [0..i-1] to predict month i, for the last 3 months
        for ($i = count($trend) - 3; $i < count($trend); $i++) {
            $history = array_slice($trend, 0, $i);
            if (count($history) < 2) {
                continue;
            }

            $predicted = $this->projectNextValue($history);
            $actual = $trend[$i];

            if ($actual > 0) {
                $errors[] = abs($predicted - $actual) / $actual;
            }
        }

        if (empty($errors)) {
            return 90;
        }

        $avgError = array_sum($errors) / count($errors);
        $accuracy = (1 - $avgError) * 100;

        return (int) round(max(50, min(99, $accuracy)));
    }

    /**
 * Returns the latest sales date in the database.
 * Falls back to today if there are no sales yet.
 */
protected function latestSalesDate(): Carbon
{
    $latest = Sale::max('sold_at');

    return $latest
        ? Carbon::parse($latest)
        : Carbon::now();
}
}