<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogisticsShipment;

class LogisticsController extends Controller
{
    /**
     * Retrieve all shipment rows from MySQL database.
     */
    public function index()
    {
        $shipments = LogisticsShipment::orderBy('created_at', 'desc')->get();
        return view('logistics-dashboard', compact('shipments'));
    }

    /**
     * Store (Insert) a newly registered shipment record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipment_code' => 'required|string|unique:shipments,shipment_code',
            'driver_name' => 'required|string|max:255',
            'route_path' => 'required|string',
            'estimated_arrival' => 'required|string',
            'status' => 'required|string',
            'meta_info' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'origin_address' => 'required|string',
            'destination_address' => 'required|string',
            'cargo_details' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'payment_status' => 'required|string',
            'delivery_cost' => 'required|numeric|min:0',
            'schedule_category' => 'required|string'
        ]);

        if (empty($validated['phone_number'])) {
            $validated['phone_number'] = '+63 912 575 4567';
        }
        if (empty($validated['meta_info'])) {
            $validated['meta_info'] = '4h 22m left';
        }

        LogisticsShipment::create($validated);

        return redirect()->back()->with('success', 'New shipment record added successfully to MySQL!');
    }

    /**
     * Update an existing shipment log.
     */
    public function update(Request $request, $id)
    {
        $shipment = LogisticsShipment::findOrFail($id);

        $validated = $request->validate([
            'driver_name' => 'required|string|max:255',
            'route_path' => 'required|string',
            'estimated_arrival' => 'required|string',
            'status' => 'required|string',
            'meta_info' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'origin_address' => 'nullable|string',
            'destination_address' => 'nullable|string',
            'cargo_details' => 'nullable|string',
            'delivery_cost' => 'required|numeric|min:0'
        ]);

        if (empty($validated['phone_number'])) {
            $validated['phone_number'] = $shipment->phone_number;
        }

        $shipment->update($validated);

        return redirect()->back()->with('success', 'Shipment log updated successfully in MySQL!');
    }

    /**
     * Delete a shipment record from MySQL.
     */
    public function destroy($id)
    {
        $shipment = LogisticsShipment::findOrFail($id);
        $shipment->delete();

        return redirect()->back()->with('success', 'Shipment record deleted successfully from MySQL!');
    }
}