<?php

namespace App\Http\Livewire\Traits;

use App\Models\RptPercentage;

trait WithPercentage
{
    ## SELECT MONTH AS INPUT
    public function getPenaltyPercentage($month)
    {
        $percentage = RptPercentage::select($month,'from','to','desc')->get();
        $newav = $percentage->where('desc','newav')->first();
        $oldav = $percentage->where('desc','oldav')->first();
    //    dd($newav);
        ## INITIALIZE PENALTY TABLE
        return [
            'percentage' => $percentage,
            'avYearNew' => $newav->from,
            'baseAvNew' => $newav->$month,
            'avYearOld' => $oldav->from,
            'baseAvOld' => $oldav->$month,
        ];
    }
}
