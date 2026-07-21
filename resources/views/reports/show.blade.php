@extends('layouts.app')

@section('title', $pageTitle)

@section('content')

    {{-- ================= PAGE HEADER ================= --}}
    <div class="page-header">
        <div>
            <h1>{{ $pageTitle }}</h1>
            <p>{{ $pageSubtitle }}</p>
        </div>
        <div class="page-actions">
            <button class="btn btn-outline">⤓ Export</button>
            <button class="btn btn-outline">⟳ Refresh</button>
            <a href="{{ route('reports.create') }}" class="btn btn-primary">+ New Report</a>
        </div>
        </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="stat-grid">
        @foreach($stats as $stat)
            <div class="card stat-card">
                <div>
                    <div class="stat-label">{{ $stat['label'] }}</div>
                    <div class="stat-value">{{ $stat['value'] }}</div>
                    <div class="stat-delta {{ $stat['trend'] }}">
                        {{ $stat['trend'] === 'up' ? '▲' : '▼' }} {{ $stat['change'] }}
                    </div>
                </div>
                <div class="stat-icon bg-{{ $stat['color'] }}">{{ $stat['icon'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- ================= CHARTS ================= --}}
    <div class="chart-grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3>{{ $barChart['title'] }}</h3>
                    <div class="card-sub">{{ $barChart['subtitle'] }}</div>
                </div>
            </div>
            <canvas id="mainBarChart" height="110"></canvas>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <h3>{{ $pieChart['title'] }}</h3>
                    <div class="card-sub">{{ $pieChart['subtitle'] }}</div>
                </div>
            </div>
            <canvas id="mainPieChart" height="200"></canvas>
        </div>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="card table-card">
        <div class="card-header">
            <div>
                <h3>{{ $tableTitle }}</h3>
                <div class="card-sub">Latest records</div>
            </div>
            <button class="btn btn-outline">View all</button>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    @foreach($tableColumns as $col)
                        <th>{{ $col }}</th>
                    @endforeach
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tableRows as $row)
                    <tr>
                        @foreach($row['cells'] as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                        <td>
                            <span class="badge badge-{{ $row['status_class'] }}">{{ $row['status'] }}</span>
                        </td>
                        <td>
                            <div class="row-actions">
                                <button class="icon-action" title="View">👁</button>
                                @if(isset($row['edit_id']))
    <a href="{{ route('reports.edit', $row['edit_id']) }}" class="icon-action" title="Edit">✎</a>
@else
    <button class="icon-action" title="Edit">✎</button>
@endif
                                <button class="icon-action" title="Delete">🗑</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ count($tableColumns) + 2 }}">No records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
<script>
    // Data injected from the controller (replace with live DB values later)
    const barLabels = @json($barChart['labels']);
    const barData   = @json($barChart['data']);
    const pieLabels = @json($pieChart['labels']);
    const pieData   = @json($pieChart['data']);

    new Chart(document.getElementById('mainBarChart'), {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: '{{ $barChart['title'] }}',
                data: barData,
                backgroundColor: '#3b82f6',
                borderRadius: 6,
                maxBarThickness: 34
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#eef1f6' } },
                x: { grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('mainPieChart'), {
        type: 'doughnut',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData,
                backgroundColor: ['#3b82f6', '#22c55e', '#f59e0b', '#ef4444', '#a855f7']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } }
        }
    });
</script>
@endpush
