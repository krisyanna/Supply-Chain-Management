@extends('layouts.app')

@section('content')
<div class="dashboard-page">
    <header class="dashboard-top container">
        <div class="search-box">
            <input type="text" placeholder="Search">
        </div>

        <nav class="dashboard-nav">
            <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        HOME
    </a>

    <a href="{{ route('forecasting') }}"
       class="{{ request()->routeIs('forecasting*') ? 'active' : '' }}">
        FORECASTING
    </a>

    <a href="{{ route('suppliers.index') }}"
       class="{{ request()->routeIs('suppliers.index') ? 'active' : '' }}">
        PROCUREMENT
    </a>

 <a href="{{ route('logistics.dashboard') }}"
   class="{{ request()->routeIs('logistics.*') ? 'active' : '' }}">
    LOGISTICS
</a>

<a href="{{ route('inventory') }}"
   class="{{ request()->routeIs('inventory') ? 'active' : '' }}">
    INVENTORY
</a>

<a href="{{ route('reports.index') }}"
   class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
    REPORTS
</a>
        </nav>
    </header>

    <main class="container dashboard-content">
        <section class="forecast-demand-header">
            <h2>Forecast Demand</h2>

            <form method="GET" action="{{ route('forecasting.demand') }}" class="filter-group" id="filterForm">
                <select class="filter-select" name="range" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Date Range</option>
                    <option value="1" @selected(request('range') == '1')>Last 30 days</option>
                    <option value="3" @selected(request('range') == '3')>Last 3 months</option>
                    <option value="6" @selected(request('range') == '6')>Last 6 months</option>
                </select>

                <select class="filter-select" name="category" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category }}" @selected(request('category') == $category)>{{ $category }}</option>
                    @endforeach
                </select>

                <select class="filter-select" name="product" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Product</option>
                    @foreach($products as $product)
                    <option value="{{ $product }}" @selected(request('product') == $product)>{{ $product }}</option>
                    @endforeach
                </select>

                @if(request('range') || request('category') || request('product'))
                <a href="{{ route('forecasting.demand') }}" class="filter-clear">Clear filters</a>
                @endif
            </form>
        </section>

        <section class="toggle-pills">
            <a href="{{ route('forecasting.historical') }}" class="pill">Historical Sales</a>
            <span class="pill pill--active">Forecast Demand</span>
        </section>

        <section class="welcome-row welcome-row--stats-only">
            <div class="stat-card">
                <p>Forecast Demand</p>
                <h3>{{ number_format($forecastDemandTotal) }}</h3>
                <span>Predicted Units</span>
            </div>

            <div class="stat-card">
                <p>Expected Range</p>
                <h3>{{ $expectedRangeLow }} - {{ $expectedRangeHigh }}</h3>
                <span>Units</span>
            </div>

            <div class="stat-card">
                <p>Forecast Accuracy</p>
                <h3>{{ $forecastAccuracy }}%</h3>
                <span class="success">Reliable Predictions</span>
            </div>

            <div class="stat-card stat-card--highlight">
                <p>Demand Growth</p>
                <h3 class="success">+{{ $demandGrowth }}%</h3>
                <span>Compared to Last Month</span>
            </div>
        </section>

        <section class="card standalone-card">
            <h3>Historical Sales vs Forecast</h3>
            <div class="chart-canvas-box chart-canvas-box--wide">
                <canvas id="salesForecastChart"></canvas>
            </div>
        </section>

        <section class="dashboard-grid standalone-card">
            <div class="card">
                <h3>Forecast Product Demand</h3>
                <div class="chart-canvas-box chart-canvas-box--wide">
                    <canvas id="forecastDemandChart"></canvas>
                </div>
            </div>

            <div class="card">
                <h3>Planning Recommendations</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Recommendation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($planningRecommendations as $item)
                        <tr>
                            <td>{{ $item['product'] }}</td>
                            <td>{{ $item['recommendation'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card standalone-card">
            <h3>Product Demand Forecast</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Current Sales</th>
                        <th>Forecast</th>
                        <th>Growth</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productDemandForecast as $row)
                    <tr>
                        <td>{{ $row['product'] }}</td>
                        <td>{{ $row['current_sales'] }}</td>
                        <td>{{ $row['forecast'] }}</td>
                        <td class="{{ $row['growth_class'] }}">{{ $row['growth'] }}</td>
                        <td>{{ $row['status'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
</div>
@endsection

@push('styles')
<style>
    .forecast-demand-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 16px;
    }

    .forecast-demand-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #0b1f3a;
    }

    .filter-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-select {
        border: 1px solid #dfe3e0;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 13px;
        color: #333;
        background: #fff;
    }

    .filter-clear {
        display: flex;
        align-items: center;
        font-size: 13px;
        color: #6b7280;
        text-decoration: underline;
    }

    .toggle-pills {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }

    .pill {
        display: inline-block;
        padding: 8px 20px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid #cbd5c9;
        color: #0b3d20;
        background: #fff;
        cursor: pointer;
    }

    .pill--active {
        background: #0b3d20;
        border-color: #0b3d20;
        color: #fff;
    }

    .welcome-row--stats-only {
        grid-template-columns: repeat(4, 1fr);
        margin-bottom: 24px;
    }

    .stat-card--highlight {
        border: 2px solid #2f80ed;
        box-shadow: 0 0 0 3px rgba(47, 128, 237, 0.12);
    }

    .stat-card .success {
        color: #2e9e4f;
        font-weight: 600;
    }

    table td.success {
        color: #2e9e4f;
        font-weight: 600;
    }

    table td.warning {
        color: #d4a017;
        font-weight: 600;
    }

    .chart-canvas-box--wide {
        width: 100%;
        height: 300px;
        margin-top: 16px;
    }

    .standalone-card {
        margin-top: 24px;
    }

    /* Guarantees equal spacing between every direct section inside
       dashboard-content, regardless of which class is on it */
    .dashboard-content > section + section {
        margin-top: 24px !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ---- Historical Sales vs Forecast (line chart) ----
    const salesCtx = document.getElementById('salesForecastChart');
    if (salesCtx) {
        new Chart(salesCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [
                    {
                        label: 'Actual Sales',
                        data: @json($actualSales),
                        borderColor: '#6ea38a',
                        backgroundColor: 'rgba(110,163,138,0.15)',
                        borderWidth: 3,
                        pointBackgroundColor: '#0b3d20',
                        pointRadius: 5,
                        tension: 0.3,
                        fill: false
                    },
                    {
                        label: 'Forecast',
                        data: @json($forecastSales),
                        borderColor: '#e57373',
                        borderWidth: 3,
                        borderDash: [4, 4],
                        pointBackgroundColor: '#e57373',
                        pointRadius: 4,
                        tension: 0.3,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', align: 'end' }
                },
                scales: {
                    y: { beginAtZero: false, grid: { color: '#eef1ef' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // ---- Forecast Product Demand (bar chart) ----
    const demandCtx = document.getElementById('forecastDemandChart');
    if (demandCtx) {
        new Chart(demandCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($forecastProducts),
                datasets: [{
                    data: @json($forecastDemand),
                    backgroundColor: '#6ea38a',
                    borderRadius: 4,
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#eef1ef' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

});
</script>
@endpush