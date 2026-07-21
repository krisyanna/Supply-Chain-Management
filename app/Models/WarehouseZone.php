<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseZone extends Model
{
    protected $table = 'warehouse_zones';

    protected $fillable = [
        'warehouse_id',
        'zone_name',
        'description',
        'capacity',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}