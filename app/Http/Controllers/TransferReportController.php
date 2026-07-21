<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transfer;
use App\Models\Warehouse;

class TransferReportController extends Controller
{
    public function index()
    {
        $transfers = Transfer::with([
            'product',
            'fromWarehouse',
            'toWarehouse'
        ])->latest()->get();

        $summary = [
            'products' => Product::count(),
            'high_demand' => Product::where('status', 'Low Stock')->count(),
            'current_stock' => Product::sum('stock'),
            'recommend_transfer' => $transfers->where('status', 'Pending')->count(),
        ];

        $tracking = $transfers;

        $inventory = Product::all();

        $performance = Warehouse::withCount('products')->get();

        return view('transfers', compact(
            'summary',
            'transfers',
            'tracking',
            'inventory',
            'performance'
        ));
    }
}