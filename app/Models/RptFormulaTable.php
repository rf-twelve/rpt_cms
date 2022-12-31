<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptFormulaTable extends Model
{
    use HasFactory;
    protected $fillable = [
        'year_from',
        'year_to',
        'year_count',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
