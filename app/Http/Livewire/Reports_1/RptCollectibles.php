<?php

namespace App\Http\Livewire\Reports;

use App\Models\RptAccount;
use Livewire\Component;

class RptCollectibles extends Component
{
    public $yearSelected = '';
    public function mount($year){
        $this->yearSelected = $year;
    }
    public function render()
    {
        $getData = RptAccount::collectible_per_brgy($this->yearSelected);
        return view('livewire.reports.rpt-collectibles',[
            'records' => $getData['total'],
            'grandTotal' => $getData['grandtotal'],
        ]);
    }
}
