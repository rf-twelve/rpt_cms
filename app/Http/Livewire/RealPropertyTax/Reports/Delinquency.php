<?php

namespace App\Http\Livewire\RealPropertyTax\Reports;

use App\Http\Livewire\Traits\WithAssessedValue;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\RptAccount;
use App\Models\RptAssessedValue;
use App\Models\RptPercentage;

class Delinquency extends Component
{
    use WithAssessedValue;
    public $yearNow;
    public $start_year;
    public $end_year;
    public $signatory;
    public $designation;
    public $data = [];

    public function mount(){
        $this->yearNow = date('Y');
        $this->start_year = $this->yearNow;
        $this->end_year = $this->yearNow;
        // $this->as_of = date('m/d/Y',strtotime(Carbon::now()));
        $this->signatory = 'HERMES A. ARGANTE';
        $this->designation = 'Municipal Treasurer';
        $this->data = $this->generateDelinquencies($this->start_year, $this->end_year);
        // dd($this->data);
    }

    public function updatedStartYear(){
        $this->validate(
            ['start_year' =>'required|numeric|lte:end_year|gte:1957'],
            [
                'start_year.lte' => 'Must Not be greater than year '.$this->end_year.'.',
                'start_year.gte' => 'Must Not be less than year 1957',
            ],
        );
        $this->data = $this->generateDelinquencies($this->start_year, $this->end_year);
    }
    public function updatedEndYear(){
        $this->validate(
            ['end_year' =>'required|numeric|gte:start_year'],
            [
                'end_year.gte' => 'Must Not be less than year '.$this->start_year.'.',
            ],
        );
        $this->data = $this->generateDelinquencies($this->start_year, $this->end_year);
    }

    public function print()
    {
        $dataArray = array(

            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
            'signatory1' => $this->signatory,
            'designation1' => $this->designation,
            'form' => 'delinquency_report',
            'data' => 'data',
        );

        $query = http_build_query(array('aParam' => $dataArray));

        return redirect()->route('PDF', $query);
    }

    public function render()
    {

        return view('livewire.real-property-tax.reports.delinquency', [
            'delinquencies' => $this->data['delinquencies'],
            'grandTotal'  => $this->data['total'],
        ]);
    }


}
