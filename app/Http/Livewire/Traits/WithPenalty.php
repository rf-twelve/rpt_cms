<?php

namespace App\Http\Livewire\Traits;

use App\Models\RptPercentage;

trait WithPenalty
{
    public function percentageWithMaxPenalty($from, $to){
        $getValue = $this->getPercentage()->where('to','>=',$from)->where('to','<=',$to)->toArray();
        $dataArray = [];
        foreach($getValue as $key => $percentage){
                $sumValue = $percentage['value'] + 0.22; // (12mos. x 2) - 2
                $dataArray[$key]['from'] = $percentage['from'];
                $dataArray[$key]['to'] = $percentage['to'];
                $dataArray[$key]['year_count'] = ($percentage['to'] == $percentage['from']) ? 1:$percentage['to'] - $from + 1;
                $dataArray[$key]['max_penalty'] = ($sumValue < 0.72) ? $sumValue : 0.72;
            }
        return $dataArray;

    }
    // FIND MAXIMUM PENALTY VALUE
    public function maxPenaltyValue($year){
        // FIND THE PERCENTAGE DATA
        $getPercentage = $this->getPercentage()->where('to','>=',$year)->where('from','<=',$year)->first();
        // SUM THE VALUE WITH 12Mos x 2% - 2%(FIRST MONTH IS NOT INCLUDED) = 0.22
        $sumValue = $getPercentage['value'] + 0.22;
        // IF THE VALUE IS LESS THAN 0.72 THEN RETURN $sumValue ELSE 0.72
        return ($sumValue < 0.72) ? $sumValue : 0.72;

    }
    public function penaltyPercentage($from, $to){

        $percentageWithPanaltyMax = [];
        // foreach($this->getPercentage() as $key => $percentage){
        //     $percentageWithPanaltyMax[$key]['max_penalty'] = $percentage['value'];
        // }
        return $percentageWithPanaltyMax;

    }
    public function getPercentage(){
        return RptPercentage::select('from','to','base','value')
        ->get();
    }

}
