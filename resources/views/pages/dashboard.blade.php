@extends('layouts.app')
Paracale
Aquino, Juliana

3:12
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

    <a href="#">LOGISTICS</a>
    <a href="#">INVENTORY</a>
    <a href="#">REPORTS</a>
</nav>
    </header>
              
    <main class="container dashboard-content">
        <section class="welcome-row">
            <div class="welcome-text">                
                <h2>Welcome back,<br><strong>Manager!</strong></h2>
            </div>

            <div class="stat-card stat-card--icon">
                <div class="stat-icon icon-blue">
                    <svg width="20" height="20" viewBox="0 0  24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8V21H3V8"/><path d="M1 3H23V8H1V3Z"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                </div>
                <p>Total Inventory</p>
                <h3>{{ number_format($totalInventory) }}</h3>
                <span>All inventory items</span>
                @php
                    // Scale the 6 real monthly values to fit a 0-24 tall viewBox,
                    // same visual language as the static bars this replaces.
                    $max = max($inventoryTrend) ?: 1;
                    $barWidth = 7;
                    $gap = 4;
                @endphp
                <svg class="sparkline" viewBox="0 0 60 24" preserveAspectRatio="none">
                    @foreach($inventoryTrend as $i => $value)
                        @php
                            $height = max(2, round(($value / $max) * 24));
                            $x = $i * ($barWidth + $gap);
                            $y = 24 - $height;
                        @endphp
                        <rect x="{{ $x }}" y="{{ $y }}" width="{{ $barWidth }}" height="{{ $height }}" rx="1.5" fill="#3b82f6"/>
                    @endforeach
                </svg>
            </div>

            <div class="stat-card stat-card--icon">
                <div class="stat-icon icon-teal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20V22H6.5A2.5 2.5 0 0 1 4 19.5V4.5A2.5 2.5 0 0 1 6.5 2Z"/></svg>
                </div>
                <p>Total Orders</p>
                <h3>{{ number_format($totalOrders) }}</h3>
                <span>All purchase order</span>
                {{-- Decorative placeholder - no Procurement table yet, so there's no real trend to show --}}
                <svg class="sparkline" viewBox="0 0 60 24" preserveAspectRatio="none">
                    <rect x="0" y="16" width="7" height="8" rx="1.5" fill="#14b8a6"/>
                    <rect x="11" y="13" width="7" height="11" rx="1.5" fill="#14b8a6"/>
                    <rect x="22" y="14" width="7" height="10" rx="1.5" fill="#14b8a6"/>
                    <rect x="33" y="9" width="7" height="15" rx="1.5" fill="#14b8a6"/>
                    <rect x="44" y="7" width="7" height="17" rx="1.5" fill="#14b8a6"/>
                    <rect x="55" y="2" width="7" height="22" rx="1.5" fill="#14b8a6"/>
                </svg>
            </div>

            <div class="stat-card stat-card--icon">
                <div class="stat-icon icon-navy">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="7" width="15" height="13"/><path d="M16 10H20L23 13V20H16V10Z"/><circle cx="6" cy="20" r="2"/><circle cx="19" cy="20" r="2"/></svg>
                </div>
                <p>Active Shipments</p>
                <h3>{{ number_format($activeShipments) }}</h3>
                <span>Awaiting confirmation</span>
                {{-- Decorative placeholder - no Logistics table yet, so there's no real trend to show --}}
                <svg class="sparkline" viewBox="0 0 60 24" preserveAspectRatio="none">
                    <rect x="0" y="15" width="7" height="9" rx="1.5" fill="#1a237e"/>
                    <rect x="11" y="17" width="7" height="7" rx="1.5" fill="#1a237e"/>
                    <rect x="22" y="11" width="7" height="13" rx="1.5" fill="#1a237e"/>
                    <rect x="33" y="13" width="7" height="11" rx="1.5" fill="#1a237e"/>
                    <rect x="44" y="6" width="7" height="18" rx="1.5" fill="#1a237e"/>
                    <rect x="55" y="4" width="7" height="20" rx="1.5" fill="#1a237e"/>
                </svg>
            </div>

            <div class="stat-card stat-card--icon">
                <div class="stat-icon icon-purple">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21V19A4 4 0 0 0 13 15H5A4 4 0 0 0 1 19V21"/><circle cx="9" cy="7" r="4"/><path d="M23 21V19A4 4 0 0 0 20 15.13"/><path d="M16 3.13A4 4 0 0 1 16 10.87"/></svg>
                </div>
                <p>Total Suppliers</p>
                <h3>{{ number_format($totalSuppliers) }}</h3>
                <span>Active suppliers</span>
                {{-- Decorative placeholder - no Suppliers table yet, so there's no real trend to show --}}
                <svg class="sparkline" viewBox="0 0 60 24" preserveAspectRatio="none">
                    <rect x="0" y="17" width="7" height="7" rx="1.5" fill="#8b5cf6"/>
                    <rect x="11" y="14" width="7" height="10" rx="1.5" fill="#8b5cf6"/>
                    <rect x="22" y="15" width="7" height="9" rx="1.5" fill="#8b5cf6"/>
                    <rect x="33" y="9" width="7" height="15" rx="1.5" fill="#8b5cf6"/>
                    <rect x="44" y="8" width="7" height="16" rx="1.5" fill="#8b5cf6"/>
                    <rect x="55" y="1" width="7" height="23" rx="1.5" fill="#8b5cf6"/>
                </svg>
            </div>
        </section>

        <section class="dashboard-grid">
            <div class="card inventory-card">
                <h3>Inventory Overview</h3>

                <div class="chart-wrap">
                    <ul class="chart-legend">
                        <li><span class="dot" style="background:#0b3d20"></span> In stock</li>
                        <li><span class="dot" style="background:#4caf20"></span> Restocked</li>
                        <li><span class="dot" style="background:#f4d900"></span> Low Stock</li>
                        <li><span class="dot" style="background:#e53935"></span> Out of Stock</li>
                        <li><span class="dot" style="background:#1a237e"></span> Reserved</li>
                    </ul>

                    <div class="chart-canvas-box">
                        <canvas id="inventoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="card reminder-card">
                <h3>Stock Reminder</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockReminders as $reminder)
                        <tr>
                            <td>{{ $reminder['product'] }}</td>
                            <td class="{{ match($reminder['status_key']) {
                                'out_of_stock' => 'danger',
                                'low_stock' => 'warning',
                                'overstock' => 'orange',
                                'restocked' => 'success',
                                default => '',
                            } }}">{{ $reminder['status'] }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2">No stock reminders right now.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card activity-card">
            <h3>Recent Activities</h3>
            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentActivities as $activity)
                    <tr><td>{{ $activity['time'] }}</td><td>{{ $activity['activity'] }}</td></tr>
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
        gap: 24px;
        border: 1px dashed #cbd5c9;
        border-radius: 12px;
        padding: 24px;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .chart-legend {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 13px;
        color: #333;
    }

    .chart-legend li {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    .chart-legend .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        flex-shrink: 0;
    }

    .chart-canvas-box {
        position: relative;
        width: 220px;
        height: 220px;
        flex-shrink: 0;
        margin: 0 auto;
    }

    /* Fix: icon was overlapping the label/number, so lay it out
       beside the text instead of stacked on top of it. */
    .stat-card.stat-card--icon {
        position: relative;
        display: grid !important;
        grid-template-columns: 48px 1fr;
        grid-template-rows: auto auto auto auto;
        column-gap: 14px;
        row-gap: 2px;
        align-items: start;
    }

    .stat-card.stat-card--icon .stat-icon {
        position: static !important;
        top: auto;
        left: auto;
        grid-column: 1;
        grid-row: 1 / 5;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-card.stat-card--icon .stat-icon svg {
        width: 32px;
        height: 32px;
    }

    .stat-card.stat-card--icon p {
        grid-column: 2;
        grid-row: 1;
        margin: 0;
    }

    .stat-card.stat-card--icon h3 {
        grid-column: 2;
        grid-row: 2;
        margin: 0;
    }

    .stat-card.stat-card--icon span {
        grid-column: 2;
        grid-row: 3;
        margin-top: 4px;
    }

    .stat-card.stat-card--icon .sparkline {
        grid-column: 2;
        grid-row: 4;
        justify-self: end;
        width: 90px;
        height: 30px;
        margin-top: 8px;
    }
        .dashboard-nav a {
    padding: 10px 20px;
    border-radius: 999px;
    transition: background .2s, color .2s;
}

.dashboard-nav a.active {
    background: #101d3a;   /* dark navy pill, matches your screenshot */
    color: #ffffff;
}

.dashboard-nav a:not(.active):hover {
    background: rgba(16, 29, 58, .06);
}
    
</style>

@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('inventoryChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    // Real counts from the Inventory table, passed in by DashboardController
    const chartData = @json(array_values($stockStatus));
    const chartLabels = ['In stock', 'Restocked', 'Low Stock', 'Out of Stock', 'Reserved'];
    const chartColors = ['#0b3d20', '#4caf20', '#f4d900', '#e53935', '#1a237e'];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: chartColors,
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
});
</script>
@endpush