<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'revenue',
        'sold_at',
    ];
    
    protected $casts = [
    'sold_at' => 'date',
];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}