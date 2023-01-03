<?php

namespace App\Http\Livewire\Assessor\Forms;

use App\Models\AssmtRollAccount;
use App\Models\ListBarangay;
use App\Models\ListMunicity;
use App\Models\ListProvince;
use App\Models\RptAccount;
use App\Models\RptAssessedValue;
use App\Models\RptBracket;
use App\Models\RptPaymentRecord;
use Livewire\Component;
use Illuminate\Support\Str;

class AccountVerify extends Component
{
    // 1.Set Variables
    public $account_id;
    public $uid;
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
    public $rtdp_td_basic = 0;
    public $rtdp_td_sef = 0;
    public $rtdp_td_penalty = 0;
    public $rtdp_td_total = 0;
    public $rtdp_tc_basic = 0;
    public $rtdp_tc_sef = 0;
    public $rtdp_tc_penalty = 0;
    public $rtdp_tc_total = 0;
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
    public $assessedValues = [];

    public $assmt_id;
    public $assmt_roll_pin;
    public $assmt_roll_kind;
    public $assmt_roll_class;
    public $assmt_roll_td_arp_no;
    public $assmt_roll_owner;
    public $assmt_roll_address;
    public $assmt_roll_lot_blk_no;
    public $assmt_roll_street = 'N/A';
    public $assmt_roll_brgy;
    public $assmt_roll_municity = 16;
    public $assmt_roll_province = '015';
    public $assmt_roll_av;
    public $assmt_roll_effective;
    public $assmt_roll_td_arp_no_prev;
    public $assmt_roll_av_prev;
    public $assmt_roll_remarks;
    public $assmt_roll_status;

    public $assmt_rolls = [];
    public $search_option = 'assmt_roll_pin', $search_input = '';

    public $avDataArray = [], $prDataArray = [];
    public $display_av = false, $display_pr = true, $year_today;

    protected $listeners = [
        'refreshForm' => '$refresh',
        'verifyRecord' => 'verifyRecordEvent'
    ];
    protected $rules = [
        // 'uid' => 'nullable',
        'rpt_pin' => 'required',
        'rpt_kind' => 'required',
        'rpt_class' => 'required',
        'rpt_td_no' => 'nullable',
        'rpt_arp_no' => 'nullable',
        'ro_name' => 'required',
        'ro_address' => 'nullable',
        'lp_lot_blk_no' => 'nullable',
        'lp_street' => 'nullable',
        'lp_brgy' => 'required|exists:App\Models\ListBarangay,index',
        'lp_municity' => 'required|exists:App\Models\ListMunicity,index',
        'lp_province' => 'required|exists:App\Models\ListProvince,index',
        'rtdp_td_basic' => 'nullable',
        'rtdp_td_sef' => 'nullable',
        'rtdp_td_penalty' => 'nullable',
        'rtdp_td_total' => 'nullable',
        'rtdp_tc_basic' => 'nullable',
        'rtdp_tc_sef' => 'nullable',
        'rtdp_tc_penalty' => 'nullable',
        'rtdp_tc_total' => 'nullable',
        'rtdp_payment_date' => 'date|nullable',
        'rtdp_or_no' => 'nullable',
        'rtdp_payment_covered_fr' => 'nullable|gte:1957|lte:2030',
        'rtdp_payment_covered_to' => 'nullable|gte:rtdp_payment_covered_fr|lte:2030',
        'rtdp_payment_quarter_fr' => 'required',
        'rtdp_payment_quarter_to' => 'required',
        'rtdp_status' => 'nullable',
        'rtdp_remarks' => 'nullable',
        'rtdp_payment_start' => 'nullable',
        'rtdp_directory' => 'nullable',
        // 'av_data_array.*.av_year_from' => 'nullable|numeric|gte:1957|lte:2030',
        // 'av_data_array.*.av_year_to' => 'nullable|numeric|gte:av_year_from|lte:2030',
        // 'av_data_array.*.av_value' => 'nullable|numeric',
    ];
    protected $messages = [
        'rpt_pin.required' => 'Property index Number is required!',
        'rpt_kind.required' => 'Property kind is required!',
        'rpt_class.required' => 'Property classification is required!',
        'rpt_td_no.required' => 'TD or ARP Number is required!',
        'ro_name.required' => 'Owner`s name is required!',
        'rtdp_av_old.required' => 'Previous AV is required!',
        'rtdp_av_new.required' => 'New AV is required!',
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
        $this->dispatchBrowserEvent('accountVerifyClose');
    }


    // RPT ACCCCOUNT
    public function verifyRecordEvent($data)
    {
        $this->reset();
        $this->setRPTAccountFields($data);
        $this->avDataArray = $this->setAssessedValuesFields($data);
        $this->dispatchBrowserEvent('accountVerifyOpen');
        $this->emitSelf('refreshForm');
    }

    // RPT ACCCCOUNT
    public function mergeRecord()
    {
        $this->rpt_pin = (empty($this->assmt_roll_pin) || is_null($this->assmt_roll_pin)) ? $this->rpt_pin : $this->assmt_roll_pin;
        $this->rpt_kind = (empty($this->assmt_roll_kind) || is_null($this->assmt_roll_kind)) ? $this->rpt_kind : $this->assmt_roll_kind;
        $this->rpt_class = (empty($this->assmt_roll_class) || is_null($this->assmt_roll_class)) ? $this->rpt_class : $this->assmt_roll_class;
        $this->rpt_td_no = (empty($this->assmt_roll_td_arp_no) || is_null($this->assmt_roll_td_arp_no)) ? $this->rpt_td_no : $this->assmt_roll_td_arp_no;
        $this->rpt_arp_no = (empty($this->assmt_roll_td_arp_no) || is_null($this->assmt_roll_td_arp_no)) ? $this->rpt_arp_no : $this->assmt_roll_td_arp_no;
        $this->ro_name = (empty($this->assmt_roll_owner) || is_null($this->assmt_roll_owner)) ? $this->ro_name : $this->assmt_roll_owner;
        $this->ro_address = (empty($this->assmt_roll_address) || is_null($this->assmt_roll_address)) ? $this->ro_address : $this->assmt_roll_address;
        $this->lp_lot_blk_no = (empty($this->assmt_roll_lot_blk_no) || is_null($this->assmt_roll_lot_blk_no)) ? $this->lp_lot_blk_no : $this->assmt_roll_lot_blk_no;
        $this->lp_street = (empty($this->assmt_roll_street) || is_null($this->assmt_roll_street)) ? $this->lp_brgy : $this->assmt_roll_street;
        $this->lp_brgy = (empty($this->assmt_roll_brgy) || is_null($this->assmt_roll_brgy)) ? $this->lp_brgy : $this->assmt_roll_brgy;
        $this->lp_municity = (empty($this->assmt_roll_municity) || is_null($this->assmt_roll_municity)) ? $this->lp_municity : $this->assmt_roll_municity;
        $this->lp_province = (empty($this->assmt_roll_province) || is_null($this->assmt_roll_province)) ? $this->lp_province : $this->assmt_roll_province;
        $this->rtdp_remarks = (empty($this->assmt_roll_remarks) || is_null($this->assmt_roll_remarks)) ? $this->rtdp_remarks : $this->assmt_roll_remarks;
    }

    // RPT ACCCCOUNT
    public function search_record()
    {
       $this->assmt_rolls =  AssmtRollAccount::where($this->search_option, 'like', '%'.$this->search_input.'%')
                ->select('id','assmt_roll_td_arp_no','assmt_roll_pin','assmt_roll_lot_blk_no','assmt_roll_owner','assmt_roll_address',)
                ->limit(10)->get();
    }
    // RPT ACCCCOUNT
    public function select_record($id)
    {
        $record = AssmtRollAccount::findOrfail($id);
        $this->assmt_id = $record->id;
        $this->assmt_roll_pin = $record->assmt_roll_pin;
        $this->assmt_roll_kind = $record->assmt_roll_kind;
        $this->assmt_roll_class = $record->assmt_roll_class;
        $this->assmt_roll_td_arp_no = $record->assmt_roll_td_arp_no;
        $this->assmt_roll_owner = $record->assmt_roll_owner;
        $this->assmt_roll_address = $record->assmt_roll_address;
        $this->assmt_roll_lot_blk_no = $record->assmt_roll_lot_blk_no;
        $this->assmt_roll_brgy = $record->assmt_roll_brgy;
        $this->assmt_roll_municity = $record->assmt_roll_municity;
        $this->assmt_roll_province = $record->assmt_roll_province;
        $this->assmt_roll_av = $record->assmt_roll_av;
        $this->assmt_roll_effective = $record->assmt_roll_effective;
        $this->assmt_roll_td_arp_no_prev = $record->assmt_roll_td_arp_no_prev;
        $this->assmt_roll_av_prev = $record->assmt_roll_av_prev;
        $this->assmt_roll_remarks = $record->assmt_roll_remarks;
        $this->assmt_roll_status = $record->assmt_roll_status;
        $this->search_input = '';
    }

    // Get the quarter value
    public function getQuarterName($value){
        switch ($value) {
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
    }

    public function saveRecord()
    {
        $vData = $this->validate();
        $vData['rtdp_status'] = 'verified';
        $assessedValuesArray = [];
        // Get the quarter values
        $q_from = $this->getQuarterName($vData['rtdp_payment_quarter_fr']);
        $q_to = $this->getQuarterName($vData['rtdp_payment_quarter_to']);

        if ($q_from) {
            $vData['rtdp_payment_covered_year'] = $vData['rtdp_payment_covered_fr'] . ' ' . $q_from . '-' . $vData['rtdp_payment_covered_to'] . ' ' . $q_to;
        } else {
            $vData['rtdp_payment_covered_year'] = $vData['rtdp_payment_covered_fr'] . '-' . $vData['rtdp_payment_covered_to'] . ' ' . $q_to;
        }

        if ($this->uid) {
            $vData['id'] = $this->uid;
            RptAccount::findOrFail($this->uid)->update($vData);
            foreach ($this->avDataArray as $key => $value) {
                RptAssessedValue::create($value);
            }
            if($vData['rtdp_or_no'] || $vData['rtdp_payment_covered_to'] ){
                // Save Payment Records
                $this->setPaymentRecordFields($vData);
            }
            // RptPaymentRecord::create();
            $this->setRPTAccountFields($vData);
        } else {
            RptAccount::create($vData);
        }

        // To Update assessment Roll
        if($this->assmt_id){
            $updateAssmtRoll = AssmtRollAccount::findOrFail($this->assmt_id)
            ->update([
            'assmt_roll_td_arp_no' => $vData['rpt_arp_no'],
            'assmt_roll_pin' => $vData['rpt_pin'],
            'assmt_roll_lot_blk_no' => $vData['lp_lot_blk_no'],
            'assmt_roll_owner' => $vData['ro_name'],
            'assmt_roll_address' => $vData['ro_address'],
            'assmt_roll_brgy' => $vData['lp_brgy'],
            'assmt_roll_municity' => $vData['lp_municity'],
            'assmt_roll_province' => $vData['lp_province'],
            'assmt_roll_kind' => $vData['rpt_kind'],
            'assmt_roll_class' => $vData['rpt_class'],
            'assmt_roll_av' => $this->assmt_roll_av,
            'assmt_roll_effective' => $this->assmt_roll_effective,
            'assmt_roll_td_arp_no_prev' => $this->assmt_roll_td_arp_no_prev,
            'assmt_roll_av_prev' => $this->assmt_roll_av_prev,
            'assmt_roll_remarks' => $this->assmt_roll_remarks,
            'assmt_roll_status' => "verified"
            ]);
        }

        // dd($vData);

        $this->reset();
        $this->dispatchBrowserEvent('accountVerifyClose');
        $this->dispatchBrowserEvent('swalSuccess');
        return $this->emitUp('accountVerificationRefresh');
    }

    // SET ALL THE DATAs
    public function setRPTAccountFields($data)
    {
        // dd($data['id']);
        $this->uid = $data['id'];
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
        $this->rtdp_td_basic = $data['rtdp_td_basic'];
        $this->rtdp_td_sef = $data['rtdp_td_sef'];
        $this->rtdp_td_penalty = $data['rtdp_td_penalty'];
        $this->rtdp_td_total = $data['rtdp_td_total'];
        $this->rtdp_tc_basic = $data['rtdp_tc_basic'];
        $this->rtdp_tc_sef = $data['rtdp_tc_sef'];
        $this->rtdp_tc_penalty = $data['rtdp_tc_penalty'];
        $this->rtdp_tc_total = $data['rtdp_tc_total'];
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

    public function setAssessedValuesFields($data)
    {
        $bracket = RptBracket::select('year_from', 'year_to')->get()->toArray();
        // dd($bracket);
        $av_filtered = collect($data)->only(
            "temp_1957_1966","temp_1967_1973","temp_1974_1979","temp_1980_1984","temp_1985_1993","temp_1994_1996",
            "temp_1997_2002","temp_2003_2018","temp_2019_2019","temp_2020_2020","temp_2021_2021","temp_2022_2022",
        );
        $num = 0;
        foreach ($av_filtered as $key => $value) {
            // $av_data_arr[$num]['id'] = '';
            $av_data_arr[$num]['rpt_account_id'] = $data['id'];
            $av_data_arr[$num]['av_pin'] = $data['rpt_pin'];
            $av_data_arr[$num]['av_value'] = $value;
            $av_data_arr[$num]['av_year_from'] = Str::substr($key, -9, 4);
            $av_data_arr[$num]['av_year_to'] = Str::substr($key, -4, 4);
            $num++;
        }
        return $av_data_arr;
    }

    public function setPaymentRecordFields($data)
    {
        RptPaymentRecord::create([
            'pay_date' => $data['rtdp_payment_date'],
            'pay_year_from' => $data['rtdp_payment_covered_fr'],
            'pay_year_to' => $data['rtdp_payment_covered_to'],
            'pay_quarter_from' => is_null($data['rtdp_payment_quarter_fr']) ? 0 : $data['rtdp_payment_quarter_fr'],
            'pay_quarter_to' => is_null($data['rtdp_payment_quarter_to']) ? 0 : $data['rtdp_payment_quarter_to'],
            'pay_covered_year' => $data['rtdp_payment_covered_to'] - $data['rtdp_payment_covered_fr'] + 1,
            'pay_basic' => $data['rtdp_tc_basic'],
            'pay_sef' => $data['rtdp_tc_sef'],
            'pay_penalty' => $data['rtdp_tc_penalty'],
            // 'pay_total' => $data['rtdp_tc_basic'] + $data['rtdp_tc_sef'] +  $data['rtdp_tc_penalty'],
            'pay_amount_due' => $data['rtdp_td_total'] + $data['rtdp_tc_total'],
            'pay_cash' => $data['rtdp_td_total'] + $data['rtdp_tc_total'],
            'pay_change' => 0,
            'pay_fund' => 'general',
            'pay_type' => 'cash',
            'pay_serial_no' => $data['rtdp_or_no'],
            'pay_directory' => $data['rtdp_directory'],
            'pay_remarks' => $data['rtdp_remarks'],
            'pay_teller' => null,
            'pay_payee' => '',
            'pay_status' => 1,
            'rpt_account_id' => $this->uid,
        ]);
    }

    public function removeAssessedValue($index)
    {
        // $find = RptAssessedValue::find($this->av_data_array[$index]['id']);
        // if (!is_null($find)) {
        //     RptAssessedValue::find($this->av_data_array[$index]['id'])->delete();
        // }
        unset($this->avDataArray[$index]);
        $this->avDataArray = array_values($this->avDataArray);
    }

    public function mount()
    {
        $this->year_today = date('Y');
        // $this->addAssessedValue();
    }

    public function render()
    {
        if (is_numeric($this->rtdp_td_basic) && is_numeric($this->rtdp_td_sef) && is_numeric($this->rtdp_td_penalty)) {
            $this->rtdp_td_total = $this->rtdp_td_basic + $this->rtdp_td_sef + $this->rtdp_td_penalty;
        }
        if (is_numeric($this->rtdp_tc_basic) && is_numeric($this->rtdp_tc_sef) && is_numeric($this->rtdp_tc_penalty)) {
            $this->rtdp_tc_total = $this->rtdp_tc_basic + $this->rtdp_tc_sef + $this->rtdp_tc_penalty;
        }
        if (is_numeric($this->rtdp_payment_covered_to) && is_numeric($this->rtdp_payment_covered_fr)) {
            $this->rtdp_payment_covered_no = $this->rtdp_payment_covered_to - $this->rtdp_payment_covered_fr + 1;
        }
        return view('livewire.assessor.forms.account-verify',[
            'assessment_rolls' => $this->assmt_rolls,
            'list_province' => ListProvince::get(['name','index'])->toArray(),
            'list_municity' => ListMunicity::get(['name','index'])->toArray(),
            'list_barangay' => ListBarangay::get(['name','index'])->toArray(),
        ]
    );
    }
}

