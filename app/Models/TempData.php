<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempData extends Model
{
    use HasFactory;
    protected $fillable = [
        'temp_number_vax',
        'temp_pwd',
        'temp_indigenous',
        'temp_deferral',
        'temp_deferral_reason',
        'temp_vax_date',
        'temp_vax_manufacturer',
        'temp_batch_number',
        'temp_lot_number',
        'temp_cbcr_id',
        'temp_vaccinator',
        'temp_first_dose',
        'temp_second_dose',
        'temp_adverse_event',
        'temp_adverse_condition',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
