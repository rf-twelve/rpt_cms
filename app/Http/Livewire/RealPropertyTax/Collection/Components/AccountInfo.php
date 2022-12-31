<?php

namespace App\Http\Livewire\RealPropertyTax\Collection\Components;

use Livewire\Component;

class AccountInfo extends Component
{
    public $account_value;
    public $rpt_pin;
    public $rpt_td_no;
    public $rpt_kind;
    public $ro_name;
    public $ro_address;
    public $rtdp_payment_covered_year;

    public function updated($accountData){
        $this->account_value = $accountData;
        $this->rpt_pin = $accountData->rpt_pin;
        $this->rpt_td_no = $accountData->rpt_td_no;
        $this->rpt_kind = $accountData->rpt_kind;
        $this->ro_name = $accountData->ro_name;
        $this->ro_address = $accountData->ro_address;
        $this->rtdp_payment_covered_year = $accountData->rtdp_payment_covered_year;
    }

    public function render()
    {
        return view('livewire.real-property-tax.collection.components.account-info',[
            'value' => is_null( $this->account_value) ||  empty( $this->account_value) ?  $this->account_value : '',
        ]
    );
    }
}
