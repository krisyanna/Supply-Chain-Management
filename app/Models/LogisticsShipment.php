<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticsShipment extends Model
{
    use HasFactory;

    // Tinutukoy natin na ang gagamiting MySQL table ay 'shipments' pa rin
    protected $table = 'shipments';

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
        'schedule_category'
    ];
}