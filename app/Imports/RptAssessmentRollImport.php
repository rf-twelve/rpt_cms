<?php

namespace App\Imports;

use App\Models\AssmtRollAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RptAssessmentRollImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        return
            new AssmtRollAccount([
                'assmt_roll_td_arp_no' => $row['td_arp'],
                'assmt_roll_pin' => $row['pin'],
                'assmt_roll_lot_blk_no' => $row['lot_blk_no'],
                'assmt_roll_owner' => $row['owner'],
                'assmt_roll_address' => $row['address'],
                'assmt_roll_brgy' => $row['barangay_index'],
                'assmt_roll_municity' => '16',
                'assmt_roll_province' => '015',
                'assmt_roll_kind' => $row['kind'],
                'assmt_roll_class' => $row['class'],
                'assmt_roll_av' => $row['av'],
                'assmt_roll_effective' => $row['effectivity'],
                'assmt_roll_td_arp_no_prev' => $row['td_arp_prev'],
                'assmt_roll_av_prev' => $row['av_prev'],
                'assmt_roll_remarks' => $row['remarks'],
                'assmt_roll_status' => 0,
                'import_by' =>  Auth::user()->firstname.' '.Auth::user()->lastname,
            ]);
    }
}
