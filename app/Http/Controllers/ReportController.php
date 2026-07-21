<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\InventoryItem;
use App\Models\Procurement;
use App\Models\Shipment;
use App\Models\WarehouseZone;
use App\Models\Invoice;
use App\Models\ReportTemplate;

class ReportController extends Controller
{

    public function index()
{
    $reports = Report::latest()->take(10)->get();

    $rows = $reports->map(function ($r) {
        return [
            'cells' => [$r->id, $r->type, $r->submitted_by, $r->created_at ? $r->created_at->format('M d, Y') : '—'],
            'status' => ucfirst($r->status),
            'edit_id' => $r->id,
            'status_class' => match ($r->status) {
                'approved' => 'success',
                'pending'  => 'warning',
                'flagged'  => 'danger',
                default    => 'success',
            },
        ];
    })->toArray();

    return view('reports.show', $this->buildViewData(
        pageTitle: 'Dashboard',
        pageSubtitle: 'Overview of all activity reports',
        statSet: [
            ['label' => 'Total Reports', 'value' => Report::count(), 'change' => '', 'trend' => 'up', 'icon' => '📄', 'color' => 'blue'],
            ['label' => 'Pending',       'value' => Report::where('status', 'pending')->count(), 'change' => '', 'trend' => 'down', 'icon' => '⏳', 'color' => 'amber'],
            ['label' => 'Approved',      'value' => Report::where('status', 'approved')->count(), 'change' => '', 'trend' => 'up', 'icon' => '✅', 'color' => 'green'],
            ['label' => 'Flagged',       'value' => Report::where('status', 'flagged')->count(), 'change' => '', 'trend' => 'down', 'icon' => '⚠️', 'color' => 'red'],
        ],
        barLabels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        barData: [42, 55, 38, 61, 47, 29, 33],
        pieLabels: ['Inventory', 'Procurement', 'Logistics', 'Warehouse', 'Financial'],
        pieData: [28, 22, 18, 17, 15],
        tableColumns: ['Report ID', 'Type', 'Submitted By', 'Date'],
        rows: $rows
    ));
}

   public function inventory()
{
    $items = InventoryItem::latest()->take(10)->get();

    $rows = $items->map(function ($item) {
        $status = $item->quantity === 0 ? 'Out' : ($item->quantity < 100 ? 'Low' : 'In Stock');
        $statusClass = $item->quantity === 0 ? 'danger' : ($item->quantity < 100 ? 'warning' : 'success');

        return [
            'cells' => [$item->sku, $item->item_name, $item->warehouse, number_format($item->quantity)],
            'status' => $status,
            'status_class' => $statusClass,
        ];
    })->toArray();

    return view('reports.show', $this->buildViewData(
        pageTitle: 'Inventory Reports',
        pageSubtitle: 'Stock levels, movement, and reorder tracking',
        statSet: [
            ['label' => 'Total SKUs',   'value' => InventoryItem::count(), 'change' => '', 'trend' => 'up', 'icon' => '📦', 'color' => 'blue'],
            ['label' => 'Low Stock',    'value' => InventoryItem::where('quantity', '>', 0)->where('quantity', '<', 100)->count(), 'change' => '', 'trend' => 'up', 'icon' => '📉', 'color' => 'amber'],
            ['label' => 'In Stock',     'value' => InventoryItem::where('quantity', '>=', 100)->count(), 'change' => '', 'trend' => 'up', 'icon' => '📈', 'color' => 'green'],
            ['label' => 'Out of Stock', 'value' => InventoryItem::where('quantity', 0)->count(), 'change' => '', 'trend' => 'down', 'icon' => '🚫', 'color' => 'red'],
        ],
        barLabels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        barData: [1200, 1450, 1100, 1600, 1380, 1720],
        pieLabels: ['Raw Materials', 'Finished Goods', 'Packaging', 'Spare Parts'],
        pieData: [35, 30, 20, 15],
        tableColumns: ['SKU', 'Item Name', 'Warehouse', 'Qty'],
        rows: $rows
    ));
}
    
public function procurements()
{
    $pos = Procurement::latest('order_date')->take(10)->get();

    $rows = $pos->map(function ($po) {
        return [
            'cells' => [$po->po_number, $po->supplier, '₱' . number_format($po->amount, 2), $po->order_date->format('M d, Y')],
            'status' => 'Approved',
            'status_class' => 'success',
        ];
    })->toArray();

    return view('reports.show', $this->buildViewData(
        pageTitle: 'Procurements',
        pageSubtitle: 'Purchase orders, suppliers, and spend tracking',
        statSet: [
            ['label' => 'Active POs',       'value' => Procurement::count(), 'change' => '', 'trend' => 'up', 'icon' => '🛒', 'color' => 'blue'],
            ['label' => 'Awaiting Approval','value' => 0, 'change' => '', 'trend' => 'down', 'icon' => '⏳', 'color' => 'amber'],
            ['label' => 'Completed',        'value' => Procurement::count(), 'change' => '', 'trend' => 'up', 'icon' => '✅', 'color' => 'green'],
            ['label' => 'Total Spend',      'value' => '₱' . number_format(Procurement::sum('amount'), 2), 'change' => '', 'trend' => 'up', 'icon' => '💵', 'color' => 'red'],
        ],
        barLabels: ['Q1', 'Q2', 'Q3', 'Q4'],
        barData: [520000, 610000, 480000, 700000],
        pieLabels: ['Supplier A', 'Supplier B', 'Supplier C', 'Others'],
        pieData: [40, 25, 20, 15],
        tableColumns: ['PO Number', 'Supplier', 'Amount', 'Date'],
        rows: $rows
    ));
}

public function logistics()
{
    $shipments = Shipment::latest('eta')->take(10)->get();

    $rows = $shipments->map(function ($s) {
        $label = $s->status === 'on_time' ? 'On Time' : ucfirst($s->status);
        $class = $s->status === 'on_time' ? 'success' : ($s->status === 'delayed' ? 'warning' : 'danger');

        return [
            'cells' => [$s->tracking_no, $s->destination, $s->carrier, $s->eta->format('M d, Y')],
            'status' => $label,
            'status_class' => $class,
        ];
    })->toArray();

    return view('reports.show', $this->buildViewData(
        pageTitle: 'Logistics Reports',
        pageSubtitle: 'Shipments, delivery times, and route performance',
        statSet: [
            ['label' => 'Shipments', 'value' => Shipment::count(), 'change' => '', 'trend' => 'up', 'icon' => '🚚', 'color' => 'blue'],
            ['label' => 'Delayed',   'value' => Shipment::where('status', 'delayed')->count(), 'change' => '', 'trend' => 'down', 'icon' => '🕒', 'color' => 'amber'],
            ['label' => 'On Time',   'value' => Shipment::where('status', 'on_time')->count(), 'change' => '', 'trend' => 'up', 'icon' => '✅', 'color' => 'green'],
            ['label' => 'Returned',  'value' => Shipment::where('status', 'returned')->count(), 'change' => '', 'trend' => 'down', 'icon' => '↩️', 'color' => 'red'],
        ],
        barLabels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        barData: [88, 102, 95, 110, 76],
        pieLabels: ['Land', 'Air', 'Sea'],
        pieData: [60, 25, 15],
        tableColumns: ['Tracking No.', 'Destination', 'Carrier', 'ETA'],
        rows: $rows
    ));
}

public function warehouse()
{
    $zones = WarehouseZone::latest()->take(10)->get();

    $rows = $zones->map(function ($z) {
        return [
            'cells' => [$z->zone_name, $z->capacity_percent . '%', $z->staff_on_duty],
            'status' => $z->status === 'overload' ? 'Overload' : 'Normal',
            'status_class' => $z->status === 'overload' ? 'danger' : 'success',
        ];
    })->toArray();

    return view('reports.show', $this->buildViewData(
        pageTitle: 'Warehouse Reports',
        pageSubtitle: 'Space utilization, throughput, and staff activity',
        statSet: [
            ['label' => 'Capacity Used',    'value' => round(WarehouseZone::avg('capacity_percent')) . '%', 'change' => '', 'trend' => 'up', 'icon' => '🏬', 'color' => 'blue'],
            ['label' => 'Pending Putaway',  'value' => 44, 'change' => '', 'trend' => 'down', 'icon' => '📥', 'color' => 'amber'],
            ['label' => 'Zones Normal',     'value' => WarehouseZone::where('status', 'normal')->count(), 'change' => '', 'trend' => 'up', 'icon' => '✅', 'color' => 'green'],
            ['label' => 'Zones Overloaded', 'value' => WarehouseZone::where('status', 'overload')->count(), 'change' => '', 'trend' => 'down', 'icon' => '💥', 'color' => 'red'],
        ],
        barLabels: ['WH-1', 'WH-2', 'WH-3', 'WH-4'],
        barData: [72, 88, 65, 91],
        pieLabels: ['Zone A', 'Zone B', 'Zone C'],
        pieData: [45, 35, 20],
        tableColumns: ['Zone', 'Capacity', 'Staff On Duty'],
        rows: $rows
    ));
}

public function financial()
{
    $invoices = Invoice::latest('due_date')->take(10)->get();

    $rows = $invoices->map(function ($inv) {
        $label = ucfirst($inv->status);
        $class = match ($inv->status) {
            'paid' => 'success',
            'pending' => 'warning',
            'overdue' => 'danger',
            default => 'success',
        };

        return [
            'cells' => [$inv->invoice_no, $inv->client, '₱' . number_format($inv->amount, 2), $inv->due_date->format('M d, Y')],
            'status' => $label,
            'status_class' => $class,
        ];
    })->toArray();

    return view('reports.show', $this->buildViewData(
        pageTitle: 'Financial Reports',
        pageSubtitle: 'Revenue, expenses, and profitability summary',
        statSet: [
            ['label' => 'Revenue',    'value' => '₱' . number_format(Invoice::sum('amount'), 2), 'change' => '', 'trend' => 'up', 'icon' => '💰', 'color' => 'blue'],
            ['label' => 'Paid',       'value' => Invoice::where('status', 'paid')->count(), 'change' => '', 'trend' => 'up', 'icon' => '✅', 'color' => 'green'],
            ['label' => 'Pending',    'value' => Invoice::where('status', 'pending')->count(), 'change' => '', 'trend' => 'up', 'icon' => '⏳', 'color' => 'amber'],
            ['label' => 'Overdue',    'value' => '₱' . number_format(Invoice::where('status', 'overdue')->sum('amount'), 2), 'change' => '', 'trend' => 'down', 'icon' => '⚠️', 'color' => 'red'],
        ],
        barLabels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        barData: [800000, 920000, 870000, 990000, 1010000, 1180000],
        pieLabels: ['Operations', 'Payroll', 'Marketing', 'Logistics'],
        pieData: [40, 30, 15, 15],
        tableColumns: ['Invoice No.', 'Client', 'Amount', 'Due Date'],
        rows: $rows
    ));
}

public function builder()
{
    $templates = ReportTemplate::latest()->take(10)->get();

    $rows = $templates->map(function ($t) {
        return [
            'cells' => [$t->name, $t->created_by, $t->created_at->format('M d, Y')],
            'status' => ucfirst($t->status),
            'status_class' => $t->status === 'active' ? 'success' : 'warning',
        ];
    })->toArray();

    return view('reports.show', $this->buildViewData(
        pageTitle: 'Custom Report Builder',
        pageSubtitle: 'Combine any data source into a custom report',
        statSet: [
            ['label' => 'Saved Templates', 'value' => ReportTemplate::count(), 'change' => '', 'trend' => 'up', 'icon' => '🧩', 'color' => 'blue'],
            ['label' => 'Active',          'value' => ReportTemplate::where('status', 'active')->count(), 'change' => '', 'trend' => 'up', 'icon' => '✅', 'color' => 'green'],
            ['label' => 'Drafts',          'value' => ReportTemplate::where('status', 'draft')->count(), 'change' => '', 'trend' => 'down', 'icon' => '📝', 'color' => 'amber'],
            ['label' => 'Shared',          'value' => 9, 'change' => '', 'trend' => 'up', 'icon' => '🔗', 'color' => 'red'],
        ],
        barLabels: ['W1', 'W2', 'W3', 'W4'],
        barData: [4, 7, 3, 9],
        pieLabels: ['Table', 'Chart', 'Mixed'],
        pieData: [50, 30, 20],
        tableColumns: ['Template Name', 'Created By', 'Last Modified'],
        rows: $rows
    ));
}

public function create()
{
    return view('reports.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'type' => 'required|string|max:255',
        'submitted_by' => 'required|string|max:255',
        'status' => 'required|in:approved,pending,flagged',
    ]);

    Report::create($validated);

    return redirect()->route('reports.index')->with('success', 'Report added successfully!');
}
public function edit(Report $report)
{
    return view('reports.edit', compact('report'));
}

public function update(Request $request, Report $report)
{
    $validated = $request->validate([
        'type' => 'required|string|max:255',
        'submitted_by' => 'required|string|max:255',
        'status' => 'required|in:approved,pending,flagged',
    ]);

    $report->update($validated);

    return redirect()->route('reports.index')->with('success', 'Report updated successfully!');
}

    private function buildViewData(
        string $pageTitle,
        string $pageSubtitle,
        array $statSet,
        array $barLabels,
        array $barData,
        array $pieLabels,
        array $pieData,
        array $tableColumns,
        array $rows
    ): array {
        return [
            'pageTitle'    => $pageTitle,
            'pageSubtitle' => $pageSubtitle,
            'stats'        => $statSet,
            'barChart'     => [
                'title'    => 'Activity Overview',
                'subtitle' => 'Aggregated over the selected period',
                'labels'   => $barLabels,
                'data'     => $barData,
            ],
            'pieChart'     => [
                'title'    => 'Distribution',
                'subtitle' => 'Breakdown by category',
                'labels'   => $pieLabels,
                'data'     => $pieData,
            ],
            'tableTitle'   => 'Recent Records',
            'tableColumns' => $tableColumns,
            'tableRows'    => $rows,
        ];
    }
}
