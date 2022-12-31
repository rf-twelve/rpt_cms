<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptPercentage extends Model
{
    use HasFactory;
    protected $fillable = [
        'from',
        'to',
        'count',
        'base',
        'value',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
