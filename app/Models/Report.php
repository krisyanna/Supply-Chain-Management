<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
protected $fillable = ['type', 'submitted_by', 'status'];
}
