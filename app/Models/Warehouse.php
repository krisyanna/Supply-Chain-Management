<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';

    protected $fillable = [
        'warehouse_name',
        'location',
    ];

    public function transfersFrom()
    {
        return $this->hasMany(Transfer::class, 'from_warehouse');
    }

    public function transfersTo()
    {
        return $this->hasMany(Transfer::class, 'to_warehouse');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function zones()
    {
        return $this->hasMany(WarehouseZone::class);
    }
}