<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')
                            ->latest()
                            ->paginate(10);

        $totalOrders = PurchaseOrder::count();

      $completedOrders = PurchaseOrder::where('status', 'Completed')->count();
      $pendingOrders = PurchaseOrder::where('status', 'Pending')->count();

        return view('purchase-orders.index', compact(
            'purchaseOrders',
            'totalOrders',
            'completedOrders',
            'pendingOrders'
        ));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();

        $nextPoNumber = 'PO-' . date('Y') . '-' .
            str_pad(PurchaseOrder::count() + 1, 3, '0', STR_PAD_LEFT);

        return view('purchase-orders.create', compact(
            'suppliers',
            'nextPoNumber'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'po_number' => 'required|unique:purchase_orders',
            'supplier_id' => 'required',
            'order_date' => 'required',
            'delivery_date' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric',
        ]);

        $grandTotal = 0;

        foreach ($validated['items'] as $item) {
            $grandTotal += $item['quantity'] * $item['price'];
        }

        $purchaseOrder = PurchaseOrder::create([
            'po_number' => $validated['po_number'],
            'supplier_id' => $validated['supplier_id'],
            'order_date' => $validated['order_date'],
            'delivery_date' => $validated['delivery_date'],
            'grand_total' => $grandTotal,
        ]);

        foreach ($validated['items'] as $item) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $purchaseOrder->id,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);
        }

        return redirect()
            ->route('purchase-orders.index')
            ->with('success', 'Purchase Order created successfully.');
    }

    public function show(PurchaseOrder $purchaseOrder)
{
    $purchaseOrder->load('supplier','items');

    return view(
        'purchase_orders.show',
        compact('purchaseOrder')
    );
}

public function edit($id)
{
    $purchaseOrder = PurchaseOrder::findOrFail($id);
    $suppliers = Supplier::all();

   
    return view('purchase-orders.edit', compact('purchaseOrder', 'suppliers'));
}

public function update(Request $request, PurchaseOrder $purchaseOrder)
{
    $validated = $request->validate([
        'supplier_id' => 'required|exists:suppliers,id',
        'order_date' => 'required|date',
        'delivery_date' => 'nullable|date',
        'status' => 'required',
        'items' => 'required|array|min:1',
        'items.*.product_name' => 'required',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
    ]);

    $grandTotal = 0;

    foreach ($validated['items'] as $item) {
        $grandTotal += $item['quantity'] * $item['price'];
    }

    $purchaseOrder->update([
        'supplier_id'   => $validated['supplier_id'],
        'order_date'    => $validated['order_date'],
        'delivery_date' => $validated['delivery_date'],
        'status'        => $validated['status'],
        'grand_total'   => $grandTotal,
    ]);

    // Delete old items
    $purchaseOrder->items()->delete();

    // Insert updated items
    foreach ($validated['items'] as $item) {

        $purchaseOrder->items()->create([
            'product_name' => $item['product_name'],
            'quantity'     => $item['quantity'],
            'price'        => $item['price'],
            'total'        => $item['quantity'] * $item['price'],
        ]);

    }

    return redirect()
            ->route('purchase-orders.index')
            ->with('success', 'Purchase Order updated successfully.');
}

public function destroy(PurchaseOrder $purchaseOrder)
{
    $purchaseOrder->items()->delete();

    $purchaseOrder->delete();

    return redirect()
            ->route('purchase-orders.index')
            ->with('success','Purchase Order deleted successfully.');
}
    
}