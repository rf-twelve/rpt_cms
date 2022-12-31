<?php

namespace App\Http\Livewire\Forms;

use App\Models\RptTaxTable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentRecord extends Component
{

    public $tc_basic, $tc_sef, $tc_penalty, $tc_total, $tc_remarks, $or_number,  $date_now, $teller_name;
    public $paymentRecord;
    public $penalty_percentage;
    public $av_amount;
    public $cash = 0, $change = 0;

    protected $listeners = [
        'refreshForm' => '$refresh',
        'addPayment' => 'addPaymentEvent',
        // 'viewRecord' => 'viewRecordEvent'
    ];

    public function mount()
    {
        $this->resetFields();
        $this->teller_name = Auth::user()->firstname;
        $this->date_now = date("Y-m-d", strtotime('today'));
        // dd($getDate);
        // dd(strtotime($this->date_now));
        $month = strtolower(date("F"));
        $year = date("Y");
        $this->penalty_percentage = collect(RptTaxTable::where('year_from', $year)
            ->where('type', 'penalty')->select($month)->get());
        $this->or_number = '123456';
    }

    public function savePayment()
    {
        dd('save');
    }

    public function compute_amount()
    {
        dd(strtotime('today'));
        dd($this->penalty_percentage);
        $this->tc_basic = $this->av_amount * 0.01;
        $this->tc_sef = $this->tc_basic;
        $this->tc_penalty = $this->tc_basic;
        $this->tc_total = $this->tc_basic * 2;
    }
    public function compute_cash()
    {
        $this->change = $this->cash - $this->tc_total;
    }

    public function addPaymentEvent($data)
    {
        // dd(date('m'));
        $this->updateOn = true;
        $this->assessedValue = $data;
        $this->dispatchBrowserEvent('paymentOpen');
        $this->emitSelf('refreshForm');
    }

    public function resetFields()
    {
        $this->av_amount = 0;
        $this->tc_basic = 0;
        $this->tc_sef = 0;
        $this->tc_penalty = 0;
        $this->tc_total = 0;
        $this->tc_remarks = '';
        $this->cash = 0;
        $this->change = 0;
    }
    public function render()
    {
        return view('livewire.forms.payment-record');
    }
}
