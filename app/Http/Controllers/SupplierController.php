<?php

namespace App\Http\Controllers;

use App\Models\Supplier;

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
}