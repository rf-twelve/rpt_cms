<?php

namespace App\Http\Livewire\Traits;

use App\Models\RptAccountableForm;
use App\Models\RptPaymentRecord;
use App\Models\User;

trait WithCollectionAndDeposit
{

    // Get all payment record with user and accountable form
    public function setCollectionAndDeposit($id, $from, $to){
        $record = User::with('booklets','issued_receipts')
        ->find($id) ?? [];

        if($record->has('issued_receipts')){
            $receipts = $record->issued_receipts;
            $cash = $receipts->where('date','>=',$from)
                ->where('date','<=',$to)
                ->where('pay_type', 'cash')->sum('amount');
            $checks = $receipts->where('date','>=',$from)
                    ->where('date','<=',$to)
                    ->where('pay_type', 'checks')->sum('amount');
        }
        $new_array = [];
        $temp_data = [];
        foreach ($record->booklets->sortBy('begin_serial_fr') as $key => $value) {
            $temp_data = $record->issued_receipts->where('trn','>=',$value['begin_serial_fr'])
                    ->where('trn','<=',$value['begin_serial_to'])
                    ->where('date','>=',$from)
                    ->where('date','<=',$to);

            if(count($temp_data)){
                $new_array[$key]['from'] = $temp_data->first()->trn;
                $new_array[$key]['to'] = $temp_data->last()->trn;
                $new_array[$key]['amount'] = $temp_data->sum('amount');
            }
        }
        return [
            'new_array' => $new_array,
            'cash' => $cash,
            'checks' => $checks
        ];
    }
}
