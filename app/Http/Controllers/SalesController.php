<?php

namespace App\Http\Controllers;

use App\Services\ForecastService;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();

        $sales = Sale::with('product')
            ->latest('sold_at')
            ->paginate(10);

        return view('pages.sales', compact('products', 'sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'sold_at' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);

       Sale::create([
    'product_id' => $product->id,
    'quantity' => $request->quantity,
    'revenue' => $product->unit_price * $request->quantity,
    'sold_at' => $request->sold_at,
]);
return redirect()->route('sales.index')
    ->with('success', 'Sale added successfully.');

    }

}