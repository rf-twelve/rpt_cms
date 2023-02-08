<?php

namespace App\Http\Livewire\Traits;

use App\Models\ListBarangay;
use App\Models\RptAssessedValue;
use App\Models\RptPercentage;

trait WithAssessedValue
{
    use WithPenalty, WithBarangay;
    public $data = [];
    public $total = [];
    public function penaltyPercentage(){
        return
        RptPercentage::select('from','to','base','value')
        ->get()->toArray();
    }

    // Get assessed value with rpt account barangay
    public function assessedValueWithBarangay(){
        return RptAssessedValue::query()
        ->with(['rptAccount' => function ($query) {
            $query->select('id','lp_brgy','rtdp_status');
        }])
        ->select('av_year_from','av_year_to','av_value','rpt_account_id')
        ->get();
    }

    // Get assessed value with rpt account barangay
    public function assessedValueWithBarangayAndKind(){
        return RptAssessedValue::query()
        ->with(['rptAccount' => function ($query) {
            $query->select('id', 'lp_brgy','rpt_kind');
        }])
        ->select('av_year_from','av_year_to','av_value','rpt_account_id')
        ->get();
    }

    // Get assessed value group by barangay and kind
    public function assessedValueGroupByBrgy(){
        return RptAssessedValue::query()
        ->with(['rptAccount' => function ($query) {
            $query->select('id', 'lp_brgy','rpt_kind');
        }])
        ->select('av_year_from','av_year_to','av_value','rpt_account_id')
        ->get();
    }

    // Get assessed value group by barangay and kind
    public function assessedValueOnly(){
        return RptAssessedValue::query()
        ->select('av_value')->get();
    }

    public function generateAssessmentRoll($getdate){
        $newAvYear = date('Y',strtotime($getdate));
        $oldAvYear = $newAvYear - 1;
        $getData = $this->assessedValueWithBarangayAndKind();
        $newAV = $getData->where('av_year_from','<=',$newAvYear)
                ->where('av_year_to','>=',$newAvYear);
        $oldAV = $getData->where('av_year_from','<=',$oldAvYear)
                ->where('av_year_to','>=',$oldAvYear);
        $newData = [];
        foreach($newAV as $key => $value){
            $newData[$key] = collect($value)
                ->merge(['old_av' => ($oldAV->where('rpt_account_id',$value->rpt_account_id)
                ->first())->av_value])
                ->toArray();
        }
        $groupByBrgy = collect($newData)->sortBy('rpt_account.lp_brgy')->groupBy('rpt_account.lp_brgy');
        $count = 0;
        foreach($groupByBrgy as $key => $value){
            // dd($value);
            $this->data[$count]['barangay'] = (ListBarangay::where('index',$value->first()['rpt_account']['lp_brgy'])->first())->name;
            $this->data[$count]['code'] = $value->first()['rpt_account']['lp_brgy'];
            $this->data[$count]['land'] = $value->where('rpt_account.rpt_kind','L')->sum('av_value');
            $this->data[$count]['building'] = $value->where('rpt_account.rpt_kind','B')->sum('av_value');
            $this->data[$count]['machineries'] = $value->where('rpt_account.rpt_kind','M')->sum('av_value');
            $this->data[$count]['total_av'] = $value->sum('av_value');
            $this->data[$count]['total_collectibles'] = $this->data[$count]['total_av'] * 0.02;
            $this->data[$count]['total_av_prev'] = $value->sum('old_av');
            $count++;
        }
        $this->total['land'] = collect($this->data)->sum('land');
        $this->total['building'] = collect($this->data)->sum('building');
        $this->total['machineries'] = collect($this->data)->sum('machineries');
        $this->total['total_av'] = collect($this->data)->sum('total_av');
        $this->total['total_collectibles'] = collect($this->data)->sum('total_collectibles');
        $this->total['total_av_prev'] = collect($this->data)->sum('total_av_prev');
        return [
            'assessment_roll_data' => $this->data,
            'assessment_roll_total' => $this->total,
        ];
    }

    // GENERATE COLLECTIBLES REPORT
    public function generateCollectibles($from, $to){
        $newAvYear = $to;
        $oldAvYear = $newAvYear - 1;
        $getData = $this->assessedValueWithBarangay();
        dd($getData->toArray());

        $newAV = $getData->where('av_year_from','<=',$newAvYear)
                ->where('av_year_to','>=',$newAvYear);
        $oldAV = $getData->where('av_year_from','<=',$oldAvYear)
                ->where('av_year_to','>=',$oldAvYear);
        $newData = [];
        foreach($newAV as $key => $value){
            $newData[$key] = collect($value)
                ->merge(['old_av' => ($oldAV->where('rpt_account_id',$value->rpt_account_id)
                ->first())->av_value])
                ->toArray();
        }
        $groupByBrgy = collect($newData)->sortBy('rpt_account.lp_brgy')->groupBy('rpt_account.lp_brgy');
        $count = 1;
        foreach($groupByBrgy as $key => $value){
            // dd($value);
            $this->data[$count]['count'] = $count;
            $this->data[$count]['barangay'] = (ListBarangay::where('index',$value->first()['rpt_account']['lp_brgy'])->first())->name;
            $this->data[$count]['new_av'] = $value->sum('av_value');
            $this->data[$count]['old_av'] = $value->sum('old_av');
            $this->data[$count]['old_av_1'] = $value->sum('old_av') * 0.01;
            $this->data[$count]['new_av_70'] = ($this->data[$count]['new_av'] - $value->sum('old_av')) * (0.7 * 0.01);
            $this->data[$count]['total'] = $this->data[$count]['old_av_1'] + $this->data[$count]['new_av_70'];
            $count++;
        }
        $this->total['new_av'] = collect($this->data)->sum('new_av');
        $this->total['old_av'] = collect($this->data)->sum('old_av');
        $this->total['old_av_1'] = collect($this->data)->sum('old_av_1');
        $this->total['new_av_70'] = collect($this->data)->sum('new_av_70');
        $this->total['total'] = collect($this->data)->sum('total');
        return [
            'assessment_roll_data' => $this->data,
            'assessment_roll_total' => $this->total,
        ];
    }
    // // GENERATE COLLECTIBLES REPORT
    // public function generateCollectibles($getdate){
    //     $newAvYear = date('Y',strtotime($getdate));
    //     $oldAvYear = $newAvYear - 1;
    //     $getData = $this->assessedValueWithBarangay();

    //     $newAV = $getData->where('av_year_from','<=',$newAvYear)
    //             ->where('av_year_to','>=',$newAvYear);
    //     $oldAV = $getData->where('av_year_from','<=',$oldAvYear)
    //             ->where('av_year_to','>=',$oldAvYear);
    //     $newData = [];
    //     foreach($newAV as $key => $value){
    //         $newData[$key] = collect($value)
    //             ->merge(['old_av' => ($oldAV->where('rpt_account_id',$value->rpt_account_id)
    //             ->first())->av_value])
    //             ->toArray();
    //     }
    //     $groupByBrgy = collect($newData)->sortBy('rpt_account.lp_brgy')->groupBy('rpt_account.lp_brgy');
    //     $count = 1;
    //     foreach($groupByBrgy as $key => $value){
    //         // dd($value);
    //         $this->data[$count]['count'] = $count;
    //         $this->data[$count]['barangay'] = (ListBarangay::where('index',$value->first()['rpt_account']['lp_brgy'])->first())->name;
    //         $this->data[$count]['new_av'] = $value->sum('av_value');
    //         $this->data[$count]['old_av'] = $value->sum('old_av');
    //         $this->data[$count]['old_av_1'] = $value->sum('old_av') * 0.01;
    //         $this->data[$count]['new_av_70'] = ($this->data[$count]['new_av'] - $value->sum('old_av')) * (0.7 * 0.01);
    //         $this->data[$count]['total'] = $this->data[$count]['old_av_1'] + $this->data[$count]['new_av_70'];
    //         $count++;
    //     }
    //     $this->total['new_av'] = collect($this->data)->sum('new_av');
    //     $this->total['old_av'] = collect($this->data)->sum('old_av');
    //     $this->total['old_av_1'] = collect($this->data)->sum('old_av_1');
    //     $this->total['new_av_70'] = collect($this->data)->sum('new_av_70');
    //     $this->total['total'] = collect($this->data)->sum('total');
    //     return [
    //         'assessment_roll_data' => $this->data,
    //         'assessment_roll_total' => $this->total,
    //     ];
    // }

    // GENERATE DELINQUENCY REPORT
    public function generateDelinquencies($start_year, $end_year){

        $selectedAV = $this->assessedValueWithBarangay()
            ->where('av_year_to','>=',$start_year)
            ->where('av_year_to','<=',$end_year)
            ->toArray();

        // dd($selectedAV);
        // dd($this->percentageWithMaxPenalty($start_year, $end_year));
        $avWithDelinquency = [];
        foreach($selectedAV as $key => $av){
            $avWithDelinquency[$key]['account'] = $av['rpt_account_id'];
            $avWithDelinquency[$key]['brgy'] = $av['rpt_account']['lp_brgy'];
            $avWithDelinquency[$key]['year_count'] = ($av['av_year_to'] == $av['av_year_from'])
                ? 1 : $av['av_year_to'] - $start_year + 1;
            $avWithDelinquency[$key]['av'] = $av['av_value'];
            $avWithDelinquency[$key]['basic'] = $av['av_value'] * 0.01;
            $avWithDelinquency[$key]['sef'] = $avWithDelinquency[$key]['basic'];
            $avWithDelinquency[$key]['penalty']
                = ($avWithDelinquency[$key]['basic'] * $this->maxPenaltyValue($av['av_year_to']));
            $avWithDelinquency[$key]['total']
                = $avWithDelinquency[$key]['basic']
                + $avWithDelinquency[$key]['sef']
                + ($avWithDelinquency[$key]['penalty'] * 2);
            $avWithDelinquency[$key]['all_av'] = $avWithDelinquency[$key]['av'] * $avWithDelinquency[$key]['year_count'];
            $avWithDelinquency[$key]['all_basic'] = $avWithDelinquency[$key]['basic'] * $avWithDelinquency[$key]['year_count'];
            $avWithDelinquency[$key]['all_sef'] = $avWithDelinquency[$key]['sef'] * $avWithDelinquency[$key]['year_count'];
            $avWithDelinquency[$key]['all_penalty'] = $avWithDelinquency[$key]['penalty'] * $avWithDelinquency[$key]['year_count'];
            $avWithDelinquency[$key]['all_total'] = $avWithDelinquency[$key]['total'] * $avWithDelinquency[$key]['year_count'];
        }
        // dd($avWithDelinquency);

        $groupByBrgy = collect($avWithDelinquency)->sortBy('brgy')->groupBy('brgy');
        $delinquencies = [];
        foreach($groupByBrgy as $key => $av){
            $delinquencies[$key]['brgy'] = collect($this->getBarangayList()
                ->where('index',$key)->first())->get('name');
            $delinquencies[$key]['av_sum'] = $av->sum('all_av');
            $delinquencies[$key]['basic_sum'] = $av->sum('all_basic');
            $delinquencies[$key]['sef_sum'] = $av->sum('all_sef');
            $delinquencies[$key]['penalty_sum'] = $av->sum('all_penalty');
            $delinquencies[$key]['delinquency_sum'] = $av->sum('all_total');
        }
        $total['av'] = collect($delinquencies)->sum('av_sum');
        $total['basic'] = collect($delinquencies)->sum('basic_sum');
        $total['sef'] = collect($delinquencies)->sum('sef_sum');
        $total['penalty'] = collect($delinquencies)->sum('penalty_sum');
        $total['delinquency'] = collect($delinquencies)->sum('delinquency_sum');

        // dd($groupByBrgy);
        // dd($delinquencies);
        return [
            'delinquencies' => $delinquencies,
            'total' => $total,
        ];
    }


}
