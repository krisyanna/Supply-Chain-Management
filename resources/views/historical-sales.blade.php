@extends('layouts.app')

@section('content')
<div class="dashboard-page">
    <header class="dashboard-top container">
        <div class="search-box">
            <input type="text" placeholder="Search">
        </div>

        <nav class="dashboard-nav">
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
            <h2>Historical Sales</h2>

            <form method="GET" action="{{ route('forecasting.historical') }}" class="filter-group" id="filterForm">
                <select class="filter-select" name="range" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Date Range</option>
                    <option value="1" @selected(request('range') == '1')>Last 30 days</option>
                    <option value="6" @selected(request('range') == '6')>Last 6 months</option>
                    <option value="10" @selected(request('range') == '10')>Last 10 months</option>
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
                <a href="{{ route('forecasting.historical') }}" class="filter-clear">Clear filters</a>
                @endif
            </form>
        </section>

        <section class="toggle-pills">
            <span class="pill pill--active">Historical Sales</span>
            <a href="{{ route('forecasting.demand') }}" class="pill">Forecast Demand</a>
        </section>

        <section class="welcome-row welcome-row--stats-only">
            <div class="stat-card">
                <p>Total Unit Sold</p>
                <h3>{{ number_format($totalUnitSold) }}</h3>
                <span>Overall   Product Sold</span>
            </div>

            <div class="stat-card">
                <p>Total Revenue</p>
                <h3>₱{{ $totalRevenue }}</h3>
                <span>Overall Sales</span>
            </div>

            <div class="stat-card">
                <p>Best Selling Product</p>
                <h3>{{ $bestSellingProduct }}</h3>
                <span>Top Performer</span>
            </div>

            <div class="stat-card">
                <p>Low Selling Product</p>
                <h3>{{ $lowSellingProduct }}</h3>
                <span>Needs Promotion</span>
            </div>
        </section>

        <section class="dashboard-grid">
            <div class="card">
                <h3>Monthly Sales Trend</h3>
                <div class="chart-canvas-box chart-canvas-box--wide">
                    <canvas id="monthlySalesTrendChart"></canvas>
                </div>
            </div>

            <div class="card">
                <h3>Monthly Sales Summary</h3>
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Units</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlySalesSummary as $row)
                            <tr>
                                <td>{{ $row['month'] }}</td>
                                <td>{{ $row['units'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="card standalone-card">
            <h3>Sales History</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesHistory as $row)
                    <tr>
                        <td>{{ $row['date'] }}</td>
                        <td>{{ $row['product'] }}</td>
                        <td>{{ $row['category'] }}</td>
                        <td>{{ $row['quantity'] }}</td>
                        <td>₱{{ $row['revenue'] }}</td>
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

    .chart-canvas-box--wide {
        width: 100%;
        height: 220px;
        margin-top: 16px;
    }

    .table-scroll {
        max-height: 300px;
        overflow-y: auto;
        margin-top: 8px;
    }

    .table-scroll table {
        width: 100%;
    }

    .table-scroll thead th {
        position: sticky;
        top: 0;
        background: #cfd9d4;
        z-index: 1;
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

    // ---- Monthly Sales Trend (filled area/line chart) ----
    const trendCtx = document.getElementById('monthlySalesTrendChart');
    if (trendCtx) {
        new Chart(trendCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Units Sold',
                    data: @json($monthlySalesTrend),
                    borderColor: '#4b8c68',
                    backgroundColor: 'rgba(110,163,138,0.35)',
                    borderWidth: 2,
                    pointBackgroundColor: '#0b3d20',
                    pointRadius: 4,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: false, grid: { color: '#eef1ef' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

});
</script>
@endpush