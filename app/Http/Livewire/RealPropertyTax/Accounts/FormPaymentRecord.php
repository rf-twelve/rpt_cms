<?php

namespace App\Http\Livewire\RealPropertyTax\Accounts;

use App\Models\RptAccount;
use App\Models\RptAssessedValue;
use App\Models\RptPaymentRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormPaymentRecord extends Component
{
    public $latestPaymentId = '';
    public $vdata = [];
    public $uid;
    public $pay_date;
    public $pay_year_from;
    public $pay_year_to;
    public $pay_quarter_from;
    public $pay_quarter_to;
    public $pay_covered_year;
    public $pay_basic;
    public $pay_sef;
    public $pay_penalty;
    public $pay_amount_due;
    public $pay_cash;
    public $pay_change;
    public $pay_serial_no;
    public $pay_type;
    public $pay_fund;
    public $pay_directory;
    public $pay_remarks;
    public $pay_teller;
    public $pay_payee;
    public $pay_status;
    public $rpt_account_id;
    public $pay_amount_due_display = 0.00;
    public $pay_cash_display = 0.00;
    public $pay_change_display = 0.00;

    protected $listeners = [
        'addPaymentRecord' => 'addPaymentRecordEvent',
        'editPaymentRecord' => 'editPaymentRecordEvent',
    ];

    protected $rules = [
        'pay_date' => 'required',
        'pay_year_from' => 'required',
        'pay_year_to' => 'required|numeric|gte:pay_year_from',
        'pay_quarter_from' => 'required',
        'pay_quarter_to' => 'required',
        'pay_covered_year' => 'nullable',
        'pay_basic' => 'nullable|numeric',
        'pay_sef' => 'nullable|numeric',
        'pay_penalty' => 'nullable|numeric',
        'pay_amount_due' => 'nullable|numeric',
        'pay_cash' => 'nullable',
        'pay_change' => 'nullable',
        'pay_serial_no' => 'nullable',
        'pay_type' => 'required',
        'pay_fund' => 'required',
        'pay_directory' => 'nullable',
        'pay_remarks' => 'nullable',
        'pay_teller' => 'nullable',
        'pay_payee' => 'nullable',
        'pay_status' => 'nullable',
        'rpt_account_id' => 'nullable',
    ];
    protected $messages = [
        'pay_basic.numeric' => 'Value should be numeric!',
        'pay_sef.numeric' => 'Value should be numeric!',
        'pay_penalty.numeric' => 'Value should be numeric!',
        'pay_year_from.required' => 'Payment year is numeric and required!',
        'pay_year_to.required' => 'Payment year is numeric and required!',
        'pay_year_to.gte' => 'This field must be greater than year from!',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function addPaymentRecordEvent($account_id)
    {
        $this->resetFields();
        $this->rpt_account_id = $account_id;
        $this->dispatchBrowserEvent('paymentRecordOpen');
    }

    public function editPaymentRecordEvent($id)
    {
        $record = RptPaymentRecord::findOrFail($id);

        ## If Record found, Get rpt account id.
        if($record){
            ## Search all record with same rpt account id.
            $all = RptPaymentRecord::where('rpt_account_id',$record->rpt_account_id)->get();
            ## Find latest record and get the payment record id.
            $this->latestPaymentId = ($all->sortByDesc('pay_year_to')->first())->id;
        }
        ## Use the id as comparison for updating rpt account.
        $this->setPaymentRecord($record);
        $this->dispatchBrowserEvent('paymentRecordOpen');
    }
    public function savePaymentRecord()
    {
        $this->vdata = $this->validate();
        #### Another update
        dd($this->vdata);
        if (empty($this->uid)) {
            $this->vdata['pay_status'] = 1;
            RptPaymentRecord::create($this->vdata);
        } else {
            RptPaymentRecord::findOrFail($this->uid)->update($this->vdata);
            if($this->uid == $this->latestPaymentId){
                $this->updateRptAccount($this->vdata['rpt_account_id']);
            }
        }
        $this->dispatchBrowserEvent('paymentRecordClose');
        $this->emitUp('refreshLedger');
        $this->dispatchBrowserEvent('swalUpdate');
        $this->reset();
    }

    public function updateRptAccount($id)
    {
        RptAccount::find($id)->update([
            'rtdp_tc_basic' => $this->vdata['pay_basic'],
            'rtdp_tc_sef' => $this->vdata['pay_sef'],
            'rtdp_tc_penalty' => $this->vdata['pay_penalty'],
            'rtdp_tc_total' => ($this->vdata['pay_basic']+$this->vdata['pay_penalty'])*2,
            'rtdp_or_no' => $this->vdata['pay_serial_no'],
            'rtdp_payment_date' => $this->vdata['pay_date'],
            'rtdp_payment_covered_year' => $this->vdata['pay_covered_year'],
            'rtdp_payment_covered_fr' => $this->vdata['pay_year_from'],
            'rtdp_payment_covered_to' => $this->vdata['pay_year_to'],
            'rtdp_payment_quarter_fr' => $this->vdata['pay_quarter_from'],
            'rtdp_payment_quarter_to' => $this->vdata['pay_quarter_to'],
            'rtdp_remarks' => $this->vdata['pay_remarks'],
            'rtdp_directory' => $this->vdata['pay_directory'],
        ]);
    }

    public function updatedPayBasic(){
        $this->computeAmountDue();
    }
    public function updatedPaySef(){
        $this->computeAmountDue();
    }
    public function updatedPayPenalty(){
        $this->computeAmountDue();
    }
    public function updatedPayCash(){
        $this->computeChange();
    }

    public function setPaymentRecord($data)
    {
        $this->uid = $data->id;
        $this->pay_date = $data->pay_date;
        $this->pay_year_from = $data->pay_year_from;
        $this->pay_year_to = $data->pay_year_to;
        $this->pay_quarter_from = $data->pay_quarter_from;
        $this->pay_quarter_to = $data->pay_quarter_to;
        $this->pay_covered_year = $data->pay_covered_year;
        $this->pay_basic = $data->pay_basic;
        $this->pay_sef = $data->pay_sef;
        $this->pay_penalty = $data->pay_penalty;
        $this->pay_amount_due = $data->pay_amount_due;
        $this->pay_cash = $data->pay_cash;
        $this->pay_change = $data->pay_change;
        $this->pay_serial_no = $data->pay_serial_no;
        $this->pay_type = $data->pay_type;
        $this->pay_fund = $data->pay_fund;
        $this->pay_directory = $data->pay_directory;
        $this->pay_remarks = $data->pay_remarks;
        $this->pay_teller = $data->pay_teller;
        $this->pay_payee = $data->pay_payee;
        $this->pay_status = $data->pay_status;
        $this->rpt_account_id = $data->rpt_account_id;
        $this->computeAmountDue();
        $this->computeChange();
    }

    public function computeAmountDue(){

        if (!empty($this->pay_basic) && !empty($this->pay_sef) && !empty($this->pay_penalty)) {
            $this->pay_amount_due = number_format(($this->pay_basic + $this->pay_penalty)*2, 2);
            $this->pay_amount_due_display = $this->pay_amount_due;
        }
    }
    public function computeChange(){
        $this->pay_cash_display = number_format($this->pay_cash,2);
        if (!empty($this->pay_amount_due) && !empty($this->pay_cash)) {
            $this->pay_change = number_format($this->pay_cash - $this->pay_amount_due, 2);
            $this->pay_change_display = $this->pay_change;
        }
    }


    public function resetFields(){
        $this->uid = '';
        $this->pay_date = date('Y-m-d');
        $this->pay_year_from = '';
        $this->pay_year_to = '';
        $this->pay_quarter_from = '';
        $this->pay_quarter_to = '';
        $this->pay_covered_year = '';
        $this->pay_basic = '';
        $this->pay_sef = '';
        $this->pay_penalty = '';
        $this->pay_amount_due = '';
        $this->pay_cash = '';
        $this->pay_change = '';
        $this->pay_serial_no = '';
        $this->pay_type = '';
        $this->pay_fund = '';
        $this->pay_directory = '';
        $this->pay_remarks = '';
        $this->pay_teller = '';
        $this->pay_payee = '';
        $this->pay_status = '';
        $this->rpt_account_id = '';
    }

    public function render()
    {
        // $this->compute();
        return view('livewire.real-property-tax.accounts.form-payment-record');
    }
}
