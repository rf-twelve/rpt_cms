<?php

namespace App\Http\Livewire\RealPropertyTax\Collection\Components;

use Livewire\Component;

class Taxdue1 extends Component
{
    public $pay_option;
    public $payment_dues;
    public $amount_due;
    public $paymentDues = [];
    public $payment_button = "disabled";

    private function newAvComputation()
    {
        // dd(ceil(2/3));
        $unpaidComputation = [];
        $num = 0;
        $unpaidArray = $this->UnpaidAmount;
        // Check if it has quarter
        if ($this->lastPaymentQuarter > 0 && $this->lastPaymentQuarter < 1) {
            $this->penaltyComputationHasQuarter($unpaidArray,$num,$unpaidComputation);//AV, Numbering, Empty Array
        }else{
            $unpaidArray = $this->UnpaidAmount;
            $nextPayYear = $this->nextPaymentYear;
            $nextPayQuarter = $this->nextPaymentQuarter;
            $count = 0;
            $this->newAvLoop($nextPayYear,$count);
        }
        // dd($data,$num,$unpaidComputation,$result);
        $collectedData = collect($data['qd']['quarter_selected']);
        $dataValue = $collectedData->where('year_from','==',$this->nextPaymentYear)->where('year_to','==',$this->nextPaymentYear);
        $this->newAvLoop($ds);
        $nextPaymentYear = $this->nextPaymentYear + 1;

        return ['unpaid'=>$unpaidComputation,'year'=>$nextPaymentYear,'num'=>$num];
    }

    public function render()
    {
        return view('livewire.real-property-tax.collection.components.taxdue1',[
            'payment_dues' => !is_null($this->paymentDues) || !empty($this->paymentDues) ? $this->paymentDues : [],
        ]);
    }
}
