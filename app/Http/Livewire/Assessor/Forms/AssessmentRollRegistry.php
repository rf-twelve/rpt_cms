<?php

namespace App\Http\Livewire\Assessor\Forms;

use App\Models\AssmtRollAccount;
use App\Models\ListBarangay;
use App\Models\ListMunicity;
use App\Models\ListProvince;
use App\Models\RptAccount;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AssessmentRollRegistry extends Component
{
    // 1.Set Variables
    // 3.Set Rules
    // 2.Account Info
    // 3.Assessed Value Info
    // 4.Payment Records Info

    // 1.Set Variables
    public $account_id;
    public $rpt_td_arp;
    public $rpt_pin;
    public $ro_name;
    public $ro_address;
    public $lp_lot_blk_no;
    public $lp_brgy;
    public $lp_municity;
    public $lp_province;
    public $rpt_kind;
    public $rpt_class;
    public $av_value;
    public $av_year;
    public $td_arp_no_prev;
    public $av_value_prev;
    public $rtdp_remarks;

    protected $listeners = [
        'refreshForm' => '$refresh',
        'addRecordRegistry' => 'addRecordEvent',
        'viewRecordRegistry' => 'viewRecordEvent'
    ];
    protected $rules = [
        'account_id' => 'nullable',
        'rpt_td_arp' => 'required',
        'rpt_pin' => 'required',
        'ro_name' => 'required',
        'ro_address' => 'required',
        'lp_lot_blk_no' => 'nullable',
        'lp_brgy' => 'required',
        'lp_municity' => 'required',
        'lp_province' => 'required',
        'rpt_kind' => 'required',
        'rpt_class' => 'required',
        'av_value' => 'required',
        'av_year' => 'required',
        'td_arp_no_prev' => 'required',
        'av_value_prev' => 'required',
        'rtdp_remarks' => 'nullable',
    ];
    protected $messages = [
        'rpt_pin.required' => 'Property index Number is required!',
        'rpt_kind.required' => 'Property kind is required!',
        'rpt_class.required' => 'Property classification is required!',
        'rpt_td_arp.required' => 'TD or ARP Number is required!',
        'ro_name.required' => 'Owner`s name is required!',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function addRecordEvent()
    {
        $this->reset();
        $this->resetValidation();
        $this->dispatchBrowserEvent('assessmentRollRegistryOpen');
    }

    public function closeRecord()
    {
        $this->reset();
        $this->resetValidation();
        $this->dispatchBrowserEvent('assessmentRollRegistryClose');
    }

    // RPT ACCCCOUNT
    public function viewRecordEvent($data)
    {
        $this->setRPTAccountFields($data);
        $this->dispatchBrowserEvent('assessmentRollRegistryOpen');
        $this->emitSelf('refreshForm');
    }

    public function saveRecord()
    {
        $vData = $this->validate();
        if (!empty($vData['account_id']) || !empty($vData['account_id'])) {
            $vData['rtdp_status'] = 'verified';
            AssmtRollAccount::findOrFail($this->account_id)
                ->update([
                    'assmt_roll_td_arp_no' => $vData['rpt_td_arp'],
                    'assmt_roll_pin' => $vData['rpt_pin'] ,
                    'assmt_roll_lot_blk_no' => $vData['lp_lot_blk_no'],
                    'assmt_roll_owner' => $vData['ro_name'],
                    'assmt_roll_address' => $vData['ro_address'],
                    'assmt_roll_brgy' => $vData['lp_brgy'],
                    'assmt_roll_municity' => $vData['lp_municity'],
                    'assmt_roll_province' => $vData['lp_province'],
                    'assmt_roll_kind' => $vData['rpt_kind'],
                    'assmt_roll_class' => $vData['rpt_class'],
                    'assmt_roll_av' => $vData['av_value'],
                    'assmt_roll_effective' => $vData['av_year'],
                    'assmt_roll_td_arp_no_prev' => $vData['td_arp_no_prev'],
                    'assmt_roll_av_prev' => $vData['av_value_prev'],
                    'assmt_roll_remarks' => $vData['rtdp_remarks'],
                    'assmt_roll_status' => 1,
                    'encoded_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
                ]);
            RptAccount::where('rpt_pin','=',$vData['rpt_pin'])
            ->where('rpt_td_no','=',$vData['rpt_td_arp'])
            ->update([
                'rpt_td_no' => $vData['rpt_td_arp'],
                'rpt_arp_no' => $vData['rpt_td_arp'],
                'rpt_pin' => $vData['rpt_pin'] ,
                'rpt_kind' => $vData['rpt_kind'],
                'rpt_class' => $vData['rpt_class'],
                'ro_name' => $vData['ro_name'],
                'ro_address' => $vData['ro_address'],
                'lp_lot_blk_no' => $vData['lp_lot_blk_no'],
                'rtdp_status' => 'verified',
                'encoded_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
            ]);
            $this->dispatchBrowserEvent('assessmentRollRegistryClose');
            $this->dispatchBrowserEvent('swalUpdate');
            return $this->emitUp('assessmentRollRefresh');
        }else{
            AssmtRollAccount::create([
                    'assmt_roll_td_arp_no' => $vData['rpt_td_arp'],
                    'assmt_roll_pin' => $vData['rpt_pin'] ,
                    'assmt_roll_lot_blk_no' => $vData['lp_lot_blk_no'],
                    'assmt_roll_owner' => $vData['ro_name'],
                    'assmt_roll_address' => $vData['ro_address'],
                    'assmt_roll_brgy' => $vData['lp_brgy'],
                    'assmt_roll_municity' => $vData['lp_municity'],
                    'assmt_roll_province' => $vData['lp_province'],
                    'assmt_roll_kind' => $vData['rpt_kind'],
                    'assmt_roll_class' => $vData['rpt_class'],
                    'assmt_roll_av' => $vData['av_value'],
                    'assmt_roll_effective' => $vData['av_year'],
                    'assmt_roll_td_arp_no_prev' => $vData['td_arp_no_prev'],
                    'assmt_roll_av_prev' => $vData['av_value_prev'],
                    'assmt_roll_remarks' => $vData['rtdp_remarks'],
                    'assmt_roll_status' => 1,
                    'encoded_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
                ]);

            $this->dispatchBrowserEvent('assessmentRollRegistryClose');
            $this->dispatchBrowserEvent('swalSuccess');
            return $this->emitUp('assessmentRollRefresh');
        }
    }

    // SET ALL THE DATAs
    public function setRPTAccountFields($data)
    {
        $this->account_id = $data['id'];
        $this->rpt_td_arp = $data['assmt_roll_td_arp_no'];
        $this->rpt_pin = $data['assmt_roll_pin'];
        $this->ro_name = $data['assmt_roll_owner'];
        $this->ro_address = $data['assmt_roll_address'];
        $this->lp_lot_blk_no = $data['assmt_roll_lot_blk_no'];
        $this->lp_brgy = $data['assmt_roll_brgy'];
        $this->lp_municity = $data['assmt_roll_municity'];
        $this->lp_province = $data['assmt_roll_province'];
        $this->rpt_kind = $data['assmt_roll_kind'];
        $this->rpt_class = $data['assmt_roll_class'];
        $this->av_value = $data['assmt_roll_av'];
        $this->av_year = $data['assmt_roll_effective'];
        $this->td_arp_no_prev = $data['assmt_roll_td_arp_no_prev'];
        $this->av_value_prev = $data['assmt_roll_av_prev'];
        $this->rtdp_remarks = $data['assmt_roll_remarks'];

    }

    public function render()
    {
        return view('livewire.assessor.forms.assessment-roll-registry',[
            'list_province' => ListProvince::get(['name','index'])->toArray(),
            'list_municity' => ListMunicity::get(['name','index'])->toArray(),
            'list_barangay' => ListBarangay::get(['name','index'])->toArray(),
        ]);
    }
}
