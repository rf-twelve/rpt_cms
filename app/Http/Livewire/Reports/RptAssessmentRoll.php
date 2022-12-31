<?php

namespace App\Http\Livewire\Reports;

use App\Models\AssmtRollAccount;
use App\Models\ListBarangay;
use Livewire\Component;

class RptAssessmentRoll extends Component
{
    // public $assessmentRoll = [];
    // public $grandTotal = [];
    public function render()
    {
        $data = $this->getAssmtRollTotalValue();
        return view('livewire.reports.rpt-assessment-roll', [
        'rptAccounts' => $data['accountPerBrgy'],
        'grandTotal' =>  $data['totalValuePerBrgy'],
    ]);
    }

    public function getAssmtRollTotalValue(){
        dd('ok');
        $accounts = AssmtRollAccount::where('assmt_roll_brgy','!=',null)
        ->where('assmt_roll_brgy','!=','')->where('assmt_roll_status','verified')->get();
        $accountGroupByBrgy = $accounts->groupBy('assmt_roll_brgy');
        $brgyList =  ListBarangay::select('index','name')->get();
        // L - Land
        // B - Building
        // M - Machineries
        $accountArray = [];
        $count = 0;
        // dd($accountGroupByBrgy);
        if (count($accountGroupByBrgy) > 0) {

        foreach ($accountGroupByBrgy as $key => $value) {
            $land = $value->where('assmt_roll_kind','L')->sum('assmt_roll_av');
            $build = $value->where('assmt_roll_kind','B')->sum('assmt_roll_av');
            $machine = $value->where('assmt_roll_kind','M')->sum('assmt_roll_av');
            $av = $value->sum('assmt_roll_av');
            $collectible = $value->sum('assmt_roll_av')*0.02;
            $av_prev = $value->sum('assmt_roll_av_prev');

            $accountArray[$count]['brgy'] = ($brgyList->where('index',$key)->first())->name;
            $accountArray[$count]['code'] = $key;
            $accountArray[$count]['land'] = $land;
            $accountArray[$count]['build'] = $build;
            $accountArray[$count]['machine'] = $machine;
            $accountArray[$count]['av'] = $av;
            $accountArray[$count]['collectible'] = $collectible;
            $accountArray[$count]['av_prev'] = $av_prev;
            $count++;
        }

        $totalValueArraycollect = [];
        $totalValueArraycollect['total_land'] = collect($accountArray)->sum('land');
        $totalValueArraycollect['total_build'] = collect($accountArray)->sum('build');
        $totalValueArraycollect['total_machine'] = collect($accountArray)->sum('machine');
        $totalValueArraycollect['total_av'] = collect($accountArray)->sum('av');
        $totalValueArraycollect['total_collectible'] = collect($accountArray)->sum('collectible');
        $totalValueArraycollect['total_av_prev'] = collect($accountArray)->sum('av_prev');

        }
        // dd($totalValueArraycollect);
        return [
            'accountPerBrgy' =>$accountArray ?? null,
            'totalValuePerBrgy' =>$totalValueArraycollect ?? null,
        ];
    }
}
