<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
protected function casts(): array
    {
        return [
            'order_date' => 'date',
        ];
    }
}
