<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'month', 'current_sales', 'forecast_units',
        'growth_percent', 'status', 'recommendation',
    ];

    protected $casts = [
        'month' => 'date',
        'growth_percent' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /** e.g. "+35%" or "-4%" for display in tables */
    public function growthLabel(): string
    {
        return ($this->growth_percent >= 0 ? '+' : '').$this->growth_percent.'%';
    }
}