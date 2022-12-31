<?php

namespace App\Http\Livewire\RealPropertyTax\Collection\Forms;

use App\Models\RptAccount;
use App\Models\ListProvince;
use App\Models\ListMunicity;
use App\Models\ListBarangay;
use App\Models\RptAccountableForm;
use App\Models\RptBooklet;
use App\Models\RptIssuedReceipt;
use App\Models\RptPaymentRecord;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Payment extends Component
{
    public $computations = [];
    public $pay_id;
    public $pay_date;
    public $pay_payee;
    public $pay_teller;
    public $pay_serial_no;
    public $pay_fund;
    public $pay_type;
    public $pay_year_from;
    public $pay_year_to;
    public $pay_quarter_from;
    public $pay_quarter_to;
    public $pay_year_no;
    public $pay_basic;
    public $pay_sef;
    public $pay_penalty;
    public $pay_amount_due;
    public $pay_amount_words;
    public $pay_cash;
    public $pay_change;
    public $pay_remarks;
    public $pay_directory;
    public $pay_status;
    public $pay_treasurer;
    public $pay_deputy;
    public $rpt_account_id;
    public $get_data = [];
    public $booklet = null;

    protected $listeners = [
        'openPayment' => 'openPaymentEvent',
    ];

    public function openPaymentEvent($data)
    {
        // dd('Open Payment');
        $this->reset();
        $this->dataSet($data);
        $this->get_data = $data;
        $this->dispatchBrowserEvent('paymentOpen');
    }

    public function print_payment() {
        ## Call private function saveQuery
        $vData = $this->validate();
        // $this->saveQuery();

        ## Save data on receipts
        $receipt = RptIssuedReceipt::create([
            'prev_trn' => $this->get_data['prev_trn'],
            'prev_date' => $this->get_data['prev_date'],
            'prev_for' => $this->get_data['prev_for'],
            'trn' => $vData['pay_serial_no'],
            'date' => $vData['pay_date'],
            'payee' => $vData['pay_payee'],
            'province' => $this->get_data['province'],
            'city' => $this->get_data['city'],
            'amount' => $this->get_data['amount'],
            'amount_words' => $vData['pay_amount_words'],
            'is_basic' => '1',
            'is_sef' => '1',
            'for' => $this->get_data['for'],
            'owner_name' => $this->get_data['owner_name'],
            'location' => $this->get_data['location'],
            'tdn' => $this->get_data['tdn'],
            'rpt_account_id' => $this->get_data['rpt_account_id'],
            'user_treasurer' => $vData['pay_treasurer'],
            'user_deputy' => $vData['pay_deputy'],
        ]);
        // $receipt->receipt_datas()
        foreach($this->get_data['bracket_computation'] as $index => $comp){
            $receipt->receipt_datas()->create([
                'av' => $comp['av'],
                'td' => $comp['td'],
                'year_no' => $comp['year_no'],
                'label' => $comp['label'],
                'total_td' => $comp['total_td'],
                'penalty' => $comp['penalty'],
                'subtotal' => $comp['subtotal'],
            ]);
        }
        // dd($receipt->trn);

        return redirect()->route('AF56 RECEIPT',$receipt->trn);

        // dd($this->get_data);
        // $this->saveQuery();
        // $collect = collect($this->get_data['pr_account']['assessed_values']);
        // dump($collect->sortBy('av_year_to')->last());
        // dump((ListBarangay::where('index',$this->get_data['pr_account']['lp_brgy'])->first()));
        // dump((ListMunicity::where('index',$this->get_data['pr_account']['lp_municity'])->first())->name);
        // dump($this->get_data['pr_account']);
        // dd($this->get_data);
        // $dataArray = array(
        //     'prev_trn' => '1252458',
        //     'prev_date' => date('Y-m-d'),
        //     'prev_for' => '3RD-4TH QUARTER 2021',
        //     'trn' => $vData['pay_serial_no'],
        //     'date' => $vData['pay_date'],
        //     'payee' =>  $vData['pay_payee'],
        //     'province' => 'MTO - Lopez, Quezon',
        //     'city' => (ListMunicity::where('index',$this->get_data['pr_account']['lp_municity'])->first())->name ?? 'LOPEZ',
        //     'amount' => $this->get_data['pr_amount_due'],
        //     'amount_words' => $vData['pay_amount_words'] ?? '',
        //     'is_basic' => 1,
        //     'is_sef' => 1,
        //     'for' => $this->get_data['pr_covered_year'],
        //     'owner_name' => $this->get_data['pr_account']['ro_name'],
        //     'computations' => $this->get_data['computations'],
        //     'location' => (ListBarangay::where('index',$this->get_data['pr_account']['lp_brgy'])->first())->name ?? '',
        //     'tdn' => $this->get_data['pr_account']['rpt_pin']  ?? '(Unknown)',
        //     // 'total_av' => $this->get_data['pr_tc_basic']*100,
        //     // 'tax_due' => $this->get_data['pr_tc_basic'],
        //     'installment_no' => $this->get_data['pr_year_no'],
        //     'installment_year' => $this->get_data['pr_covered_year'],
        //     'full_payment' => $this->get_data['pr_tc_basic'],
        //     'discount_penalty' => $discountPenalty,
        //     'subtotal' => $subTotal,
        //     'basic' => $subTotal,
        //     'sef'=> $subTotal,
        //     'grand_total'=> $subTotal*2,
        //     'person_treas'=> 'ROSARIO MARILOU MANZANO-UY',
        //     'person_deputy'=> $this->pay_teller,
        // );
    }


    public function save_payment()
    {
        ## Call private function saveQuery
        $this->saveQuery();

        $this->reset();
        $this->dispatchBrowserEvent('paymentClose');
        $this->dispatchBrowserEvent('swalSuccess');
        return $this->emitUp('accountPaymentRefresh');
    }

    private function saveQuery()
    {
        $vData = $this->validate();
        dump($vData);
        dd($this->get_data);
        ## Creating payment record
        RptPaymentRecord::create([
            'pay_date' => date('Y-m-d'),
            'pay_year_from' => $this->pay_year_from,
            'pay_year_to' => $this->pay_year_to,
            'pay_quarter_from' => $this->pay_quarter_from,
            'pay_quarter_to' => $this->pay_quarter_to,
            'pay_basic' => $this->pay_basic,
            'pay_sef' => $this->pay_sef,
            'pay_penalty' => $this->pay_penalty,
            'pay_amount_due' => $this->pay_amount_due,
            'pay_cash' => $vData['pay_cash'],
            'pay_change' => $this->pay_change,
            'pay_serial_no' => $vData['pay_serial_no'],
            'pay_fund' => $vData['pay_fund'],
            'pay_type' => $vData['pay_type'],
            'pay_directory' => $vData['pay_directory'],
            'pay_remarks' => $vData['pay_remarks'],
            'pay_payee' => $vData['pay_payee'],
            'pay_teller' => $vData['pay_teller'],
            'pay_status' => 1,
            'rpt_account_id' => $this->rpt_account_id,
        ]);
        ## Save Reciept
        $issued_receipt = RptIssuedReceipt::create([
            'prev_trn' => $this->get_data['pr_acccount']['rtdp_or_no'],
            'prev_date' => $this->get_data['pr_acccount']['rtdp_payment_date'],
            'prev_for' => $this->getPrevPaymentRecord,
            'trn' => $this->vData['pay_serial_no'],
            'date' => $this->vData['pay_date'],
            'payee' => $this->vData['pay_payee'],
            'province' => 'QUEZON',
            'city' => 'LOPEZ',
            'amount' => $this->pay_amount_due,
            'amount_words' => $this->pay_amount_words,
            'is_basic' => 1,
            'is_sef' => 1,
            'for' => $this->get_data['pr_covered_year'],
            'owner_name' => ['pr'],
            'location' => '',
            'tdn' => '',
            'rpt_account_id' => '',
            'user_treasurer' => '',
            'user_deputy' => '',
        ]);
        ## Update for RPT Account
        RptAccount::findOrFail($this->rpt_account_id)
            ->update([
                'rtdp_or_no' => $vData['pay_serial_no'],
                'rtdp_payment_date' => date('Y-m-d'),
                'rtdp_payment_covered_year' => $this->get_data['pr_covered_year'],
                'rtdp_payment_covered_fr' => $this->get_data['pr_year_first'],
                'rtdp_payment_covered_to' => $this->get_data['pr_year_last'],
                'rtdp_payment_quarter_fr' => $this->get_data['pr_quarter_first'],
                'rtdp_payment_quarter_to' => $this->get_data['pr_quarter_last'],
            ]);
        ## Update booklet
        if($this->booklet){
            RptBooklet::where('id',$this->booklet->id)->first()
            ->update([
                'issued_qty' => ($this->booklet->issued_qty == 0)
                        ? 1 : $this->booklet->issued_qty + 1,
                'issued_serial_from' => ($this->booklet->begin_serial_fr == 0)
                        ? $vData['serial_no'] : $this->booklet->issued_serial_from,
                'issued_serial_to' => $vData['serial_no'],
                'end_qty' => ($this->booklet->end_qty > 0)
                        ? $this->booklet->begin_qty - 1 : 0,
                'end_serial_from' => $this->booklet->begin_serial_from + 1,
                'amount' => $this->booklet->amount + $this->pay_amount_due,
            ]);
        }

    }

    public function close_payment()
    {
        $this->reset();
        $this->dispatchBrowserEvent('paymentClose');
    }

    public function updatedPayCash(){

        if (is_numeric($this->pay_amount_due) && is_numeric($this->pay_cash)) {
            $this->pay_change = $this->pay_cash - $this->pay_amount_due;
        }
    }


    public function render()
    {
        return view('livewire.real-property-tax.collection.forms.payment');
    }

    public function getSerialNumber(){
        $this->booklet = RptBooklet::query()
            ->where('user_id',auth()->user()->id)
            ->where('end_qty','>',0)
            ->orderBy('begin_serial_fr')
            ->first();

        return ($this->booklet)
            ? $this->booklet->end_serial_fr
            :'No Serial Number';
    }

    private function dataSet($data)
    {
        $this->pay_fund = 'general';
        $this->pay_type = 'cash';
        $this->pay_date = date('Y-m-d');
        $this->pay_teller = Auth::user()->firstname.' '.Auth::user()->lastname;
        $this->pay_serial_no = $this->getSerialNumber();
        $this->pay_year_from = $data['pr_year_first'];
        $this->pay_year_to = $data['pr_year_last'];
        $this->pay_quarter_from = $data['pr_quarter_first'];
        $this->pay_quarter_to = $data['pr_quarter_last'];
        $this->pay_year_no = $data['pr_year_no'];
        $this->pay_basic = $data['pr_tc_basic'];
        $this->pay_sef = $data['pr_tc_sef'];
        $this->pay_penalty = $data['pr_tc_penalty'];
        $this->pay_amount_due = $data['pr_amount_due'];
        $this->pay_cash = '';
        $this->pay_change = '';
        $this->pay_remarks = '';
        $this->pay_directory = '';
        $this->pay_status = 1;
        $this->pay_treasurer = 'HERMES A. ARGANTE';
        $this->pay_deputy = '';
        $this->rpt_account_id = $data['rpt_account_id'];
    }

    protected $rules = [
        'pay_fund' => 'required',
        'pay_type' => 'required',
        'pay_teller' => 'required',
        'pay_date' => 'required',
        'pay_payee' => 'required',
        'pay_amount_words' => 'nullable',
        'pay_serial_no' => 'required',
        'pay_cash' => 'required|numeric|gte:pay_amount_due',
        'pay_directory' => 'nullable',
        'pay_remarks' => 'nullable',
        'pay_treasurer' => 'nullable',
        'pay_deputy' => 'nullable',
    ];
    protected $messages = [
        // 'rpt_pin.required' => 'Property index Number is required!',
        'pay_fund.required' => 'Please select fund!',
        'pay_type.required' => 'Please from cash or checks!',
        'pay_teller.required' => 'Teller name is required!',
        'pay_serial_no.required' => 'O.R. / Serial # name is required!',
        'pay_date.required' => 'Payment date is required!',
        'pay_payee.required' => 'Payee name is required!',
        'pay_cash.required' => 'Payment cash/cheque is required!',
        'pay_cash.numeric' => 'It should be numeric value!',
        'pay_cash.gte' => 'The pay cash must be greater than or equal amount due!',
    ];
}
