<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'po_number',
        'supplier_id',
        'order_date',
        'delivery_date',
        'status',
        'grand_total',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}