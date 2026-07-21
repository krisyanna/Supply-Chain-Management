<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        $totalSuppliers = $suppliers->count();
        $activeSuppliers = $suppliers->where('status', 'Active')->count();
        $pendingSuppliers = $suppliers->where('status', 'Pending')->count();

        return view('suppliers.index', compact(
            'suppliers',
            'totalSuppliers',
            'activeSuppliers',
            'pendingSuppliers'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'contact_person' => 'required|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'phone_number' => 'required|max:20',
            'status' => 'required|in:Active,Pending',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier added successfully.');
    }
}