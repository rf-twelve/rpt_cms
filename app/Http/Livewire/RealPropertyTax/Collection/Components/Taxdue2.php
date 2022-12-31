<?php

namespace App\Http\Livewire\RealPropertyTax\Collection\Components;

use Livewire\Component;

class Taxdue2 extends Component
{
    public $pay_option;
    public $payment_dues;
    public $amount_due;
    public $payment_button = "disabled";

    public function open_payment(){

    }

    public function render()
    {
        return view('livewire.real-property-tax.collection.components.taxdue2');
    }
}
