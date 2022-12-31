<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptIssuedReceipt extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function receipt_datas()
    {
        return $this->hasMany(RptIssuedReceiptData::class);
    }
}
