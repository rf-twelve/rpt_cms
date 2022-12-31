<?php

namespace App\Http\Livewire\RealPropertyTax\Accounts\Forms;

use App\Models\ListBarangay;
use App\Models\ListMunicity;
use App\Models\ListProvince;
use App\Models\RptAccount;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountView extends Component
{
    public $account_id;
    public $rpt_pin;
    public $rpt_kind;
    public $rpt_class;
    public $rpt_td_no;
    public $rpt_arp_no;
    public $ro_name;
    public $ro_address;
    public $lp_lot_blk_no;
    public $lp_street;
    public $lp_brgy;
    public $lp_municity;
    public $lp_province;
    public $rtdp_payment_date;
    public $rtdp_or_no;
    public $rtdp_payment_covered;
    public $rtdp_payment_covered_fr;
    public $rtdp_payment_covered_to;
    public $rtdp_payment_quarter_fr = 0;
    public $rtdp_payment_quarter_to = 0;
    public $rtdp_payment_covered_no = '';
    public $rtdp_remarks;
    public $rtdp_directory;
    public $rtdp_payment_start;
    public $rtdp_status;
    public $year_today;
    public $type;

    protected $listeners = [
        'refreshForm' => '$refresh',
        'viewAccount' => 'viewAccountEvent'
    ];
    protected $rules = [
        'rpt_pin' => 'required',
        'rpt_kind' => 'required',
        'rpt_class' => 'required',
        'rpt_td_no' => 'required',
        'rpt_arp_no' => 'nullable',
        'ro_name' => 'required',
        'ro_address' => 'nullable',
        'lp_lot_blk_no' => 'nullable',
        'lp_street' => 'nullable',
        'lp_brgy' => 'required|exists:App\Models\ListBarangay,index',
        'lp_municity' => 'required|exists:App\Models\ListMunicity,index',
        'lp_province' => 'required|exists:App\Models\ListProvince,index',
        'rtdp_payment_date' => 'nullable',
        'rtdp_or_no' => 'nullable',
        'rtdp_payment_covered_fr' => 'nullable|gte:1957|lte:2030',
        'rtdp_payment_covered_to' => 'nullable|gte:rtdp_payment_covered_fr|lte:2030',
        'rtdp_payment_quarter_fr' => 'required',
        'rtdp_payment_quarter_to' => 'required',
        'rtdp_status' => 'nullable',
        'rtdp_remarks' => 'nullable',
        'rtdp_payment_start' => 'nullable',
        'rtdp_directory' => 'nullable',
    ];
    protected $messages = [
        'rpt_pin.required' => 'Property index Number is required!',
        'rpt_kind.required' => 'Property kind is required!',
        'rpt_class.required' => 'Property classification is required!',
        'rpt_td_no.required' => 'TD or ARP Number is required!',
        'ro_name.required' => 'Owner`s name is required!',
        'lp_brgy.exists' => 'Please select from barangay list!',
        'lp_municity.exists' => 'Please select from municipality list!',
        'lp_province.exists' => 'Please select from province list!',
        // 'rtdp_tc_basic.required' => 'Tax Collected BASIC is required!',
        // 'rtdp_tc_sef.required' => 'Tax Collected SEF is required!',
        // 'rtdp_tc_penalty.required' => 'Tax Collected Penalty is required!',
        // 'rtdp_tc_total.required' => 'Tax Collected Total is required!',
        'rtdp_payment_date.required' => 'Payment date is required!',
        'rtdp_or_no.required' => 'O.R. number is required!',
        'rtdp_payment_covered_fr.required' => 'Payment covered from is required!',
        'rtdp_payment_covered_to.required' => 'Payment covered to is required!',
        'rtdp_payment_covered_fr.gte' => 'Payment year must be not later than 1957!',
        'rtdp_payment_covered_to.gte' => 'Payment year must be greater than or equal to year from',

        // 'rtdp_status.required' => 'Status is required!',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function closeRecord()
    {
        $this->reset();
        $this->resetValidation();
        $this->dispatchBrowserEvent('accountAccountClose');
    }

    // RPT ACCCCOUNT
    public function viewAccountEvent($data,$type)
    {
        $this->type = $type;
        $this->setRPTAccountFields($data);
        $this->dispatchBrowserEvent('accountAccountOpen');
        $this->emitSelf('refreshForm');
    }

    public function saveRecord()
    {
        // dd(Auth::user()->firstname.' '.Auth::user()->lastname);
        $vData = $this->validate();
        switch ($vData['rtdp_payment_quarter_fr']) {
            case 0.25:
                $q_from = "Q1";
                break;
            case 0.50:
                $q_from = "Q2";
                break;
            case 0.75:
                $q_from = "Q3";
                break;
            case 1:
                $q_from = "Q4";
                break;
            default:
                $q_from = "";
                break;
        }

        $vData = $this->validate();
        switch ($vData['rtdp_payment_quarter_to']) {
            case 0.25:
                $q_to = "Q1";
                break;
            case 0.50:
                $q_to = "Q2";
                break;
            case 0.75:
                $q_to = "Q3";
                break;
            case 1:
                $q_to = "Q4";
                break;
            default:
                $q_to = "";
                break;
        }
        $vData['rtdp_payment_covered_year'] = $vData['rtdp_payment_covered_fr'] . ' ' . $q_from . '-' . $vData['rtdp_payment_covered_to'] . ' ' . $q_to;
        $vData['rtdp_status'] = 'verified';
        $vData['encoded_by'] = Auth::user()->firstname.' '.Auth::user()->lastname;
        RptAccount::findOrFail($this->account_id)
            ->update($vData);
        $this->dispatchBrowserEvent('accountAccountClose');
        $this->dispatchBrowserEvent('swalUpdate');
        return $this->emitUp('refreshLedger');
    }

    // SET ALL THE DATAs
    public function setRPTAccountFields($data)
    {
        $this->account_id = $data['id'];
        $this->rpt_pin = $data['rpt_pin'];
        $this->rpt_kind = $data['rpt_kind'];
        $this->rpt_class = $data['rpt_class'];
        $this->rpt_td_no = $data['rpt_td_no'];
        $this->rpt_arp_no = $data['rpt_arp_no'];
        $this->ro_name = $data['ro_name'];
        $this->ro_address = $data['ro_address'];
        $this->lp_lot_blk_no = $data['lp_lot_blk_no'];
        $this->lp_street = $data['lp_street'];
        $this->lp_brgy = $data['lp_brgy'];
        $this->lp_municity = $data['lp_municity'];
        $this->lp_province = $data['lp_province'];
        $this->rtdp_payment_date = $data['rtdp_payment_date'];
        $this->rtdp_or_no = $data['rtdp_or_no'];
        $this->rtdp_payment_covered = $data['rtdp_payment_covered_year'];
        $this->rtdp_payment_covered_fr = $data['rtdp_payment_covered_fr'];
        $this->rtdp_payment_covered_to = $data['rtdp_payment_covered_to'];
        $this->rtdp_payment_quarter_fr = is_null($data['rtdp_payment_quarter_fr']) ? 0 : $data['rtdp_payment_quarter_fr'];
        $this->rtdp_payment_quarter_to = is_null($data['rtdp_payment_quarter_to']) ? 0 : $data['rtdp_payment_quarter_to'];
        $this->rtdp_remarks = $data['rtdp_remarks'];
        $this->rtdp_directory = $data['rtdp_directory'];
        $this->rtdp_payment_start = $data['rtdp_payment_start'];
        $this->rtdp_status = $data['rtdp_status'];
    }

    public function mount()
    {
        $this->year_today = date('Y');
        // $this->addAssessedValue();
    }

    public function render()
    {
        return view('livewire.real-property-tax.accounts.forms.account-view',[
            'list_province' => ListProvince::get(['name','index'])->toArray(),
            'list_municity' => ListMunicity::get(['name','index'])->toArray(),
            'list_barangay' => ListBarangay::get(['name','index'])->toArray(),
        ]);
    }
}
