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
    public $date_from;
    public $date_to;
    public $signatory1;
    public $designation1;
    public $data = [];
    public $total = [];

    protected $rules = [
        'signatory1' => 'required',
        'designation1' => 'required',
    ];

    public function mount(){
        $this->date_from = date('Y-m-d');
        $this->date_to = date('Y-m-d');
        $this->signatory1 = 'LUCILA N. VILLASEÑOR';
        $this->designation1 = 'Administrative Aide II';
        $this->data = $this->generateCollectibles(date('Y',strtotime($this->date_from)),date('Y',strtotime($this->date_to)));
    }

    public function updatedDateFrom()
    {
        $this->data = [];
        $this->data = $this->generateCollectibles(date('Y',strtotime($this->date_from)),date('Y',strtotime($this->date_to)));
    }

    public function updatedDateTo()
    {
        $this->data = [];
        $this->data = $this->generateCollectibles(date('Y',strtotime($this->date_from)),date('Y',strtotime($this->date_to)));

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
