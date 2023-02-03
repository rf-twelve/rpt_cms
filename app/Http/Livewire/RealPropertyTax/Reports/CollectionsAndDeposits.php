<?php

namespace App\Http\Livewire\RealPropertyTax\Reports;

use App\Http\Livewire\Traits\WithAssessedValue;
use App\Http\Livewire\Traits\WithBarangay;
use Livewire\Component;
use App\Models\User;

class CollectionsAndDeposits extends Component
{
    use WithAssessedValue, WithBarangay;
    public $date_from, $date_to, $officer_name, $cashier_name, $cash = 0, $checks = 0;

    public $list_officer = [];
    public $find_record = [];
    public $collections = [];
    public $total = [];

    protected $rules = [
        'date_from' => 'required',
        'date_to' => 'required',
        'officer_name' => 'required',
        'cashier_name' => 'required',
    ];

    public function mount(){
        $this->date_from = date('Y-m-d');
        $this->date_to = date('Y-m-d');
        $this->list_officer = User::get();

    }

    public function UpdatedDateFrom(){
        $this->UpdatedOfficerName();
    }

    public function UpdatedDateTo(){
        $this->UpdatedOfficerName();
    }

    public function UpdatedOfficerName(){
        if(!is_null($this->officer_name) || !empty($this->officer_name) )
        {
            $record = User::with('booklets','issued_receipts')
                ->find($this->officer_name) ?? [];
            if($record->has('issued_receipts')){
                $this->findCashOrCheck($record->issued_receipts);
            }
            $new_array = [];
            $temp_data = [];
            foreach ($record->booklets->sortBy('begin_serial_fr') as $key => $value) {
                $temp_data = $record->issued_receipts->where('trn','>=',$value['begin_serial_fr'])
                        ->where('trn','<=',$value['begin_serial_to'])
                        ->where('date','>=',$this->date_from)
                        ->where('date','<=',$this->date_to);

                if(count($temp_data)){
                    // $new_array[$key]['from'] = $temp_data->first()->trn;
                    $new_array[$key]['from'] = $temp_data->first()->trn;
                    $new_array[$key]['to'] = $temp_data->last()->trn;
                    $new_array[$key]['amount'] = $temp_data->sum('amount');
                }

            }
            $this->find_record = $record->toArray();
            $this->collections = $new_array;
        }
    }

    public function computeCollections()
    {
        # code...
    }

    public function findCashOrCheck($receipts){
        $this->cash = $receipts->where('date','>=',$this->date_from)
                ->where('date','<=',$this->date_to)
                ->where('pay_type', 'cash')->sum('amount');
        $this->checks = $receipts->where('date','>=',$this->date_from)
                ->where('date','<=',$this->date_to)
                ->where('pay_type', 'checks')->sum('amount');
    }

    public function print()
    {
        $check = $this->validate();
        if($check){
            $dataArray = array(
                'from' => $this->date_from,
                'to' => $this->date_to,
                'officer' => $this->officer_name,
                'cashier' => $this->cashier_name,
                'form' => 'collection_deposit_report',
            );

            $query = http_build_query(array('aParam' => $dataArray));

            return redirect()->route('PDF', $query);
        }

    }

    public function render()
    {
        return view('livewire.real-property-tax.reports.collections-and-deposits', [
            'officer_data' => $this->find_record ?? [],
        ]);
    }


}
