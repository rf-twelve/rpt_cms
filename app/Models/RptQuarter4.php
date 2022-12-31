<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptQuarter4 extends Model
{
    use HasFactory;
    protected $fillable = [
        'bracket',
        'bracket_code',
        'year_from',
        'year_to',
        'label',
        'october',
        'november',
        'december',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
