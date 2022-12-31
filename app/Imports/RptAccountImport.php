<?php

namespace App\Imports;

use App\Models\RptAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RptAccountImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        return
            new RptAccount([
                'rpt_pin' => $row['pin'],
                'rpt_kind' => $row['kind'],
                'rpt_class' => $row['classification'],
                'rpt_td_no' => $row['td_number'],
                'rpt_arp_no' => $row['arp_number'],
                'ro_name' => $row['owners_name'],
                'ro_address' => $row['address'],
                'ro_date_transfer' => $row['date_transfer'],
                'lp_lot_blk_no' => $row['lot_blk_no'],
                'lp_street' => $row['street'],
                'lp_brgy' => $row['barangay'],
                'lp_municity' => $row['municipality'],
                'lp_province' => $row['province'],
                'temp_1957_1966' => is_null($row['b_1957_1966']) ? 0 : $row['b_1957_1966'],
                'temp_1967_1973' => is_null($row['b_1967_1973']) ? 0 : $row['b_1967_1973'],
                'temp_1974_1979' => is_null($row['b_1974_1979']) ? 0 : $row['b_1974_1979'],
                'temp_1980_1984' => is_null($row['b_1980_1984']) ? 0 : $row['b_1980_1984'],
                'temp_1985_1993' => is_null($row['b_1985_1993']) ? 0 : $row['b_1985_1993'],
                'temp_1994_1996' => is_null($row['b_1994_1996']) ? 0 : $row['b_1994_1996'],
                'temp_1997_2002' => is_null($row['b_1997_2002']) ? 0 : $row['b_1997_2002'],
                'temp_2003_2018' => is_null($row['b_2003_2018']) ? 0 : $row['b_2003_2018'],
                'temp_2019_2019' => is_null($row['b_2019_2019']) ? 0 : $row['b_2019_2019'],
                'temp_2020_2020' => is_null($row['b_2020_2020']) ? 0 : $row['b_2020_2020'],
                'temp_2021_2021' => is_null($row['b_2021_2021']) ? 0 : $row['b_2021_2021'],
                'temp_2022_2022' => is_null($row['b_2022_2022']) ? 0 : $row['b_2022_2022'],
                'rtdp_effectivity' => $row['effectivity'],
                'rtdp_td_basic' => is_null($row['td_basic']) ? 0 : $row['td_basic'],
                'rtdp_td_sef' => is_null($row['td_sef']) ? 0 : $row['td_sef'],
                'rtdp_td_penalty' => is_null($row['td_penalty']) ? 0 : $row['td_penalty'],
                'rtdp_td_total' => is_null($row['td_total']) ? 0 : $row['td_total'],
                'rtdp_tc_basic' => is_null($row['tc_basic']) ? 0 : $row['tc_basic'],
                'rtdp_tc_sef' => is_null($row['tc_sef']) ? 0 : $row['tc_sef'],
                'rtdp_tc_penalty' => is_null($row['tc_penalty']) ? 0 : $row['tc_penalty'],
                'rtdp_tc_total' => is_null($row['tc_total']) ? 0 : $row['tc_total'],
                'rtdp_or_no' => $row['or_number'],
                'rtdp_payment_date' => $row['payment_date'],
                'rtdp_payment_covered_year' => is_null($row['payment_covered']) ? 0000 : $row['payment_covered'],
                'rtdp_payment_covered_fr' => is_null($row['payment_covered']) ? 0000 : Str::substr($row['payment_covered'], 0, 4),
                'rtdp_payment_covered_to' => is_null($row['payment_covered']) ? 0000 : Str::substr($row['payment_covered'], -4, 4),
                'rtdp_remarks' => $row['remarks'],
                'rtdp_directory' => $row['directory'],
                'rtdp_payment_start' => $row['payment_start'],
                'rtdp_status' => 'new',
                'import_by' =>  Auth::user()->firstname.' '.Auth::user()->lastname,
            ]);
    }
}
