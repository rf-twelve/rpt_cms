<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptQuarter1 extends Model
{
    use HasFactory;
    protected $fillable = [
        'bracket',
        'bracket_code',
        'year_from',
        'year_to',
        'label',
        'january',
        'february',
        'march',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
