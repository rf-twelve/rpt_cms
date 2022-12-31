<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'fund',
        'date',
        'account_officer_id',
        'total_amount',
        'report_id',
    ];
    protected $casts = [
        'id' => 'integer',
    ];
}




