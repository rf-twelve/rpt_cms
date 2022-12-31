<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptQuarter3 extends Model
{
    use HasFactory;
    protected $fillable = [
        'bracket',
        'bracket_code',
        'year_from',
        'year_to',
        'label',
        'july',
        'august',
        'september',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
