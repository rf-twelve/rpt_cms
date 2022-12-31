<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptAssessedValue extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
    ];

    public function rptAccount(){
        return $this->belongsTo(RptAccount::class);
    }

    public function getAllAVWithSelectedRptAccount() {
        return RptAssessedValue::query()
        ->with(['rptAccount' => function ($query) {
            $query->select('id', 'lp_brgy');
        }])
        ->get()->toArray();
    }
}
