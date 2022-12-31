<?php

namespace App\Http\Livewire\Traits;

use App\Models\RptPaymentRecord;

trait WithPaymentRecord
{
    use WithAccountableForm;
    // Get all payment record with user and accountable form
    public function selectedPaymentRecord($pay_teller, $pay_date){
        $getData =  RptPaymentRecord::query()
            ->where('pay_teller',$pay_teller)
            ->where('pay_date',$pay_date)
            ->get()->toArray();
        $dataArray = [];
        foreach($getData as $item){
            $dataArray['form_no'] = $getData;
            $dataArray['serial_from'] = $getData;
            $dataArray['serial_to'] = $getData;
            $dataArray['amount'] = $getData;
        };
    }

    public function getAllPaymentRecord(){
        return RptPaymentRecord::query()
            ->orderBy('created_at','desc')
            ->get()->toArray();

    }

}
