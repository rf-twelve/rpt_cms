<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptIssuedReceiptData extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'rpt_issued_receipt_datas';
    use HasFactory;
}
