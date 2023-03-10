<?php

namespace App\Http\Livewire\RealPropertyTax\Collection\Forms;

use App\Models\RptIssuedReceipt;
use App\Models\RptIssuedReceiptData;
use Livewire\Component;

class Receipt extends Component
{
    public $receipt;
    public $array_gap;
    public $array_size;
    public $initial_top;
    public $initial_sef;
    public $initial_total;
    public $is_background;

    public function mount($trn){
        // $this->receipt = RptIssuedReceiptData::all();
        $this->receipt = RptIssuedReceipt::with('receipt_datas')->where('trn',$trn)->first();
        $this->initial_top = 323;
        $this->initial_sef = 0;
        $this->initial_total = 0;
        $this->array_gap = 25;
        $this->array_size = 1370;
        $this->is_background = false;
    }

    public function minusSize()
    {
        $this->array_size = $this->array_size - 10;
    }
    public function addSize()
    {
        $this->array_size = $this->array_size + 10;
    }
    public function minusGap()
    {
        $this->array_gap--;
    }
    public function addGap()
    {
        $this->array_gap++;
    }

    public function verifyRecord(){
        if($this->receipt == null){
            return dd('Record not found!');
        }
    }

    public function render()
    {
        $this->verifyRecord();
        // dump($this->computations);
        // dd($this->receipt);
        return view('livewire.real-property-tax.collection.forms.receipt')
            ->layout('layouts.base-receipt');;
    }
}
