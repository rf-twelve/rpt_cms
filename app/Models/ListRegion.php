<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListRegion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'code',
        'name',
        'index',
        'is_active',
    ];
    protected $casts = [
        'id' => 'integer',
    ];
}
