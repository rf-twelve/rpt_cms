<?php

namespace App\Http\Livewire\Forms;

use App\Models\RptAcc_av;
use App\Models\RptAcc_pr;
use App\Models\RptAcc_rtdp;
use App\Models\RptAccount;
use App\Models\RptFormula_basic;
use Livewire\Component;

class LedgerAccount extends Component
{

    public $updateOn = false;
    public $rpt_pin, $rpt_kind, $rpt_class, $rpt_td_arp_no, $ro_name, $ro_address, $ro_date_transfer, $ro_transfer_to, $lp_lot_blk_no, $lp_street, $lp_brgy, $lp_municity, $lp_province, $rtdp_arp_no, $rtdp_av_land, $rtdp_av_improve, $rtdp_av_total, $rtdp_tax_year, $rtdp_td_basic, $rtdp_td_sef, $rtdp_td_penalty, $rtdp_td_total, $rtdp_tc_basic, $rtdp_tc_sef, $rtdp_tc_penalty, $rtdp_tc_total, $rtdp_or_no, $rtdp_payment_date, $rtdp_payment_covered, $rtdp_bal_basic, $rtdp_bal_sef, $rtdp_bal_penalty, $rtdp_bal_total, $rtdp_remarks, $created_at, $updated_at;
    public $assessed_value = '', $collected_taxes = "";
    public $av_label, $account_id, $payment_record;

    public function mount($selectedID)
    {
        $data = RptAccount::findOrFail($selectedID);
        $this->setFields($data);
        $this->findAV($data);
        $this->findRP($data);
        $this->getPaymentRecord($data);
        $this->av_label();
    }

    public function addAssessedValue()
    {
        $this->emitSelf('refreshForm');
        $this->emit('addAssessedValue', $this->assessed_value);
    }
    public function addPayment()
    {
        $this->emitSelf('refreshForm');
        $this->emit('addPayment', $this->payment_record);
    }

    public function findAV($data)
    {
        $av_record = RptAcc_av::where('rpt_account_id', $data['id'])->get();
        $this->assessed_value = $av_record;
    }
    public function findRP($data)
    {
        $pr_record = RptAcc_pr::where('rpt_account_id', $data['id'])->get();
        $this->payment_record = $pr_record;
    }

    public function closeRecord()
    {
        $this->dispatchBrowserEvent('rptRegistryClose');
        $this->resetFields();
        $this->emitSelf('refreshForm');
    }

    public function setFields($data)
    {
        $this->rpt_pin = $data->rpt_pin;
        $this->rpt_kind = $data->rpt_kind;
        $this->rpt_class = $data->rpt_class;
        $this->rpt_td_arp_no = $data->rpt_td_arp_no;
        $this->ro_name = $data->ro_name;
        $this->ro_address = $data->ro_address;
        $this->ro_transfer_to = $data->ro_transfer_to;
        $this->ro_date_transfer = $data->ro_date_transfer;
        $this->lp_lot_blk_no = $data->lp_lot_blk_no;
        $this->lp_street = $data->lp_street;
        $this->lp_brgy = $data->lp_brgy;
        $this->lp_municity = $data->lp_municity;
        $this->lp_province = $data->lp_province;
        $this->rtdp_arp_no = $data->rtdp_arp_no;
        $this->rtdp_av_land = $data->rtdp_av_land;
        $this->rtdp_av_improve = $data->rtdp_av_improve;
        $this->rtdp_av_total = $data->rtdp_av_total;
        $this->rtdp_tax_year = $data->rtdp_tax_year;
        $this->rtdp_td_basic = $data->rtdp_td_basic;
        $this->rtdp_td_sef = $data->rtdp_td_sef;
        $this->rtdp_td_penalty = $data->rtdp_td_penalty;
        $this->rtdp_td_total = $data->rtdp_td_total;
        $this->rtdp_tc_basic = $data->rtdp_tc_basic;
        $this->rtdp_tc_sef = $data->rtdp_tc_sef;
        $this->rtdp_tc_penalty = $data->rtdp_tc_penalty;
        $this->rtdp_tc_total = $data->rtdp_tc_total;
        $this->rtdp_or_no = $data->rtdp_or_no;
        $this->rtdp_payment_date = $data->rtdp_payment_date;
        $this->rtdp_payment_covered = $data->rtdp_payment_covered;
        $this->rtdp_bal_basic = $data->rtdp_bal_basic;
        $this->rtdp_bal_sef = $data->rtdp_bal_sef;
        $this->rtdp_bal_penalty = $data->rtdp_bal_penalty;
        $this->rtdp_bal_total = $data->rtdp_bal_total;
        // $this->rtdp_remarks = $data['rtdp_remarks'];
    }

    public function resetFields()
    {
        $this->rpt_pin = "";
        $this->rpt_kind = "";
        $this->rpt_class = "";
        $this->rpt_td_arp_no = "";
        $this->ro_name = "";
        $this->ro_address = "";
        $this->ro_transfer_to = "";
        $this->ro_date_transfer = "";
        $this->lp_lot_blk_no = "";
        $this->lp_street = "";
        $this->lp_brgy = "";
        $this->lp_municity = "";
        $this->lp_province = "";
        $this->rtdp_arp_no = "";
        $this->rtdp_av_land = "";
        $this->rtdp_av_improve = "";
        $this->rtdp_av_total = "";
        $this->rtdp_tax_year = "";
        $this->rtdp_td_basic = "";
        $this->rtdp_td_sef = "";
        $this->rtdp_td_penalty = "";
        $this->rtdp_td_total = "";
        $this->rtdp_tc_basic = "";
        $this->rtdp_tc_sef = "";
        $this->rtdp_tc_penalty = "";
        $this->rtdp_tc_total = "";
        $this->rtdp_or_no = "";
        $this->rtdp_payment_date = "";
        $this->rtdp_payment_covered = "";
        $this->rtdp_bal_basic = "";
        $this->rtdp_bal_sef = "";
        $this->rtdp_bal_penalty = "";
        $this->rtdp_bal_total = "";
        // $this->rtdp_remarks = "";
    }

    public function av_label()
    {
        $label = RptFormula_basic::orderBy('yb_from', 'asc')
            ->get();
        $this->av_label = $label;
    }
    public function getPaymentRecord($data)
    {
        $records = RptAcc_rtdp::where('rpt_account_id', $data['id'])->orderBy('payment_date', 'asc')
            ->get();
        $this->collected_taxes = $records;
    }

    public function render()
    {
        return view('livewire.forms.ledger-account');
    }
}
