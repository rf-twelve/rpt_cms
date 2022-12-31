<?php

namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\RptAccount;

class Preview extends Component
{
    public $yearNow;
    public $from;
    public $to;
    public $signatory;
    public $designation;
    public $data = [];
    public $delinquentData;
    public $delinquentDataTotal;

    public function mount(){
        $this->yearNow = date('Y');
        $this->from = $this->yearNow;
        $this->to = $this->yearNow;
        $this->as_of = date('m/d/Y',strtotime(Carbon::now()));
        $this->signatory = 'HERMES A. ARGANTE';
        $this->designation = 'Municipal Treasurer';
        $this->generateData();
    }

    public function updatedFrom(){
        $this->validate(
            ['from' =>'required|numeric|lte:to|gte:1957'],
            [
                'from.lte' => 'Must Not be greater than year '.$this->to.'.',
                'from.gte' => 'Must Not be less than year 1957',
            ],
        );
        $this->generateData();
    }

    public function updatedTo(){
        $this->validate(
            ['to' =>'required|numeric|gte:from|lte:yearNow'],
            [
                'to.lte' => 'Must Not be greater than year '.$this->yearNow.'.',
                'to.gte' => 'Must Not be less than year '.$this->from.'.',
            ],
        );
        $this->generateData();
    }

    public function getAndSubmit(){
        // $this->data = [
        //     'from' => $this->from,
        //     'to' => $this->to,
        //     'asOf' => $this->asOf,
        //     'signatory' => $this->signatory,
        //     'designation' => $this->designation,
        // ];

        dd('a');

        return response()->streamDownload(function () {
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML('<h1>Test</h1>');
            echo $pdf->stream();
        }, 'test.pdf');
    }

    public function generateData(){
        $year = ['start'=>$this->from, 'end'=>$this->to,];
        $month = 12;
        $this->delinquent_month_year = ['month'=>$month,'year'=>$year];
        $data = RptAccount::compute_tax_due($this->delinquent_month_year);
        // dd($data);
        $delinquent_per_brgy = [];
        $count = 0;
        $collected = collect($data['taxdue'])->groupBy('brgy')->sortBy('brgy');
        foreach ($collected as $key => $value) {
            $delinquent_per_brgy[$count]['brgy'] = $key;
            $delinquent_per_brgy[$count]['av'] = $value->sum('totalWithYearCount_av');
            $delinquent_per_brgy[$count]['td_basic'] = $value->sum('totalWithYearCount_basic');
            $delinquent_per_brgy[$count]['td_sef'] = $value->sum('totalWithYearCount_sef');
            $delinquent_per_brgy[$count]['penalty_basic'] = $value->sum('totalWithYearCount_penalty');
            $delinquent_per_brgy[$count]['total'] = $value->sum('totalDelinquency');
            $count++;
        }
        $newCollected = collect($delinquent_per_brgy)->sortBy('brgy');
        $this->delinquentData = $newCollected;
        $this->delinquentDataTotal = $data['total_taxdue'];
    }

    public function render()
    {

        return view('livewire.reports.preview', [
            'rptAccounts' => $this->delinquentData,
            'grandTotal'  => $this->delinquentDataTotal,
        ]);
    }


}
