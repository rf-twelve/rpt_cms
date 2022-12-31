<?php

namespace App\Http\Livewire\Reports\Export;

use App\Models\RptAccount;
use Carbon\Carbon;
use Livewire\Component;
use Barryvdh\DomPDF\Facade as PDF;
// use PDF;

class SummaryOfRptDelinquenciesPerBrgy extends Component
{
    // use PDF;
    public $from;
    public $to;
    public $as_of;
    public $signatory;
    public $designation;
    public $data = [];

    public function mount(){
        $this->from = date('Y');
        $this->to = date('Y');
        $this->as_of = date('M d, Y',strtotime(Carbon::now()));
        $this->signatory = 'HERMES A. ARGANTE';
        $this->designation = 'Municipal Treasurer';
    }

    public function print(){
        $year = date('Y',strtotime($this->as_of));
        $month = date('m',strtotime($this->as_of));
        $this->delinquent_month_year = ['month'=>$month,'year'=>$year];
        $data = RptAccount::compute_tax_due($this->delinquent_month_year);
        // dd($taxDute);
        $delinquent_per_brgy = [];
        $count = 0;
        $collected = collect($data['taxdue'])->groupBy('brgy')->sortBy('brgy');
        foreach ($collected as $key => $value) {
            $delinquent_per_brgy[$count]['brgy'] = $key;
            $delinquent_per_brgy[$count]['av'] = $value->sum('av');
            $delinquent_per_brgy[$count]['td_basic'] = $value->sum('td_basic');
            $delinquent_per_brgy[$count]['td_sef'] = $value->sum('td_sef');
            $delinquent_per_brgy[$count]['penalty_basic'] = $value->sum('penalty_basic');
            $delinquent_per_brgy[$count]['total'] = $value->sum('td_total') + $value->sum('penalty_total');
            $count++;
        }

        $newCollected = collect($delinquent_per_brgy)->sortBy('brgy');
        $viewData = [
            'from'=>$this->from,
            'to'=>$this->to,
            'as_of'=>$this->as_of,
            'signatory'=>$this->signatory,
            'designation'=>$this->designation,
            'rptAccounts' => $newCollected,
            'grandTotal' => $data['total_taxdue'],
        ];

       $pdfContent = PDF::loadView('livewire.reports.export.summary-of-rpt-delinquencies-per-brgy', $viewData);
        return $pdfContent->stream();
                // return response()->streamDownload(
                //     fn () => print($pdfContent),
                //     "filename.pdf"
                // );

            //    return PDF::loadHTML($pdfContent)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf');


        // $pdf = PDF::loadView('livewire.reports.export.summary-of-rpt-delinquencies-per-brgy', $data);
        // return $pdf->download('demo.pdf');
    }


    public function render()
    {
        $year = date('Y',strtotime($this->as_of));
        $month = date('m',strtotime($this->as_of));
        $this->delinquent_month_year = ['month'=>$month,'year'=>$year];
        $data = RptAccount::compute_tax_due($this->delinquent_month_year);
        // dd($taxDute);
        $delinquent_per_brgy = [];
        $count = 0;
        $collected = collect($data['taxdue'])->groupBy('brgy')->sortBy('brgy');
        foreach ($collected as $key => $value) {
            $delinquent_per_brgy[$count]['brgy'] = $key;
            $delinquent_per_brgy[$count]['av'] = $value->sum('av');
            $delinquent_per_brgy[$count]['td_basic'] = $value->sum('td_basic');
            $delinquent_per_brgy[$count]['td_sef'] = $value->sum('td_sef');
            $delinquent_per_brgy[$count]['penalty_basic'] = $value->sum('penalty_basic');
            $delinquent_per_brgy[$count]['total'] = $value->sum('td_total') + $value->sum('penalty_total');
            $count++;
        }

        $newCollected = collect($delinquent_per_brgy)->sortBy('brgy');


        return view('livewire.reports.export.summary-of-rpt-delinquencies-per-brgy',[
            'rptAccounts' => $newCollected,
            'grandTotal' => $data['total_taxdue'],
        ]);
    }
}
