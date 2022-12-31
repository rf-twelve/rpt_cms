<?php

namespace App\Http\Livewire\Traits;

use App\Models\RptAccountableForm;
use App\Models\RptPaymentRecord;

trait WithCollectionAndDeposit
{
    // Get all payment record with user and accountable form
    public function setCollectionAndDeposit($id){
        $selected = RptPaymentRecord::findOrFail($id);
        // dd($selected);
        $accountableFormData = RptAccountableForm::where('user_id', $selected->user_id)->get();
        foreach($accountableFormData as $key => $item){
            $temp = RptPaymentRecord::where('pay_date',$selected->pay_date)
                ->where('pay_teller',$selected->pay_teller)
                ->where('serial_no','>=',$item['begin_serial_from'])
                ->where('serial_no','<=',$item['begin_serial_to'])
                ->orderBy('serial_no')
                ->get();
            // dump($temp->sum('pay_amount_due'));
            // dd($item->toArray());
            if(count($temp)){
            $accountableData[$key]['form_no'] = $item['form_name'];
            $accountableData[$key]['serial_no_from'] = ($temp->first())->serial_no;
            $accountableData[$key]['serial_no_to'] = ($temp->last())->serial_no;
            $accountableData[$key]['amount'] = $temp->sum('pay_amount_due');
            }
        };
        $grandTotal = collect($accountableData)->sum('amount');
        // dd($selected);
        return [
            'selectedData' => $selected,
            'accountableFormData' => $accountableFormData,
            'accountableData' => $accountableData,
            'grandTotal' => $grandTotal,
        ];
    }
}
