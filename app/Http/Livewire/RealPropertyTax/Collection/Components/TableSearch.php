<?php

namespace App\Http\Livewire\RealPropertyTax\Collection\Components;

use App\Models\RptAccount;
use Livewire\Component;


class TableSearch extends Component
{
public $rptAccountSearch = [];
protected $listeners = [
'searchRecord' => 'searchRecordEvent',
];

    public function render()
    {
        return view('livewire.real-property-tax.collection.components.table-search');
    }

    public function searchRecordEvent($input, $option){
        $this->rptAccountSearch = RptAccount::select('id','rpt_pin','rpt_arp_no','rpt_td_no','ro_name','ro_address','rpt_kind','rpt_class','rtdp_payment_covered_year','rtdp_status')
            ->where($option, 'like', '%' . $input . '%')->limit(10)->get();
    }

    public function verify_record($id){
        $this->emitUp('verifyRecord',$id);
        // $this->emitTo('showInfo',$id);
    }
}
