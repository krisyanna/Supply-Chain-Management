<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'shipment_code',
        'driver_name',
        'route_path',
        'estimated_arrival',
        'status',
        'meta_info',
        'phone_number',
        'origin_address',
        'destination_address',
        'cargo_details',
        'quantity',
        'payment_status',
        'delivery_cost',
        'schedule_category',
    ];

    protected function casts(): array
    {
        return [
            'delivery_cost' => 'decimal:2',
        ];
    }
}