<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Top stat cards
        $totalInventory = Product::count();

        // No Procurement/Logistics/Suppliers tables yet - these stay static
        // until those pages exist. Swap for real queries once you build them.
        $totalOrders = 156;
        $activeShipments = 84;
        $totalSuppliers = 38;

        // Real trend behind the "Total Inventory" sparkline: units sold per
        // month for the last 6 months. Not literally inventory-count-over-time
        // (we don't snapshot that yet), but genuine recent activity data -
        // more honest than a static decorative bar chart.
        $inventoryTrend = collect(range(5, 0))->map(function ($i) {
            $start = Carbon::now()->subMonths($i)->startOfMonth();
            $end = Carbon::now()->subMonths($i)->endOfMonth();

            return (int) Sale::whereBetween('sold_at', [$start, $end])->sum('quantity');
        })->all();

        // Inventory Overview donut - counts products per stock status
        $counts = Inventory::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stockStatus = [
            'in_stock' => (int) ($counts['in_stock'] ?? 0),
            'restocked' => (int) ($counts['restocked'] ?? 0),
            'low_stock' => (int) ($counts['low_stock'] ?? 0),
            'out_of_stock' => (int) ($counts['out_of_stock'] ?? 0),
            'reserved' => (int) ($counts['reserved'] ?? 0),
        ];

        // Stock Reminder table - one notable product per status, most urgent first
        $stockReminders = Inventory::with('product')
            ->whereIn('status', ['out_of_stock', 'low_stock', 'overstock', 'restocked'])
            ->orderByRaw("FIELD(status, 'out_of_stock', 'low_stock', 'overstock', 'restocked')")
            ->limit(4)
            ->get()
            ->map(fn ($inventory) => [
                'product' => $inventory->product->name,
                'status' => $inventory->statusLabel(),
                'status_key' => $inventory->status,
            ]);

        // No activity log table yet - static for now, matching the screenshot.
        $recentActivities = [
            ['time' => '09:15 AM', 'activity' => 'Purchase Order #1234 Approved'],
            ['time' => '10:20 AM', 'activity' => 'Shipment #908 Dispatched'],
            ['time' => '11:40 AM', 'activity' => 'Warehouse A Stock Updated'],
        ];

        return view('pages.dashboard', compact(
            'totalInventory',
            'totalOrders',
            'activeShipments',
            'totalSuppliers',
            'inventoryTrend',
            'stockStatus',
            'stockReminders',
            'recentActivities'
        ));
    }
}