<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = ['product_id', 'quantity_on_hand', 'reorder_level', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /** Human-friendly label for the status enum, e.g. "Out of stock" */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'in_stock' => 'In stock',
            'restocked' => 'Restocked',
            'low_stock' => 'Low stock',
            'out_of_stock' => 'Out of stock',
            'reserved' => 'Reserved',
            'overstock' => 'Overstocked',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}