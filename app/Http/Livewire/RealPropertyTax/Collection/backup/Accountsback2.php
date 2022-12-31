<?php

namespace App\Http\Livewire\RealPropertyTax\Collection;

use App\Models\RptAccount;
use App\Models\RptFormulaTable;
use App\Models\RptPercentage;
use App\Models\RptQuarter1;
use App\Models\RptQuarter2;
use App\Models\RptQuarter3;
use App\Models\RptQuarter4;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function PHPUnit\Framework\isNull;

class Accounts213 extends Component
{
    // Search variable
    public $search_option, $search_input, $rptAccountSearch = [];
    // RPT ACCOUNT, ASSESSED VALUE, PAYMENT RECORD
    public $lastPaymentYear, $lastPaymentQuarter,$nextPaymentYear, $nextPaymentQuarter, $UnpaidAmount;
    public $account_data, $account_av_data, $account_av_no_zero_value = null, $account_pr_data, $account_td_data, $all_data;
    public $ai_total_amount_due = 0;

    // NEW AV YEAR, OLD AV YEAR
    public $avYearNew, $avYearOld, $month_selected, $base_percentage;
    // Assessed Value
    public $assessedValueOld;
    public $assessedValueNew;
    public $paymentOption1 = [];
    public $paymentOption2 = [];
    public $tempTaxDues = [];
    public $payment_due_temp = [];
    // Display

    public $viewSearchList = 0;
    public $viewAccountInfo = 0;
    public $viewAssessedValues = 0;
    public $viewPaymentRecords = 0;
    public $viewPaymentUpdated = 0;
    public $viewTaxDue = 0;
    public $pay_option;

    protected $listeners = ['refreshComponent' => '$refresh',
                        'accountPaymentRefresh' => 'accountPaymentRefreshEvent'];
    public function accountPaymentRefreshEvent()
    {
        $this->verify_record($this->account_data->id);
    }

    // 1. Initiate Old AV Year/New AV Year/Search input/Search option/Month Selected
    public function mount()
    {
        $this->pay_option = false;
        $this->input_date = date('Y-m-d');
        $this->avYearNew = date("Y", strtotime($this->input_date));
        $this->avYearOld = $this->avYearNew - 1;
        $this->month_selected = strtolower(date("F", strtotime($this->input_date)));
        $this->search_input = '';
        $this->search_option = 'rpt_pin';
        $this->base_percentage = RptPercentage::get();
        $this->close_display();
    }

    // 2. Search PIN/TD/ARP
    public function search_record()
    {
        if (!empty($this->search_input) && !is_null($this->search_input)) {
            $this->rptAccountSearch = RptAccount::select('id','rpt_pin','rpt_arp_no','rpt_td_no','ro_name','ro_address','rpt_kind','rpt_class','rtdp_payment_covered_year','rtdp_status')
            ->where($this->search_option, 'like', '%' . $this->search_input . '%')->limit(10)->get();
            $this->viewSearchList = 1;
            $this->viewSearchFieldEmpty = 0;
            $this->viewAssessedValues = 0;
            $this->viewPaymentRecords = 0;
            $this->viewTaxDue = 0;
            $this->viewAccountInfo = 0;
        } else {
            $this->close_display();
        }
    }

    public function render()
    {
        return view('livewire.real-property-tax.collection.accounts', [
            'assessed_values' => !is_null($this->account_data) && !empty($this->account_data) ? $this->account_data->assessed_values->where('av_value', '!=', 0) : [],
            'payment_records' => !is_null($this->account_data) && !empty($this->account_data) ? $this->account_data->payment_records : [],
            'payment_dues' => !is_null($this->tempTaxDues) && !empty($this->tempTaxDues) ? $this->tempTaxDues: [],
            'amount_due' => $this->ai_total_amount_due,
            'payment_button' => is_null($this->tempTaxDues) && empty($this->tempTaxDues) ? 'disabled' : '',
        ]);
    }

    // 3. Verify account
    public function verify_record($id)
    {
        $this->viewSearchList = 0;
        $this->account_data = RptAccount::with('assessed_values')->with('payment_records')->find($id);
        if($this->account_data->rtdp_status != 'verified'){
            $this->dispatchBrowserEvent('swalAccountNotVerified');
        }else{
            if (is_null($this->account_data->rtdp_payment_covered_to) || empty($this->account_data->rtdp_payment_covered_to)) {
                $this->dispatchBrowserEvent('swalPaymentYearNotFound');
            }else{
                $this->settingVariables();
                $this->compute_unpaid_amount();
            }
        }
    }


    // Setting up variables
    private function settingVariables(){
        // dd($this->account_data );
        // Remove AV records with zero value
        // $this->account_av_no_zero_value = $this->account_data->assessed_values->where('av_value', '!=', 0);
        // $this->account_av_data = $this->account_data->assessed_values;
        $this->lastPaymentYear = $this->account_data->rtdp_payment_covered_to;
        $this->lastPaymentQuarter = $this->account_data->rtdp_payment_quarter_to;
        $this->nextPaymentYear = $this->lastPaymentYear + (($this->account_data->rtdp_payment_quarter_to >= 1
            || $this->account_data->rtdp_payment_quarter_to == 0) ? 1 : 0);
        $this->nextPaymentQuarter = 1 - $this->lastPaymentQuarter;
        if($this->lastPaymentQuarter > 0 && $this->lastPaymentQuarter < 1){
            $this->UnpaidAmount = $this->account_data->assessed_values->where('av_year_from','>=',$this->lastPaymentYear)->sortBy('av_year_from');
        }else{
            $this->UnpaidAmount = $this->account_data->assessed_values->where('av_year_from','>=',$this->nextPaymentYear)->sortBy('av_year_from');
        }
        $this->assessedValueOld = $this->UnpaidAmount->where('av_year_from','=',$this->avYearOld)->where('av_year_to','=',$this->avYearOld)->first();
        $this->assessedValueNew = $this->UnpaidAmount->where('av_year_from','=',$this->avYearNew)->where('av_year_to','=',$this->avYearNew)->first();
    }

    // 4. Compute unpaid amount
    private function compute_unpaid_amount()
    {
        // dd($this->getQuarterSet()['month_selected']);// [quarter_selected, month_selected]
        // $unpaidComputation = [];
        // $countArray = 0;
        // $result = [];
        // $data = ['av'=>$unpaidArray,'q'=>$quarter,'qd'=>$quarter_data ];
        // dd($unpaidArray);
        if ($this->nextPaymentYear == $this->avYearNew) {
            $taxDue = $this->newAvComputation();
        } elseif($this->nextPaymentYear == $this->avYearOld) {
            // $result = $this->oldAvComputation($countArray);
            // $taxDue = $this->newAvComputation($countArray);
        } else {
            // $result = $this->penaltyComputation($countArray);
            // $resultAvOld = $this->oldAvComputation($countArray);
            // $taxDue = $this->newAvComputation($countArrayAvOld);
        }

        // $this->paymentOption1 = (!empty($taxDue) && !empty($taxDue)) ? $taxDue['unpaid'] : [];
        // $this->payOption2($this->paymentOption1);
        // $this->payment_set($this->paymentOption1);
        // $this->payOption();
        // $this->payment_set( $this->payOption());
        $this->viewAssessedValues = 1;
        $this->viewPaymentRecords = 1;
        $this->viewTaxDue = 1;
        $this->viewAccountInfo = 1;
    }
    // Penalty Computation

    private function newAvComputation()
    {
        // dd(ceil(2/3));
        $unpaidComputation = [];
        $num = 0;
        $unpaidArray = $this->UnpaidAmount;
        // Check if it has quarter
        if ($this->lastPaymentQuarter > 0 && $this->lastPaymentQuarter < 1) {
            $this->penaltyComputationHasQuarter($unpaidArray,$num,$unpaidComputation);//AV, Numbering, Empty Array
        }else{
            $unpaidArray = $this->UnpaidAmount;
            $nextPayYear = $this->nextPaymentYear;
            $nextPayQuarter = $this->nextPaymentQuarter;
            $count = 0;
            $this->newAvLoop($nextPayYear,$count);
        }
        // dd($data,$num,$unpaidComputation,$result);
        $collectedData = collect($data['qd']['quarter_selected']);
        $dataValue = $collectedData->where('year_from','==',$this->nextPaymentYear)->where('year_to','==',$this->nextPaymentYear);
        $this->newAvLoop($ds);
        $nextPaymentYear = $this->nextPaymentYear + 1;

        return ['unpaid'=>$unpaidComputation,'year'=>$nextPaymentYear,'num'=>$num];
    }

    private function penaltyComputationHasQuarter($data,$num,$unpaidComputation) //AV, Numbering, Empty Array
    {
        dd($data);
        $value = $data['av']->where('av_year_from','<=',$this->nextPaymentYear)->where('av_year_to','>=',$this->nextPaymentYear)->first();
            if (is_null($value->av_value) || empty($value->av_value)) {
                return $this->dispatchBrowserEvent('swalUnpaidYearNoValue');
            } else {
                    $get_value = RptFormulaTable::where('year_from', '<=', $value->av_year_from)
                        ->where('year_to', '>=', $value->av_year_to)->first();
                    $unpaidComputation[$num]['count'] = $num;
                    $unpaidComputation[$num]['from'] = $this->nextPaymentYear;
                    $unpaidComputation[$num]['to'] = $unpaidComputation[$num]['from'];
                    $unpaidComputation[$num]['quarter_value'] = $data['q'];
                    $unpaidComputation[$num]['quarter_label'] = $this->getQuarterValue($unpaidComputation[$num]['quarter_value']);
                    $unpaidComputation[$num]['label'] = $unpaidComputation[$num]['from'].' '.$unpaidComputation[$num]['quarter_label'];
                    $unpaidComputation[$num]['year_no'] =  $unpaidComputation[$num]['to'] - $unpaidComputation[$num]['from'] + 1;
                    $unpaidComputation[$num]['percentage'] =  ($get_value[$this->month_selected] / 100);
                    $unpaidComputation[$num]['value'] = $value->av_value * $unpaidComputation[$num]['year_no'] * $data['q'];
                    $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                    $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                    $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                    $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                    $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                    $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                    $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['pen_total'] + $unpaidComputation[$num]['td_total'];
                    $unpaidComputation[$num]['status'] = 2;
                    $nextPaymentYear = $unpaidComputation[$num]['to'] + 1;
            }
            $num++;
        return ['unpaid'=>$unpaidComputation,'year'=>$nextPaymentYear,'num'=>$num];
    }

    private function penaltyComputation()
    {
        dd($data);
        if ($data['q'] < 1 && $data['q'] != 0) {
            $collect = $this->penaltyComputationHasQuarter($data,$num,$unpaidComputation,$result);
        // dd($collect);
            $num = $collect['num'];
            $unpaidComputation = $collect['unpaid'];
            $this->nextPaymentYear = $collect['year'];

            $dataArray = $data['av']->where('av_year_from','>=',$this->nextPaymentYear)
        ->where('av_year_to','<',$this->avYearOld);
        }

        dd($dataArray);
        foreach ($dataArray as $key => $value) {
            if (is_null($value->av_value) || empty($value->av_value)) {
                return $this->dispatchBrowserEvent('swalUnpaidYearNoValue');
            } else {
                if ($this->nextPaymentYear >= $value->av_year_from && $this->nextPaymentYear < $this->avYearOld) {
                    $get_value = RptFormulaTable::where('year_from', '<=', $value->av_year_from)
                        ->where('year_to', '>=', $value->av_year_to)->first();
                    $unpaidComputation[$num]['count'] = $num;
                    $unpaidComputation[$num]['from'] = $this->nextPaymentYear;
                    $unpaidComputation[$num]['to'] = $value->av_year_to;
                    $unpaidComputation[$num]['quarter_value'] = 1;
                    $unpaidComputation[$num]['quarter_label'] = $this->getQuarterValue($unpaidComputation[$num]['quarter_value']);
                    if ($unpaidComputation[$num]['from'] == $unpaidComputation[$num]['to']) {
                        $unpaidComputation[$num]['label'] = $unpaidComputation[$num]['from'].' '.$unpaidComputation[$num]['quarter_label'];
                    } else {
                        $unpaidComputation[$num]['label'] = $unpaidComputation[$num]['from'].'-'. $value->av_year_to.$unpaidComputation[$num]['quarter_label'];
                    }
                    $unpaidComputation[$num]['year_no'] =  $unpaidComputation[$num]['to'] - $unpaidComputation[$num]['from'] + 1;
                    $unpaidComputation[$num]['percentage'] =  ($get_value[$this->month_selected] / 100);
                    $unpaidComputation[$num]['value'] = $value->av_value * $unpaidComputation[$num]['year_no'];
                    $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                    $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                    $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                    $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                    $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                    $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                    $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['pen_total'] + $unpaidComputation[$num]['td_total'];
                    $unpaidComputation[$num]['status'] = 2;
                    $this->nextPaymentYear = $unpaidComputation[$num]['to'] + 1;
                }
            }
            $num++;
        }
        // dd($unpaidComputation);

        return ['unpaid'=>$unpaidComputation,'year'=> $this->nextPaymentYear,'num'=>$num];
    }
    // Old AV Computation
    private function oldAvComputation($data,$num,$unpaidComputation,$result)
    {
        if ($result) {
            // dd($unpaidComputation);
            $unpaidComputation = $result['unpaid'];
            $num = $result['num'];
            $this->nextPaymentYear = $result['year'];

        }else{
            // dd($data, $unpaidComputation);
            if ($data['q'] < 1 && $data['q'] != 0) {
                $collect = $this->penaltyComputationHasQuarter($data,$num,$unpaidComputation,$result);

                $num = $collect['num'];
                $unpaidComputation = $collect['unpaid'];
                $this->nextPaymentYear = $collect['year'];
            }
        }
        // dd($unpaidComputation);
        // dd($unpaidComputation, $this->nextPaymentYear);
        $collectedData = collect($data['qd']['quarter_selected']);
        // dd($collectedData);
        $dataValue = $collectedData->where('year_from','==',$this->nextPaymentYear)->where('year_to','==',$this->nextPaymentYear);
        foreach ($dataValue as $key => $value) {
            // dd($value);
            $unpaidComputation[$num]['count'] = $num;
            $unpaidComputation[$num]['from'] = $value->year_from;
            $unpaidComputation[$num]['to'] = $value->year_to;
            $unpaidComputation[$num]['year_no'] =  $value->year_to - $value->year_from + 1;

            if ($value->bracket_code == 'inc_35') {

                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = '';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = (($this->assessedValueNew->av_value - $this->assessedValueOld->av_value) * 0.35) * $unpaidComputation[$num]['year_no'];
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] + $unpaidComputation[$num]['pen_total'];
                $unpaidComputation[$num]['status'] = 2;
            }
            if ($value->bracket_code == 'tax_due') {

                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q4';
                $unpaidComputation[$num]['label'] = $value->label . ' ' . $unpaidComputation[$num]['from'];
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueOld->av_value;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] + $unpaidComputation[$num]['pen_total'];
                $unpaidComputation[$num]['status'] = 2;
            }
            if ($value->bracket_code == 'inc_70') {

                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = '';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = (($this->assessedValueNew->av_value - $this->assessedValueOld->av_value) * 0.70) * $unpaidComputation[$num]['year_no'];
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] + $unpaidComputation[$num]['pen_total'];
                $unpaidComputation[$num]['status'] = 2;
            }
            $num++;
        }
        $nextPaymentYear = $this->nextPaymentYear + 1;
        // dd( $unpaidComputation);
        return ['unpaid'=>$unpaidComputation,'year'=>$nextPaymentYear,'num'=>$num];
    }
    // New AV Computation





    // 5. Show Tax due
    private function show_tax_due()
    {

    }


    // 6. Show Payment
    public function show_payment()
    {

    }

    public function open_payment()
    {
        $this->all_data;
        $this->emit('openPayment', $this->all_data);
    }

    public function payment_set($tax_due)
    {
        $taxDue = collect($tax_due)->where('status', '!=', 0);
        if (is_null($tax_due) && empty($tax_due)) {
            $this->dispatchBrowserEvent('swalNoPayment');
        } else {
        $total_amount_due = 0;
        $total_tc_basic = 0;
        $total_tc_sef = 0;
        $total_tc_penalty = 0;
            foreach ($taxDue as $key => $value) {
                if ($value['status'] == 2) {
                    $total_tc_basic = $total_tc_basic + $value['td_basic'];
                    $total_tc_sef = $total_tc_sef + $value['td_sef'];
                    $total_tc_penalty = $total_tc_penalty + $value['pen_total'];
                    $total_amount_due = $total_amount_due + $value['amount_due'];
                }
            }
            $this->ai_total_amount_due = $total_amount_due;
            if ($taxDue) {
                // dd($taxDue);
                $this->all_data = [
                    'last_payment_year' => $this->lastPaymentYear,
                    'last_payment_quarter' => $this->lastPaymentQuarter,
                    'total_payment_year' => $taxDue->last()['to'] - $this->lastPaymentYear,
                    'total_payment_quarter' => $taxDue->sum('quarter_value'),
                    'pr_account' => $this->account_data,
                    'pr_year_first' => $taxDue->first()['from'],
                    'pr_quarter_first' => $taxDue->first()['quarter_value'],
                    'pr_payment_first_label' => $taxDue->first()['label'],
                    'pr_year_last' => $taxDue->last()['to'],
                    'pr_quarter_last' => $taxDue->last()['quarter_value'],
                    'pr_payment_last_label' => $taxDue->last()['label'],
                    'pr_covered_year' =>  $taxDue->first()['label'].'-'.$taxDue->last()['label'],
                    'pr_year_no' => $taxDue->last()['to'] - $taxDue->first()['from'] + 1,
                    'pr_tc_basic' => $total_tc_basic,
                    'pr_tc_sef' => $total_tc_sef,
                    'pr_tc_penalty' => $total_tc_penalty,
                    'pr_amount_due' => $total_amount_due
                ];
            }
        }
    }

    // ADDITIONAL PRIVATE FUNCTION


    // CLOSE ALL DISPLAY
    public function close_display(){
        $this->viewSearchList = 0;
        $this->viewSearchFieldEmpty = 1;
        $this->viewAccountInfo = 0;
        $this->viewAssessedValues = 0;
        $this->viewPaymentRecords = 0;
        $this->viewPaymentUpdated = 0;
        $this->viewTaxDue = 0;
    }

    //
    public function payOption()
    {
        $this->pay_option != $this->pay_option;
        $this->tempTaxDues = [];
        if ($this->pay_option == true) {
            $this->tempTaxDues = $this->paymentOption2;
        } else {
            $this->tempTaxDues = $this->paymentOption1;
        }
        return $this->payment_set($this->tempTaxDues);

    }
    public function payOption2($taxdue1)
    {
        // dd($taxdue1);
        $collected = collect($taxdue1);
        $yearStart = $collected->first()['from'];
        $yearEnd = $collected->last()['to'];
        $temp_count = '';
        $temp_from = '';
        $temp_to = '';
        $temp_quarter_value = '';
        $temp_quarter_label = '';
        $temp_label = '';
        $temp_year_no = '';
        $temp_percentage = '';
        $temp_value = '';
        $temp_td_basic = '';
        $temp_td_sef = '';
        $temp_td_total = '';
        $temp_pen_basic = '';
        $temp_pen_sef = '';
        $temp_pen_total = '';
        $temp_amount_due = '';
        $temp_status = '';
        $arrayCount = 0;
        $temp_tempArray = [];
        $temp_year = $yearStart;
        for ($i=$yearStart; $i < $yearEnd + 1; $i++) {
            foreach ($collected->sortBy('from') as $key => $value) {
                if ($i == $value['from'] && $value['from'] == $value['to']) {
                    $temp_count = $value['count'];
                    $temp_from = $i;
                    $temp_to = $i;
                    $temp_quarter_value = $value['quarter_value'];
                    $temp_quarter_label = $value['quarter_label'];
                    $temp_label = $value['label'];
                    $temp_year_no = $value['year_no'];
                    $temp_percentage = $value['percentage'];
                    $temp_value = $value['value'];
                    $temp_td_basic = $value['td_basic'];
                    $temp_td_sef = $value['td_sef'];
                    $temp_td_total = $value['td_total'];
                    $temp_pen_basic = $value['pen_basic'];
                    $temp_pen_sef = $value['pen_sef'];
                    $temp_pen_total = $value['pen_total'];
                    $temp_amount_due = $value['amount_due'];
                    $temp_status = $value['status'];
                }elseif($i == $value['from'] && $value['from'] != $value['to']){
                    // dump($temp_year);
                    $temp_count = $value['count'];
                    $temp_from = $temp_year;
                    $temp_to = $temp_year;
                    $temp_quarter_value = $value['quarter_value'];
                    $temp_quarter_label = $value['quarter_label'];
                    $temp_label = $value['label'];
                    $temp_year_no = 1;
                    $temp_percentage = $value['percentage'];
                    $temp_value = $value['value'] / $value['year_no'];
                    $temp_td_basic = $value['td_basic']/ $value['year_no'];
                    $temp_td_sef = $value['td_sef']/ $value['year_no'];
                    $temp_td_total = $value['td_total']/ $value['year_no'];
                    $temp_pen_basic = $value['pen_basic']/ $value['year_no'];
                    $temp_pen_sef = $value['pen_sef']/ $value['year_no'];
                    $temp_pen_total = $value['pen_total']/ $value['year_no'];
                    $temp_amount_due = $value['amount_due']/ $value['year_no'];
                    $temp_status = $value['status'];
                }else{

                }
            }
            $tempArray[$i]['count'] = $temp_count;
            $tempArray[$i]['from'] = $i;
            $tempArray[$i]['to'] = $i;
            $tempArray[$i]['quarter_value'] = $temp_quarter_value;
            $tempArray[$i]['quarter_label'] = $temp_quarter_label;
            $tempArray[$i]['label'] = $temp_label;
            $tempArray[$i]['year_no'] = $temp_year_no;
            $tempArray[$i]['percentage'] = $temp_percentage;
            $tempArray[$i]['value'] = $temp_value;
            $tempArray[$i]['td_basic'] = $temp_td_basic;
            $tempArray[$i]['td_sef'] = $temp_td_sef;
            $tempArray[$i]['td_total'] = $temp_td_total;
            $tempArray[$i]['pen_basic'] = $temp_pen_basic;
            $tempArray[$i]['pen_sef'] = $temp_pen_sef;
            $tempArray[$i]['pen_total'] = $temp_pen_total;
            $tempArray[$i]['amount_due'] = $temp_amount_due;
            $tempArray[$i]['status'] = $temp_status;
            $arrayCount++;
            $temp_year = $temp_year + 1;
        }
        // dd($tempArray);

        $someArray = [];
        $count = 0;
        $collected = collect($tempArray)->groupBy('from');
        $getFirstDue = $collected->first()[0]['quarter_value'];
        // dd($collected->first()[0]['quarter_value']);
        if ($collected->first()) {
            # code...
        } else {
            # code...
        }
        // dd($taxdue1);
        // dd($collected);
        foreach ($collected as $key => $value) {
            $someArray[$key]['count'] = $count;
            $someArray[$key]['from'] = $value->first()['from'];
            $someArray[$key]['to'] = $value->first()['to'];
            $someArray[$key]['quarter_value'] = $value->first()['quarter_value'];
            $someArray[$key]['quarter_label'] = $value->first()['quarter_label'];;
            $someArray[$key]['label'] = $key;
            $someArray[$key]['year_no'] = 1;
            $someArray[$key]['percentage'] = $value->first()['percentage'];
            $someArray[$key]['value'] = $value->sum('value');
            $someArray[$key]['td_basic'] = $value->sum('td_basic');
            $someArray[$key]['td_sef'] = $value->sum('td_sef');
            $someArray[$key]['td_total'] = $value->sum('td_total');
            $someArray[$key]['pen_basic'] = $value->sum('pen_basic');
            $someArray[$key]['pen_sef'] = $value->sum('pen_sef');
            $someArray[$key]['pen_total'] = $value->sum('pen_total');
            $someArray[$key]['amount_due'] = $value->sum('amount_due');
            $someArray[$key]['status'] = 2;
            $count++;
        }
        $countArray = 0;
        $counter = 0;
        $quarterArray = [];
        $countYear = $collected->last()[0]['from'] - $collected->first()[0]['from'] + 1;


        $quarterArrayFinal = [];
        foreach ($someArray as $key => $value) {
            if ($value['quarter_value'] > 0 && $value['quarter_value'] < 1) {
                switch ($value['quarter_value']) {
                    case 0.25:
                        $initializeBy = 4;// 1
                        $divideBy = 1;// 1
                        $loopBy = 4;//
                        break;
                    case 0.50:
                        $initializeBy = 3;//
                        $divideBy = 2;// 1
                        $loopBy = 4;// 2
                        break;
                    case 0.75:
                        $initializeBy = 2;//
                        $divideBy = 3;// 1
                        $loopBy = 4;// 3
                        break;
                    default:
                        # code...
                        break;
                }
                for ($x = $initializeBy; $x <= $loopBy; $x++) {
                    $quarterArray[$counter]['count'] = $counter;
                    $quarterArray[$counter]['from'] = $value['from'];
                    $quarterArray[$counter]['to'] = $value['to'];
                    $quarterArray[$counter]['quarter_value'] = 0.25;
                    $quarterArray[$counter]['quarter_label'] = 'Quarter '.$x;
                    $quarterArray[$counter]['label'] = $value['from'].' Q'.$x;
                    $quarterArray[$counter]['year_no'] = 'Q'.$x;
                    $quarterArray[$counter]['percentage'] = $value['percentage'];
                    $quarterArray[$counter]['value'] = $value['value']/$divideBy;
                    $quarterArray[$counter]['td_basic'] = $value['td_basic']/$divideBy;
                    $quarterArray[$counter]['td_sef'] = $value['td_sef']/$divideBy;
                    $quarterArray[$counter]['td_total'] = $value['td_total']/$divideBy;
                    $quarterArray[$counter]['pen_basic'] = $value['pen_basic']/$divideBy;
                    $quarterArray[$counter]['pen_sef'] = $value['pen_sef']/$divideBy;
                    $quarterArray[$counter]['pen_total'] = $value['pen_total']/$divideBy;
                    $quarterArray[$counter]['amount_due'] = $value['amount_due']/$divideBy;
                    $quarterArray[$counter]['status'] = 2;
                    $counter++;
                }
            }else{
                for ($x = 1; $x <= 4; $x++) {
                    $quarterArray[$counter]['count'] = $counter;
                    $quarterArray[$counter]['from'] = $value['from'];
                    $quarterArray[$counter]['to'] = $value['to'];
                    $quarterArray[$counter]['quarter_value'] = 0.25;
                    $quarterArray[$counter]['quarter_label'] = 'Quarter '.$x;
                    $quarterArray[$counter]['label'] = $value['from'].' Q'.$x;
                    $quarterArray[$counter]['year_no'] = 'Q'.$x;
                    $quarterArray[$counter]['percentage'] = $value['percentage'];
                    $quarterArray[$counter]['value'] = $value['value']* 0.25;
                    $quarterArray[$counter]['td_basic'] = $value['td_basic']* 0.25;
                    $quarterArray[$counter]['td_sef'] = $value['td_sef']* 0.25;
                    $quarterArray[$counter]['td_total'] = $value['td_total']* 0.25;
                    $quarterArray[$counter]['pen_basic'] = $value['pen_basic']* 0.25;
                    $quarterArray[$counter]['pen_sef'] = $value['pen_sef']* 0.25;
                    $quarterArray[$counter]['pen_total'] = $value['pen_total']* 0.25;
                    $quarterArray[$counter]['amount_due'] = $value['amount_due']* 0.25;
                    $quarterArray[$counter]['status'] = 2;
                    $counter++;
                }
            }
        }
        $countArray++;

        $this->paymentOption2 = $quarterArray;
    }

    public function checkBulk()
    {
    }
    //
    public function checkList($id)
    {
        $taxDue = $this->tempTaxDues;
        foreach ($taxDue as $key => $value) {
            if ($value['count'] == $id) {
                data_set($taxDue[$id], 'status', 2);
            }
        }
        // dd($taxDue);
        $this->payment_due_temp = $taxDue;
        $this->tempTaxDues = $this->payment_due_temp;
        $this->emitSelf('refreshComponent');
        $this->payment_set($taxDue);
    }
    public function uncheckList($id)
    {
        $taxDue = $this->tempTaxDues;
        foreach ($taxDue as $key => $value) {
            if ($value['count'] == $id) {
                data_set($taxDue[$id], 'status', 0);
            }
        }
        // dd($taxDue);
        $this->payment_due_temp = $taxDue;
        $this->emitSelf('refreshComponent');
        $this->tempTaxDues = $this->payment_due_temp;
        $this->payment_set($taxDue);
    }

    // Change date for debug
    public function date_set()
    {
        if (empty($this->search_input)) {
            $this->dispatchBrowserEvent('swalSearchFieldEmpty');
        } else {
            $this->month_selected = strtolower(date("F", strtotime($this->input_date)));
            $this->search_record();
        }
    }

     // Quarter Value
     private function getQuarterValue($quarter)
     {
         switch ($quarter) {
             case 0.25:
                 return "Q4";
                 break;
             case 0.50:
                 return "Q3-Q4";
                 break;
             case 0.75:
                 return "Q2-Q4";
                 break;
             default:
                 return "";
                 break;
         }
     }
     // Set quarterly
     private function getQuarterSet()
     {
         $selectQuarter = date("m", strtotime($this->input_date));
         $month = strtolower(date("F", strtotime($this->input_date)));
         if ($selectQuarter <= 3) {
             $quarter_selected = RptQuarter1::get();
         } elseif ($selectQuarter >= 4 && $selectQuarter <= 6) {
             $quarter_selected = RptQuarter2::get();
         } elseif ($selectQuarter >= 7 && $selectQuarter <= 9) {
             $quarter_selected = RptQuarter3::get();
         } else {
             $quarter_selected = RptQuarter4::get();
         }
         return [
             'quarter_selected' => $quarter_selected,
             'month_selected' => $month
         ];
     }


     // New Assessed Value Loop
     private function newAvLoop($year,$count){
        $collectedData = collect($this->getQuarterSet()['quarter_selected']);
        $dataValue = $collectedData->where('year_from','==',$year)->where('year_to','==',$year);
        $
        $num = $count;
        foreach ($dataValue as $key => $value) {
            $unpaidComputation[$num]['count'] = $num;
            $unpaidComputation[$num]['from'] = $value->year_from;
            $unpaidComputation[$num]['to'] = $value->year_to;
            $unpaidComputation[$num]['year_no'] =  $value->year_to - $value->year_from + 1;
            if ($value->bracket_code == 'new_av') {
                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q4';
                $unpaidComputation[$num]['label'] = $value->label  . ' ' . $unpaidComputation[$num]['from'];
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] = ($unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage']);
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] - $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q1') {

                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q1';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.25;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] + $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q1_q2') {
                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q2';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.50;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] + $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q1_q3') {
                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q3';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.75;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] + $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q2_q4') {
                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q4';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.75;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] - $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q3_q4') {
                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q4';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.50;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] - $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q4') {

                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q4';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.25;;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] - $unpaidComputation[$num]['pen_total'];
            }
            $unpaidComputation[$num]['status'] = 2;
            $num++;
        }
        dd($unpaidComputation);
     }

     // New Assessed Value Loop
     private function newAvLoopQuartely($year,$count){
        $collectedData = collect($this->getQuarterSet()['quarter_selected']);
        $dataValue = $collectedData->where('year_from','==',$year)->where('year_to','==',$year);
        $num = $count;
        foreach ($dataValue as $key => $value) {
            $unpaidComputation[$num]['count'] = $num;
            $unpaidComputation[$num]['from'] = $value->year_from;
            $unpaidComputation[$num]['to'] = $value->year_to;
            $unpaidComputation[$num]['year_no'] =  $value->year_to - $value->year_from + 1;




            if ($value->bracket_code == 'new_av') {
                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q4';
                $unpaidComputation[$num]['label'] = $value->label  . ' ' . $unpaidComputation[$num]['from'];
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] = ($unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage']);
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] - $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q1') {

                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q1';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.25;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] + $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q1_q2') {
                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q2';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.50;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] + $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q1_q3') {
                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q3';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.75;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] + $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q2_q4') {
                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q4';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.75;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] - $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q3_q4') {
                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q4';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.50;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] - $unpaidComputation[$num]['pen_total'];
            }
            if ($value->bracket_code == 'q4') {

                $unpaidComputation[$num]['quarter_value'] = 1;
                $unpaidComputation[$num]['quarter_label'] = 'Q4';
                $unpaidComputation[$num]['label'] = $value->label;
                $unpaidComputation[$num]['percentage'] = ($value[$this->month_selected] / 100);
                $unpaidComputation[$num]['value'] = $this->assessedValueNew->av_value * 0.25;;
                $unpaidComputation[$num]['td_basic'] =  $unpaidComputation[$num]['value'] * 0.01;
                $unpaidComputation[$num]['td_sef'] =  $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['td_total'] =  $unpaidComputation[$num]['td_sef'] + $unpaidComputation[$num]['td_basic'];
                $unpaidComputation[$num]['pen_basic'] =  $unpaidComputation[$num]['td_basic'] * $unpaidComputation[$num]['percentage'];
                $unpaidComputation[$num]['pen_sef'] =  $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['pen_total'] =  $unpaidComputation[$num]['pen_sef'] + $unpaidComputation[$num]['pen_basic'];
                $unpaidComputation[$num]['amount_due'] =  $unpaidComputation[$num]['td_total'] - $unpaidComputation[$num]['pen_total'];
            }
            $unpaidComputation[$num]['status'] = 2;
            $num++;
        }
        dd($unpaidComputation);
     }
}
