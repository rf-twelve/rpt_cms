<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListForm extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'is_active',
    ];
    protected $casts = [
        'id' => 'integer',
    ];
}
