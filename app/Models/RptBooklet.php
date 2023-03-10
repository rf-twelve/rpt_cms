<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptBooklet extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [
        'id' => 'integer',
    ];

    public function users(){ return $this->belongsTo(User::class, 'user_id');}

    public function getFormNameAttribute(){
        return (ListForm::find($this->id))->name ?? 'Unknown';
    }
}
