<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptQuarter2 extends Model
{
    use HasFactory;
    protected $fillable = [
        'bracket',
        'bracket_code',
        'year_from',
        'year_to',
        'label',
        'april',
        'may',
        'june',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
