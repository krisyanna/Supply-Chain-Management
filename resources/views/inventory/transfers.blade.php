<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Transfers & Reports</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body{
        font-family:'Inter',sans-serif;
    }

    .status-dot{
        display:inline-block;
        width:8px;
        height:8px;
        border-radius:9999px;
        margin-right:6px;
    }
</style>

</head>

<body class="bg-[#F5F6FA] text-slate-800">

<div class="flex min-h-screen">

    @php
        $active = 'transfers';
    @endphp

    @include('layouts.sidebar')

    <main class="flex-1 p-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                Transfers & Reports
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Real time overview of inventory, warehouse and stock operation
            </p>
        </div>

        {{-- Summary --}}
        <div class="bg-white rounded-xl shadow-sm px-6 py-5 mb-6 flex items-center">

            <div class="flex-1">
                <p class="text-xs text-gray-500 mb-1">
                    Product
                </p>

                <p class="text-3xl font-bold">
                    {{ $summary['products'] }}
                </p>
            </div>

            <div class="w-px h-10 bg-emerald-700 mx-6"></div>

            <div class="flex-1">
                <p class="text-xs text-gray-500 mb-1">
                    High Demand
                </p>

                <p class="text-3xl font-bold">
                    {{ $summary['high_demand'] }}
                </p>
            </div>

            <div class="w-px h-10 bg-emerald-700 mx-6"></div>

            <div class="flex-1">
                <p class="text-xs text-gray-500 mb-1">
                    Current Stock
                </p>

                <p class="text-3xl font-bold">
                    {{ $summary['current_stock'] }}
                </p>
            </div>

            <div class="w-px h-10 bg-emerald-700 mx-6"></div>

            <div class="flex-1">
                <p class="text-xs text-gray-500 mb-1">
                    Pending Transfers
                </p>

                <p class="text-3xl font-bold">
                    {{ $summary['recommend_transfer'] }}
                </p>
            </div>

        </div>

        {{-- Transfer List --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

            <h2 class="font-semibold mb-4">
                Inter-Warehouse Transfer List
            </h2>

            @php

                $statusColors = [

                    'Pending'=>'bg-yellow-400',

                    'In Transit'=>'bg-blue-500',

                    'Completed'=>'bg-green-500',

                ];

            @endphp

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>

                        <tr class="border-b text-left text-gray-500">

                            <th class="py-2">ID</th>

                            <th class="py-2">From</th>

                            <th class="py-2">To</th>

                            <th class="py-2">Product</th>

                            <th class="py-2">Quantity</th>

                            <th class="py-2">Created</th>

                            <th class="py-2">Status</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($transfers as $transfer)

                        <tr class="border-b">

                            <td class="py-3">

                                {{ $transfer->id }}

                            </td>

                            <td class="py-3">

                                {{ $transfer->fromWarehouse->warehouse_name }}

                            </td>

                            <td class="py-3">

                                {{ $transfer->toWarehouse->warehouse_name }}

                            </td>

                            <td class="py-3">

                                {{ $transfer->product->name }}

                            </td>

                            <td class="py-3">

                                {{ $transfer->quantity }}

                            </td>

                            <td class="py-3">

                                {{ $transfer->created_at->format('M d, Y') }}

                            </td>

                            <td class="py-3">

                                <span class="status-dot {{ $statusColors[$transfer->status] }}"></span>

                                {{ $transfer->status }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-6 text-gray-500">

                                No transfers found.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Tracking --}}

        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">

            <h2 class="font-semibold mb-4">

                Transfer Tracking

            </h2>

            <table class="w-full text-sm">

                <thead>

                    <tr class="border-b text-left text-gray-500">

                        <th>ID</th>

                        <th>From</th>

                        <th>To</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                @foreach($tracking as $track)

                    <tr class="border-b">

                        <td class="py-3">

                            {{ $track->id }}

                        </td>

                        <td>

                            {{ $track->fromWarehouse->warehouse_name }}

                        </td>

                        <td>

                            {{ $track->toWarehouse->warehouse_name }}

                        </td>

                        <td>

                            {{ $track->status }}

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

        <div class="grid grid-cols-2 gap-6">

                    {{-- Inventory Report --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">

                <div class="bg-[#1f2f5c] text-white px-5 py-3 text-sm font-semibold">
                    Inventory Report
                </div>

                <table class="w-full text-sm">

                    <thead>

                        <tr class="text-left text-gray-500 border-b">

                            <th class="py-2 px-5 font-medium">
                                Product
                            </th>

                            <th class="py-2 px-3 font-medium">
                                SKU
                            </th>

                            <th class="py-2 px-3 font-medium">
                                Warehouse
                            </th>

                            <th class="py-2 px-3 font-medium">
                                Stock
                            </th>

                            <th class="py-2 px-3 font-medium">
                                Reserved
                            </th>

                            <th class="py-2 px-3 font-medium">
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($inventory as $product)

                        <tr class="border-b last:border-0">

                            <td class="py-3 px-5">
                                {{ $product->name }}
                            </td>

                            <td class="py-3 px-3">
                                {{ $product->sku }}
                            </td>

                            <td class="py-3 px-3">
                                {{ optional($product->warehouse)->warehouse_name ?? '-' }}
                            </td>

                            <td class="py-3 px-3">
                                {{ $product->stock }}
                            </td>

                            <td class="py-3 px-3">
                                {{ $product->reserved }}
                            </td>

                            <td class="py-3 px-3">

                                @if($product->status == 'In Stock')

                                    <span class="status-dot bg-green-500"></span>

                                @elseif($product->status == 'Low Stock')

                                    <span class="status-dot bg-yellow-400"></span>

                                @else

                                    <span class="status-dot bg-red-500"></span>

                                @endif

                                {{ $product->status }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center py-5 text-gray-500">
                                No products found.
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Warehouse Performance --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">

                <div class="bg-[#1f2f5c] text-white px-5 py-3 text-sm font-semibold">
                    Warehouse Performance Report
                </div>

                <table class="w-full text-sm">

                    <thead>

                        <tr class="text-left text-gray-500 border-b">

                            <th class="py-2 px-5 font-medium">
                                Warehouse
                            </th>

                            <th class="py-2 px-3 font-medium">
                                Products
                            </th>

                            <th class="py-2 px-3 font-medium">
                                Total Stock
                            </th>

                            <th class="py-2 px-3 font-medium">
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($performance as $warehouse)

                        @php

                            $totalStock = $warehouse->products->sum('stock');

                        @endphp

                        <tr class="border-b last:border-0">

                            <td class="py-3 px-5">

                                {{ $warehouse->warehouse_name }}

                            </td>

                            <td class="py-3 px-3">

                                {{ $warehouse->products_count }}

                            </td>

                            <td class="py-3 px-3">

                                {{ $totalStock }}

                            </td>

                            <td class="py-3 px-3">

                                @if($totalStock > 100)

                                    <span class="status-dot bg-green-500"></span>

                                    Healthy

                                @elseif($totalStock > 20)

                                    <span class="status-dot bg-yellow-400"></span>

                                    Moderate

                                @else

                                    <span class="status-dot bg-red-500"></span>

                                    Low Stock

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center py-5 text-gray-500">
                                No warehouses found.
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

            </main>

</div>

</body>
</html>