<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptBracket extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
    ];
}
