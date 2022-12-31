<?php

namespace App\Http\Livewire\RealPropertyTax\Reports;

use App\Http\Livewire\Traits\WithAssessedValue;
use App\Http\Livewire\Traits\WithBarangay;
use App\Models\ListBarangay;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\RptAccount;

class Collectible extends Component
{
    use WithAssessedValue, WithBarangay;
    public $as_of;
    public $get_date;
    public $signatory1;
    public $designation1;
    public $data = [];
    public $total = [];

    protected $rules = [
        'get_date' => 'required',
        'signatory1' => 'required',
        'designation1' => 'required',
    ];

    public function mount(){
        $this->get_date = date('Y-m-d',strtotime(Carbon::now()));
        $this->as_of = date('m/d/Y',strtotime($this->get_date));
        $this->signatory1 = 'LUCILA N. VILLASEÑOR';
        $this->designation1 = 'Administrative Aide II';
        $this->data = $this->generateCollectibles($this->get_date);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if($propertyName == 'get_date'){
            $this->as_of = date('m/d/Y',strtotime($this->get_date));
            $this->data = [];
            $this->data = $this->generateCollectibles($this->get_date);
            // dd($this->data);
        }
    }

    public function print()
    {
        $dataArray = array(
            // 'id' => $id,
            'date' => $this->get_date,
            'signatory1' => $this->signatory1,
            'designation1' => $this->designation1,
            'form' => 'collectible_report',
        );

        $query = http_build_query(array('aParam' => $dataArray));

        return redirect()->route('PDF', $query);
    }

    public function render()
    {

        return view('livewire.real-property-tax.reports.collectible', [
            'assessed_values' => $this->data['assessment_roll_data'],
            'grandTotal'  =>  $this->data['assessment_roll_total'],
        ]);
    }


}
