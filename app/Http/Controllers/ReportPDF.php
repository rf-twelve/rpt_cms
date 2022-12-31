<?php

namespace App\Http\Controllers;

use App\Http\Livewire\Traits\WithAssessedValue;
use App\Http\Livewire\Traits\WithCollectionAndDeposit;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportPDF extends Controller
{
    use WithAssessedValue, WithCollectionAndDeposit;

    public function pdf($request)
    {
        parse_str($request, $output);

        $dataArray = $output['aParam'];

        dd($dataArray);
        // For File name
        $today = date("Y-m-d");

        $dataArray['pdf'] = strtoupper($dataArray['form']).'_'.$today;

        $temp = $this->getRecord($dataArray);

        $data = collect($temp)->merge($dataArray)->toArray();

        // dd($data);

        // $pdf = Pdf::loadView('pdf.'.'sample_table', $data);
        $pdf = Pdf::loadView('pdf.'.$dataArray['form'], $data);

        return $pdf->download($dataArray['pdf'].'.pdf');
    }

    public function getRecord($data)
    {
        switch ($data['form']) {
            case 'assessment_roll_report':
                return $this->generateAssessmentRoll($data['date']);;
                break;

            case 'collectible_report':
                return $this->generateCollectibles($data['date']);;
                break;

            case 'delinquency_report':
                return $this->generateDelinquencies($data['start_year'], $data['end_year']);
                break;

            case 'collection_deposit_report':
                return $this->setCollectionAndDeposit($data['pr_id']);
                break;

            default:
                # code...
                break;
        }

        // if (!empty($data['relation_table'])) {
        //     return collect(DB::table($data['model'])
        //         ->join($data['relation_table'], $data['model'].'id', '=', $data['relation_id'])
        //         ->with('relation_table')->find($data['id']))->toArray();
        // } else {
        //     return collect(DB::table($data['model'])->find($data['id']))->toArray();
        // }

    }

}
