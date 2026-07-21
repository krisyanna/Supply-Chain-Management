<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transfer;
use App\Models\Warehouse;

class DashboardController extends InventoryController
{
    public function index()
    {
        // Dashboard Cards
        $warehouseCount = Warehouse::count();
        $productCount = Product::count();
        $pendingTransfers = Transfer::where('status', 'Pending')->count();
        $lowStocks = Product::where('status', 'Low Stock')->count();

        // Stock Monitoring Table
        $products = Product::join('warehouses', 'products.warehouse_id', '=', 'warehouses.id')
            ->select(
                'warehouses.warehouse_name',
                'products.product_name',
                'products.stock',
                'products.reserved',
                'products.status'
            )
            ->get();

        // Transfers Table
        $transfers = Transfer::join('warehouses as w1', 'transfers.from_warehouse', '=', 'w1.id')
            ->join('warehouses as w2', 'transfers.to_warehouse', '=', 'w2.id')
            ->select(
                'w1.warehouse_name as fromWarehouse',
                'w2.warehouse_name as toWarehouse',
                'transfers.product_name',
                'transfers.quantity',
                'transfers.status'
            )
            ->get();


            $stats = [
    [
        'label' => 'Total Warehouse',
        'value' => $warehouseCount,
        'sub' => 'Distribution Center',
        'icon' => 'warehouse',
        'color' => 'text-emerald-600',
        'bg' => 'bg-emerald-50'
    ],
    [
        'label' => 'Total Products',
        'value' => $productCount,
        'sub' => 'All Product Items',
        'icon' => 'box',
        'color' => 'text-violet-600',
        'bg' => 'bg-violet-50'
    ],
    [
        'label' => 'Pending Transfers',
        'value' => $pendingTransfers,
        'sub' => 'Awaiting transfers',
        'icon' => 'truck',
        'color' => 'text-blue-600',
        'bg' => 'bg-blue-50'
    ],
    [
        'label' => 'Low Stocks Alert',
        'value' => $lowStocks,
        'sub' => 'Items Requiring Restock',
        'icon' => 'alert',
        'color' => 'text-red-600',
        'bg' => 'bg-red-50'
    ],
];
       return view('dashboard', compact(
    'stats',
    'products',
    'transfers'
));
    }
}