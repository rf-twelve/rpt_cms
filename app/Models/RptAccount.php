<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class RptAccount extends Model
{
    use HasFactory;
    // public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['id' => 'integer'];

    public function assessed_values(){return $this->hasMany(RptAssessedValue::class);}

    public function payment_records(){return $this->hasMany(RptPaymentRecord::class);}

    public function getTellerNameAttribute(){
        return (User::find($this->pay_teller))->firstname ?? $this->pay_teller;
    }

    public function rpt_accounts_with_assessed_values_and_payment_records()
    {
        RptAccount::with('assessed_values','payment_records')->where('rtdp_status','verified')->get();
        return $this->hasMany(RptPaymentRecord::class);
    }


    public static function total_assessed_value_per_barangays()
    {
        $dataArray = [];
        $count = 0;
        $someData =  RptAccount::with('assessed_values')
            ->where('rtdp_status','verified')->get();
        $brgyList =  ListBarangay::select('index','name')->get();

        foreach ($someData as $key => $value) {
            $dataArray[$count]['brgy'] = ($brgyList->where('index',$value->lp_brgy)->first())->name;
            $dataArray[$count]['total_av'] = $value->assessed_values->sum('av_value');
            $count++;
        }
        return $dataArray;
    }



    public static function findRPTAccount($id)
    {
        $records = DB::find($id)->get();
        return $records;
    }

    // RPT Collectible per barangay
    public static function collectible_per_brgy($year){
        // Initialize Year
        $year_newAV = $year;
        $year_oldAV = $year_newAV - 1;
        $year_last = $year_newAV - 4;

        // Get RPT Account Assess value
        $rpt_account_with_av = RptAccount::with('assessed_values')
        ->where('rtdp_status','verified')->get();
        $brgyList = ListBarangay::select('index','name')->get();
        // $account_groupBy_brgy = $rpt_account_with_av->groupBy('lp_brgy');
        $assessedValueArray = [];
        $brgyCount = 0;
        $avCount = 0;
        foreach ($rpt_account_with_av as $key => $account) {
            $brgy = ($brgyList->where('index',$account->lp_brgy)->first())->name;
            if (count($account->relation))
            {
                $newAV = $account->assessed_values->where('av_year_from','<=',$year_newAV)->where('av_year_to','>=',$year_newAV)->sum('av_value');
                $oldAV = $account->assessed_values->where('av_year_from','<=',$year_oldAV)->where('av_year_to','>=',$year_oldAV)->sum('av_value');
            }
            $oldAV1percent = $oldAV*0.01;
            $newAV70percent = $newAV - $oldAV;
            $assessedValueArray[$brgyCount]['code'] = $account->lp_brgy;
            $assessedValueArray[$brgyCount]['brgy'] = $brgy;
            $assessedValueArray[$brgyCount]['new_av'] = $newAV;
            $assessedValueArray[$brgyCount]['old_av'] = $oldAV;
            $assessedValueArray[$brgyCount]['old_av_1'] = $oldAV1percent;
            $assessedValueArray[$brgyCount]['new_av_70'] = $newAV70percent;
            $brgyCount++;
        }

        $dataGroupArray = [];
        $num = 0;
        $account_groupby_brgy = collect($assessedValueArray)->groupBy('brgy');
        foreach ($account_groupby_brgy as $key => $brgy) {
            // $any = $brgy->sum['new_av'];
            $dataGroupArray[$num]['code'] = ($brgy->first())['code'];
            $dataGroupArray[$num]['brgy'] = $key;
            $dataGroupArray[$num]['new_av'] = $brgy->sum('new_av');
            $dataGroupArray[$num]['old_av'] = $brgy->sum('old_av');
            $dataGroupArray[$num]['old_av_1'] = $brgy->sum('old_av_1');
            $dataGroupArray[$num]['new_av_70'] = $brgy->sum('new_av_70');
            $dataGroupArray[$num]['total'] = $brgy->sum('old_av_1') + $brgy->sum('new_av_70');
            // dd($dataGroupArray);
            $num++;
        }
        $collected = collect($dataGroupArray);

        $grandTotalArray = [];
        $grandTotalArray['grandTotal_new_av'] = $collected->sum('new_av');
        $grandTotalArray['grandTotal_old_av'] =$collected->sum('old_av');
        $grandTotalArray['grandTotal_old_av_1'] =$collected->sum('old_av_1');
        $grandTotalArray['grandTotal_new_av_70'] =$collected->sum('new_av_70');
        $grandTotalArray['grandTotal_total'] =$collected->sum('old_av_1') + $collected->sum('new_av_70');

        return [
           'total' => $dataGroupArray,
           'grandtotal' => $grandTotalArray
        ];
        // dd($dataGroupArray);
    }

    // Delinquency Report
    public static function compute_tax_due($delinquent_month_year)
    {
        // Initialize Year & Month Input
        $month_first = $delinquent_month_year['month'];
        $year_newAV = $delinquent_month_year['year']['end'];
        $year_oldAV = $delinquent_month_year['year']['end'] - 1;
        $year_last = $year_newAV - 4;
        $year_end = $delinquent_month_year['year']['start'];

        // Setting Up Penanties
        $penaltyArray = [];
        $penalty_count = 0;
        $temp_year = $year_newAV;
        $penalty = RptPercentage::select('from','to','base')->orderByDesc('from')->get();
        // dd($penalty->toArray());
        foreach ($penalty as $key => $value) {
            $temp_value = 0;
            if ($value->base >= 72 && $value->from <= $year_last && $value->to >= $year_last) {
                $penaltyArray[$penalty_count]['type'] = 'regular';
                $penaltyArray[$penalty_count]['base'] = $value->base;
                $penaltyArray[$penalty_count]['year'] = $temp_year;
                $penaltyArray[$penalty_count]['value'] = ($value->base)/100;
            } elseif($value->base == 10) {
                $penaltyArray[$penalty_count]['type'] = 'new_av';
                $penaltyArray[$penalty_count]['base'] = $value->base;
                $penaltyArray[$penalty_count]['year'] = $temp_year;
                $penaltyArray[$penalty_count]['value'] = (2 + (($month_first*2)-2))/100;
            } elseif($value->base == 2) {
                $penaltyArray[$penalty_count]['type'] = 'old_av';
                $penaltyArray[$penalty_count]['base'] = $value->base;
                $penaltyArray[$penalty_count]['year'] = $temp_year;
                $penaltyArray[$penalty_count]['value'] = ($value->base + (($month_first*2)-2))/100;
            } else {
                $check_value = ($value->base + (($month_first*2)-2))/100;
                $penaltyArray[$penalty_count]['type'] = 'regular';
                $penaltyArray[$penalty_count]['base'] = $value->base;
                $penaltyArray[$penalty_count]['year'] = $temp_year;
                $penaltyArray[$penalty_count]['value'] = $check_value > 0.72 ? 0.72 : $check_value;
            }
            $temp_year--;
            $penalty_count++;
        }
        // dd($penaltyArray);
        $collected_penalty_array = collect($penaltyArray);
        // Initialize rpt account && list of barangay
            $getAccount =  RptAccount::with('assessed_values')
            ->where('rtdp_status','verified')->get();
            $brgyList =  ListBarangay::select('index','name')->get();

        // dd($getAccount);
        //Setting up Tax Due
        $taxDueArray = [];
        $totalTaxDueArray = [];
        $taxDueCount = 0;
        $avCount = 0;

        // dd($getAccount);
        foreach ($getAccount as $key => $account) {
            // dump($account);
            // if ($account->assessed_values()->exists()){
            $newAv = ($account->assessed_values->where('av_year_from','==',$year_newAV)->where('av_year_from','==',$year_newAV)->first())->av_value;
            $oldAv = ($account->assessed_values->where('av_year_from','==',$year_oldAV)->where('av_year_from','==',$year_oldAV)->first())->av_value;
            // Get year End
            $year_selected = ($account->assessed_values->where('av_year_from','<=',$year_end)->where('av_year_to','>=',$year_end)->first())->av_year_from;
            // Get sellected year
            $getSelectedYear = $account->assessed_values->where('av_year_from','>=',$year_selected)->sortBy('av_year_from')->toArray();
            // Get first key
            $getFirstKey = array_key_first($getSelectedYear);
            Arr::set($getSelectedYear, $getFirstKey.'.av_year_from', $year_end);
            // }
            // dd($getSelectedYear);
            foreach ($getSelectedYear as $key => $av) {
                dump($av);
                if ($av['av_year_from'] <= $year_last) {
                    $penalty_value = ($collected_penalty_array->last())['value'];
                    // dump('PENALTY :'.$av->av_year_from.'-'.$av->av_year_to.' : '.$penalty_value);
                } else {
                    // dump($av->av_year_from.'-'.$av->av_year_to);
                    $check_value = ($collected_penalty_array
                    ->where('year','>=',$av['av_year_from'])->where('year','<=',$av['av_year_to'])->first());
                    if (is_null($check_value) || empty($check_value)) {
                        $penalty_value = null;
                    } else {
                        $penalty_value = $check_value['value'];
                    }
                }
                dump($av['av_year_from']);

                // Add 35% and 70% if old av has value
                if ($av['av_year_from'] == $year_oldAV && $av['av_year_to'] == $year_oldAV) {
                    dump('saved');


                    $penalty_35 = ($collected_penalty_array->where('year','==',$year_oldAV-1)->first())['value'];
                    $penalty_70 = ($collected_penalty_array->where('year','==',$year_oldAV)->first())['value'];

                    // 35% increase
                    $taxDueArray[$avCount]['pin'] = $account->rpt_pin;
                    $taxDueArray[$avCount]['brgy'] = ($brgyList->where('index',$account->lp_brgy)->first())->name;
                    $taxDueArray[$avCount]['label'] = '35% Increase';
                    $taxDueArray[$avCount]['from'] = $av['av_year_from'];
                    $taxDueArray[$avCount]['to'] = $av['av_year_to'];
                    $taxDueArray[$avCount]['year_count'] = ($av['av_year_to'] - $av['av_year_from']) + 1;
                    $taxDueArray[$avCount]['tempav'] = $newAv - $oldAv;
                    $taxDueArray[$avCount]['av'] = 0;
                    $taxDueArray[$avCount]['td_basic'] = ((($newAv - $oldAv)*0.01)*0.35);
                    $taxDueArray[$avCount]['td_sef'] = $taxDueArray[$avCount]['td_basic'];
                    $taxDueArray[$avCount]['td_total'] =  $taxDueArray[$avCount]['td_sef'] + $taxDueArray[$avCount]['td_basic'];
                    $taxDueArray[$avCount]['penalty_basic'] = $taxDueArray[$avCount]['td_basic'] * $penalty_35;
                    $taxDueArray[$avCount]['penalty_sef'] = $taxDueArray[$avCount]['penalty_basic'];
                    $taxDueArray[$avCount]['penalty_total'] = $taxDueArray[$avCount]['penalty_sef'] + $taxDueArray[$avCount]['penalty_basic'];
                    $taxDueArray[$avCount]['totalWithYearCount_av'] = $taxDueArray[$avCount]['av'] * $taxDueArray[$avCount]['year_count'];
                    $taxDueArray[$avCount]['totalWithYearCount_basic'] = ($taxDueArray[$avCount]['td_basic'] * $taxDueArray[$avCount]['year_count']);
                    $taxDueArray[$avCount]['totalWithYearCount_sef'] = ($taxDueArray[$avCount]['td_sef'] * $taxDueArray[$avCount]['year_count']);
                    $taxDueArray[$avCount]['totalWithYearCount_td'] = ($taxDueArray[$avCount]['td_total'] * $taxDueArray[$avCount]['year_count']);
                    $taxDueArray[$avCount]['totalWithYearCount_penalty'] = $taxDueArray[$avCount]['penalty_basic'] * $taxDueArray[$avCount]['year_count'];
                    $taxDueArray[$avCount]['totalDelinquency'] = (($taxDueArray[$avCount]['totalWithYearCount_basic'])*2 + ($taxDueArray[$avCount]['totalWithYearCount_penalty'])*2);
                    $avCount++;
                    // 70% increase
                    $taxDueArray[$avCount]['pin'] = $account->rpt_pin;
                    $taxDueArray[$avCount]['brgy'] = ($brgyList->where('index',$account->lp_brgy)->first())->name;
                    $taxDueArray[$avCount]['label'] = '70% Increase';
                    $taxDueArray[$avCount]['from'] = $av['av_year_from'];
                    $taxDueArray[$avCount]['to'] = $av['av_year_to'];
                    $taxDueArray[$avCount]['year_count'] = ($av['av_year_to'] - $av['av_year_from']) + 1;
                    $taxDueArray[$avCount]['tempav'] = $newAv - $oldAv;
                    $taxDueArray[$avCount]['av'] = 0;
                    $taxDueArray[$avCount]['td_basic'] = ((($newAv - $oldAv)*0.01)*0.70);
                    $taxDueArray[$avCount]['td_sef'] = $taxDueArray[$avCount]['td_basic'];
                    $taxDueArray[$avCount]['td_total'] =  $taxDueArray[$avCount]['td_sef'] + $taxDueArray[$avCount]['td_basic'];
                    $taxDueArray[$avCount]['penalty_basic'] = $taxDueArray[$avCount]['td_basic'] * $penalty_70;
                    $taxDueArray[$avCount]['penalty_sef'] = $taxDueArray[$avCount]['penalty_basic'];
                    $taxDueArray[$avCount]['penalty_total'] = $taxDueArray[$avCount]['penalty_sef'] + $taxDueArray[$avCount]['penalty_basic'];
                    $taxDueArray[$avCount]['totalWithYearCount_av'] = $taxDueArray[$avCount]['av'] * $taxDueArray[$avCount]['year_count'];
                    $taxDueArray[$avCount]['totalWithYearCount_basic'] = ($taxDueArray[$avCount]['td_basic'] * $taxDueArray[$avCount]['year_count']);
                    $taxDueArray[$avCount]['totalWithYearCount_sef'] = ($taxDueArray[$avCount]['td_sef'] * $taxDueArray[$avCount]['year_count']);
                    $taxDueArray[$avCount]['totalWithYearCount_td'] = ($taxDueArray[$avCount]['td_total'] * $taxDueArray[$avCount]['year_count']);
                    $taxDueArray[$avCount]['totalWithYearCount_penalty'] = $taxDueArray[$avCount]['penalty_basic'] * $taxDueArray[$avCount]['year_count'];
                    $taxDueArray[$avCount]['totalDelinquency'] = (($taxDueArray[$avCount]['totalWithYearCount_basic'])*2 + ($taxDueArray[$avCount]['totalWithYearCount_penalty'])*2);

                    $avCount++;
                    # code...
                }

                if ($av['av_year_from'] <= $year_oldAV && $av['av_year_to'] <= $year_oldAV) {
                    $taxDueArray[$avCount]['pin'] = $account->rpt_pin;
                    $taxDueArray[$avCount]['brgy'] = ($brgyList->where('index',$account->lp_brgy)->first())->name;
                    $taxDueArray[$avCount]['label'] = $av['av_year_from'].'-'.$av['av_year_to'];
                    $taxDueArray[$avCount]['from'] = $av['av_year_from'];
                    $taxDueArray[$avCount]['to'] = $av['av_year_to'];
                    $taxDueArray[$avCount]['year_count'] = ($av['av_year_to'] - $av['av_year_from']) + 1;
                    $taxDueArray[$avCount]['av'] = $av['av_value'];
                    $taxDueArray[$avCount]['td_basic'] = ($taxDueArray[$avCount]['av']*0.01);
                    $taxDueArray[$avCount]['td_sef'] = $taxDueArray[$avCount]['td_basic'];
                    $taxDueArray[$avCount]['td_total'] = ($taxDueArray[$avCount]['td_sef'] + $taxDueArray[$avCount]['td_basic']);
                    $taxDueArray[$avCount]['penalty_basic'] = $taxDueArray[$avCount]['td_basic'] * $penalty_value;
                    $taxDueArray[$avCount]['penalty_sef'] = $taxDueArray[$avCount]['penalty_basic'];
                    $taxDueArray[$avCount]['penalty_total'] = ($taxDueArray[$avCount]['penalty_sef'] + $taxDueArray[$avCount]['penalty_basic']);
                    $taxDueArray[$avCount]['totalWithYearCount_av'] = $av['av_value'] * $taxDueArray[$avCount]['year_count'];
                    $taxDueArray[$avCount]['totalWithYearCount_basic'] = ($taxDueArray[$avCount]['td_basic'] * $taxDueArray[$avCount]['year_count']);
                    $taxDueArray[$avCount]['totalWithYearCount_sef'] = ($taxDueArray[$avCount]['td_sef'] * $taxDueArray[$avCount]['year_count']);
                    $taxDueArray[$avCount]['totalWithYearCount_td'] = ($taxDueArray[$avCount]['td_total'] * $taxDueArray[$avCount]['year_count']);
                    $taxDueArray[$avCount]['totalWithYearCount_penalty'] = $taxDueArray[$avCount]['penalty_basic'] * $taxDueArray[$avCount]['year_count'];
                    $taxDueArray[$avCount]['totalDelinquency'] = (($taxDueArray[$avCount]['totalWithYearCount_basic']) + ($taxDueArray[$avCount]['totalWithYearCount_penalty']))*2;
                    $avCount++;
                }
            }
        }
        $collected_taxDue = collect($taxDueArray);
        dd($collected_taxDue);
        $totalTaxDueArray['total_av'] = $collected_taxDue->sum('totalWithYearCount_av');
        $totalTaxDueArray['total_basic'] = $collected_taxDue->sum('totalWithYearCount_basic');
        $totalTaxDueArray['total_sef'] = $collected_taxDue->sum('totalWithYearCount_sef');
        $totalTaxDueArray['total_penalty'] = $collected_taxDue->sum('totalWithYearCount_penalty');
        $totalTaxDueArray['total_taxDue'] = ($collected_taxDue->sum('totalDelinquency'));

        return [
            'taxdue' => $taxDueArray,
            'total_taxdue' => $totalTaxDueArray,
        ];
    }

}
