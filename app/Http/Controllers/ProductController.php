<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ProductController extends InventoryController
{
    public function index()
    {
        $products = Product::with('warehouse')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        return view('products.create', compact('warehouses'));
    }

   public function store(Request $request)
{
    $request->validate([
        'warehouse_id' => 'required|exists:warehouses,id',
        'product_name' => 'required|string|max:255',
        'stock' => 'required|integer',
        'reserved' => 'required|integer',
        'status' => 'required'
    ]);

    Product::create([
        'warehouse_id' => $request->warehouse_id,
        'product_name' => $request->product_name,
        'stock' => $request->stock,
        'reserved' => $request->reserved,
        'status' => $request->status,
    ]);

    return redirect()->route('products.index')
        ->with('success', 'Product added successfully.');
}

    public function edit(Product $product)
    {
        $warehouses = Warehouse::all();
        return view('products.edit', compact('product', 'warehouses'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}