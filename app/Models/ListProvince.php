<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListProvince extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'region_id',
        'code',
        'name',
        'index',
        'is_active',
    ];
    protected $casts = [
        'id' => 'integer',
    ];
}
