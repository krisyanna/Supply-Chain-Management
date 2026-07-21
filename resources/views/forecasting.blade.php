@extends('layouts.app')

@section('content')
<div class="dashboard-page">
    <header class="dashboard-top container">
        <a href="{{ route('welcome') }}" class="brand-link">S&L</a>

        <div class="search-box">
            <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
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
    </header>

    <main class="container dashboard-content">
        <section class="welcome-row">
            <div class="welcome-text">
                <h2>Demand<br>Forecasting<br><strong>&amp; Planning</strong></h2>
            </div>

            <a href="{{ route('forecasting.historical') }}" class="stat-card stat-card--link">
    <p>Historical Sales</p>
    <h3>{{ number_format($historicalSalesTotal) }}</h3>
    <span>Products Sold Last 6 Months</span>
</a>

<a href="{{ route('forecasting.demand') }}" class="stat-card stat-card--link">
    <p>Forecast Demand</p>
    <h3>{{ number_format($forecastDemandTotal) }}</h3>
    <span>Predicted Units</span>
</a>

<div class="stat-card">
    <p>Forecast Accuracy</p>
    <h3>{{ $forecastAccuracy }}%</h3>
</div>

<div class="stat-card">
    <p>Stock Out Risk</p>
    <h3>{{ $stockOutRisk }}</h3>
</div>
        </section>

        <section class="dashboard-grid">
            <div class="card">
                <h3>Historical Sales vs Forecast</h3>
                <div class="chart-canvas-box chart-canvas-box--wide">
                    <canvas id="salesForecastChart"></canvas>
                </div>
            </div>

            <div class="card">
                <h3>Inventory Risk</h3>
                <div class="chart-wrap">
                    <div class="chart-canvas-box">
                        <canvas id="inventoryRiskChart"></canvas>
                    </div>
                </div>
                <ul class="chart-legend chart-legend--horizontal">
                    <li><span class="dot" style="background:#0b3d20"></span> Healthy Stock</li>
                    <li><span class="dot" style="background:#d4c400"></span> Overstock</li>
                    <li><span class="dot" style="background:#e53935"></span> Stock Out Risk</li>
                </ul>
            </div>
        </section>

        <section class="dashboard-grid">
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
            <h3>Top Growing Products</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Growth</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topGrowingProducts as $item)
                    <tr>
                        <td>{{ $item['product'] }}</td>
                        <td class="success">{{ $item['growth'] }}</td>
                        <td>{{ $item['status'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="card standalone-card">
            <h3>Historical Sales &amp; Forecast Data</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        @foreach($months as $month)
                        <th>{{ $month }}</th>
                        @endforeach
                        <th>Forecast</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historicalData as $row)
                    <tr>
                        <td>{{ $row['product'] }}</td>
                        @foreach($row['values'] as $value)
                        <td>{{ $value }}</td>
                        @endforeach
                        <td>{{ $row['forecast'] }}</td>
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
    .chart-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed #cbd5c9;
        border-radius: 12px;
        padding: 16px;
        margin-top: 16px;
    }

    .chart-legend {
        list-style: none;
        padding: 0;
        margin: 12px 0 0;
        font-size: 13px;
        color: #333;
    }

    .chart-legend li {
        display: inline-flex;
        align-items: center;
        margin-right: 16px;
    }

    .chart-legend--horizontal {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .chart-legend .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
        flex-shrink: 0;
    }

    .chart-canvas-box {
        position: relative;
        width: 220px;
        height: 220px;
        margin: 16px auto 0;
    }

    .chart-canvas-box--wide {
        width: 100%;
        height: 320px;
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

    .stat-card--link {
        display: block;
        text-decoration: none;
        color: inherit;
        cursor: pointer;
        transition: box-shadow 0.15s ease, transform 0.15s ease;
    }

    .stat-card--link:hover {
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
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
                        borderColor: '#e53935',
                        borderWidth: 3,
                        borderDash: [4, 4],
                        pointBackgroundColor: '#e53935',
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

    // ---- Inventory Risk (donut chart) ----
    const riskCtx = document.getElementById('inventoryRiskChart');
    if (riskCtx) {
        new Chart(riskCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Healthy Stock', 'Overstock', 'Stock Out Risk'],
                datasets: [{
                    data: @json($inventoryRisk),
                    backgroundColor: ['#0b3d20', '#d4c400', '#e53935'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total ? ((value / total) * 100).toFixed(1) : 0;
                                return `${context.label}: ${value} (${pct}%)`;
                            }
                        }
                    }
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
                    maxBarThickness: 60
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