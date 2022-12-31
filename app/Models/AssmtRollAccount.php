<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssmtRollAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'assmt_roll_td_arp_no',
        'assmt_roll_pin',
        'assmt_roll_lot_blk_no',
        'assmt_roll_owner',
        'assmt_roll_address',
        'assmt_roll_brgy',
        'assmt_roll_municity',
        'assmt_roll_province',
        'assmt_roll_kind',
        'assmt_roll_class',
        'assmt_roll_av',
        'assmt_roll_effective',
        'assmt_roll_td_arp_no_prev',
        'assmt_roll_av_prev',
        'assmt_roll_remarks',
        'assmt_roll_status',
        'encoded_by',
        'import_by',
    ];
    protected $casts = [
        'id' => 'integer',
    ];

    public static function assessment_roll_report(){


        $account = AssmtRollAccount::get();
        // L - Land
        // B - Building
        // M - Machineries
        // $data = $account->where('assmt_roll_kind','L')->sum('assmt_roll_av');
        // $data = $account->where('assmt_roll_kind','B')->sum('assmt_roll_av');
        // $data = $account->where('assmt_roll_kind','M')->sum('assmt_roll_av');
        // $data = $account->sum('assmt_roll_av');
        $data = $account->sum('assmt_roll_av')*0.02;
        // $data = $account->sum('assmt_roll_av_prev');
        return $data;

        // Initialize variables
        $assmt_roll_report = [];

        foreach ($account as $key => $value) {
            # code...
        }

    $assmt_roll_report['barangay'] = '';
    $assmt_roll_report['code'] = '';
    $assmt_roll_report['land'] = '';
    $assmt_roll_report['building'] = '';
    $assmt_roll_report['machineries'] = '';
    $assmt_roll_report['total_av'] = '';
    $assmt_roll_report['total_collectibles'] = '';
    $assmt_roll_report['Previous_av'] = '';
    // return $report;
    }
}
