<?php

namespace App\Http\Livewire\RealPropertyTax\Collection;

use Illuminate\Support\Arr;
use App\Models\RptAccount;
use App\Models\RptFormulaTable;
use App\Models\RptPercentage;
use App\Models\ListBarangay;
use App\Models\RptQuarter1;
use App\Models\RptQuarter2;
use App\Models\RptQuarter3;
use App\Models\RptQuarter4;
use App\Models\RptBracket;
use Livewire\Component;

class Accounts extends Component
{
    ## SEARCH VARIABLE
    public $search_option, $search_input, $rptAccountSearch = [];
    ## RPT ACCOUNT, ASSESSED VALUE, PAYMENT RECORD
    public $lastPaymentYear, $lastPaymentQuarter,$nextPaymentYear, $nextPaymentQuarter, $UnpaidAmount;
    public $account_data, $account_av_data, $account_av_no_zero_value = null, $account_pr_data=null, $account_td_data=null, $all_data=[ ];
    public $ai_total_amount_due = 0;

    ## NEW AV YEAR, OLD AV YEAR
    public $avYearNew, $avYearOld, $month_selected, $base_percentage, $baseAvOld, $baseAvNew;
    ## ASSESSED VALUE
    public $assessedValueOld;
    public $assessedValueNew;
    public $paymentOption1 = [];
    public $paymentOption2 = [];
    public $tempTaxDues = [];
    public $payment_due_temp = [];
    public $bracket_form_computation = [];

    ## DISPLAY
    public $viewSearchList = 1;
    public $viewAccountInfo = 0;
    public $viewAssessedValues = 1;
    public $viewPaymentRecords = 1;
    public $viewPaymentUpdated = 1;
    public $viewSearchFieldEmpty = 1;
    public $viewTaxDue = 1;
    public $viewTaxdue1 = 1;
    public $pay_option;
    public $cbt = false;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'verifyRecord' => 'verifyRecordEvent',
        'accountPaymentRefresh' => 'accountPaymentRefreshEvent',
        ];

    public function accountPaymentRefreshEvent()
    {
        $this->verify_record($this->account_data->id);
    }

    ## INITIALIZE OLD AV YEAR/NEW AV YEAR/SEARCH INPUT/SEARCH OPTION/MONTH SELECTED
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

    ## TO CLOSE ALL GROUP DISPLAY
    public function close_display(){
        $this->viewSearchList = 0;
        $this->viewSearchFieldEmpty = 0;
        $this->viewAccountInfo = 0;
        $this->viewAssessedValues = 0;
        $this->viewPaymentRecords = 0;
        $this->viewTaxDue = 0;
        $this->viewPaymentUpdated = 0;
    }

    ## SEARCH ACCOUNT BY PIN, TD OR ARP
    public function search_record()
    {
        if (empty($this->search_input) || is_null($this->search_input)) {
            $this->dispatchBrowserEvent('swalSearchFieldEmpty');
            $this->viewSearchFieldEmpty = 1;
            $this->viewSearchList = 0;
        } else {
            $this->pay_option = false;
            $this->rptAccountSearch = RptAccount::select('id','rpt_pin','rpt_arp_no','rpt_td_no','ro_name','ro_address','rpt_kind','rpt_class','rtdp_payment_covered_year','rtdp_status')
            ->where($this->search_option, 'like', '%' . $this->search_input . '%')->limit(10)->get();
            $this->close_display();
            $this->viewSearchList = 1;
        }
    }

    public function render()
    {
        return view('livewire.real-property-tax.collection.accounts', [
            'assessed_values' => !is_null($this->account_data) && !empty($this->account_data) ? $this->account_data->assessed_values->where('av_value', '!=', 0)->sortBy('av_year_from') : [],
            'payment_records' => !is_null($this->account_data) && !empty($this->account_data) ? $this->account_data->payment_records : [],
            'payment_dues' => !is_null($this->tempTaxDues) && !empty($this->tempTaxDues) ? $this->tempTaxDues: [],
            'amount_due' => $this->ai_total_amount_due,
            'payment_button' => is_null($this->tempTaxDues) && empty($this->tempTaxDues) ? 'disabled' : '',
        ]);
    }

    ## VERIFYING ACCOUNTS FOR COMPUTATION
    public function verify_record($id)
    {
        $this->viewSearchList = 0;
        $this->account_data = RptAccount::with('assessed_values')
            ->with('payment_records')->find($id);
        dd($this->account_data->assessed_values->sortByDesc('av_year_from')->first());
        if($this->account_data->rtdp_status != 'verified'){
            $this->dispatchBrowserEvent('swalAccountNotVerified');
        }else{
            // dd($this->account_data);
            if (is_null($this->account_data->rtdp_payment_covered_to) || empty($this->account_data->rtdp_payment_covered_to)) {
                $this->dispatchBrowserEvent('swalPaymentYearNotFound');
            }else{
                $this->settingVariables();
                $this->viewAccountInfo = 1;
                $this->viewAssessedValues = 1;
                $this->viewPaymentRecords = 1;
                $this->viewTaxDue = 1;
                $this->compute_unpaid_amount();
            }
        }
    }


    ## INITIALIZE ALL VARIABLES
    private function settingVariables(){
        $this->lastPaymentYear = $this->account_data->rtdp_payment_covered_to;
        $this->lastPaymentQuarter = $this->account_data->rtdp_payment_quarter_to;
        $this->nextPaymentYear = $this->lastPaymentYear + (($this->account_data->rtdp_payment_quarter_to > 0
            && $this->account_data->rtdp_payment_quarter_to < 1) ? 0 : 1);
            if ($this->lastPaymentQuarter > 0 && $this->lastPaymentQuarter < 1) {
                $this->nextPaymentQuarter = 0.25 + $this->lastPaymentQuarter;
            } else {
                $this->nextPaymentQuarter = 1;
            }

        $this->UnpaidAmount = $this->account_data->assessed_values->where('av_year_from','<=',$this->nextPaymentYear)->where('av_year_to','>=',$this->avYearNew)->sortBy('av_year_from');
        $this->assessedValueOld = $this->account_data->assessed_values->where('av_year_from','=',$this->avYearOld)->where('av_year_to','=',$this->avYearOld)->first();
        $this->assessedValueNew = $this->account_data->assessed_values->where('av_year_from','=',$this->avYearNew)->where('av_year_to','=',$this->avYearNew)->first();
        // dd($this->assessedValueNew);
        ## INITIALIZE PENALTY TABLE
        $this->baseAvOld = RptPercentage::select('base')->where('from','<=',$this->avYearOld)
        ->where('to','>=',$this->avYearOld)->first();
        $this->baseAvNew = RptPercentage::select('base')->where('from','<=',$this->avYearNew)
        ->where('to','>=',$this->avYearNew)->first();
    }

    ## COMPUTE THE UNPAID AMOUNT
    private function compute_unpaid_amount()
    {
        $result = [];
        if ($this->nextPaymentYear == $this->avYearNew) {
            $unpaid = [];
            $result = $this->newAvLoop($unpaid);
        } elseif($this->nextPaymentYear == $this->avYearOld){
            $unpaid = [];
                $oldAv35 = $this->oldAvLoop35($unpaid);
                $oldAv = $this->oldAvLoop($oldAv35);
                $oldAv70 = $this->oldAvLoop70($oldAv);
                $result = $this->newAvLoop($oldAv70);
        } elseif($this->nextPaymentYear < $this->avYearOld)  {
            $unpaidQuarter = [];
            $unpaid = $this->regularAvLoop($unpaidQuarter);
            $oldAv35 = $this->oldAvLoop35($unpaid);
            $oldAv = $this->oldAvLoop($oldAv35);
            $oldAv70 = $this->oldAvLoop70($oldAv);
            $result = $this->newAvLoop($oldAv70);
        }else{
            $this->dispatchBrowserEvent('swalPaymentIsUpdated');
        }
        if (count($result) > 0) {
            $this->paymentOption2 = $result;
            $this->computation2($result);
            $this->payment_set($result);
            $this->tempTaxDues = $this->paymentOption1;
        }else{
            $this->viewTaxDue = 0;
        }
    }

    ## COMPUTATION BASE ON THE BRACKET
    private function computation_bracket($data){
        $newComputation = [];
        $c = 0;
        $brackets = RptBracket::get();
        foreach($data as $com){
            $c++;
            foreach($brackets as $b){
                if($b->year_from <= $com['from'] && $b->year_to >= $com['to']) {
                    // $newComputation[$c] = ($com['quarter_value'] == 0.35)
                    if($com['from'] == $this->avYearNew && $com['to'] == $this->avYearNew){
                        switch ($com['quarter_value']) {
                            case 0.25:$newComputation[$c]['bracket']=$this->avYearNew." Q1";
                                break;
                            case 0.50:$newComputation[$c]['bracket']=$this->avYearNew." Q2";
                                break;
                            case 0.75:$newComputation[$c]['bracket']=$this->avYearNew." Q3";
                                break;
                            default:$newComputation[$c]['bracket']=$this->avYearNew." Q4";
                                break;
                        }
                    }else{
                        switch ($com['quarter_value']) {
                            case 0.35:$newComputation[$c]['bracket']="35% INC";
                                break;
                            case 0.70:$newComputation[$c]['bracket']="70% INC";
                                break;
                            default:$newComputation[$c]['bracket']=$b->label;
                                break;
                        }
                    }
                    //     $newComputation[$c]['label'] = $newComputation[$c]['bracket'];
                    // }else{
                    //     $newComputation[$c]['bracket']=$b->label;
                    //     if ($com['from'] == $com['to']) {
                    //         $newComputation[$c]['label'] = $com['to'];
                    //     } else {
                    //         $newComputation[$c]['label'] = $com['from'].'-'.$com['to'];
                    //     }

                    // }
                    $newComputation[$c]['year']=$com['from'];
                    $newComputation[$c]['quarter']=$com['quarter_value'];
                    $newComputation[$c]['av']=$com['value'];
                    $newComputation[$c]['td_total']=$com['td_total'];
                    $newComputation[$c]['pen_total']=$com['pen_total'];
                }
            }
        }
        ## CREATE A COLLECTION AND GROUP BY BRACKET
        $newCollection = (collect($newComputation))->groupBy('bracket');
        $b_count = 0;
        ## RECONSTRUCT COMPUTATION FOR RECEIPT DATA
        foreach($newCollection as $key => $bracket){
            $this->bracket_form_computation[$b_count]['av'] = $bracket->first()['av'];
            $this->bracket_form_computation[$b_count]['td'] = $bracket->first()['td_total'] / 2;
            $this->bracket_form_computation[$b_count]['year_no'] = $bracket->last()['year'] - $bracket->first()['year'] + 1;
            if ($this->bracket_form_computation[$b_count]['year_no'] > 1) {
                $this->bracket_form_computation[$b_count]['label'] = $bracket->first()['year'].'-'.$bracket->last()['year'];
            } else {
                $this->bracket_form_computation[$b_count]['label'] = $bracket->first()['bracket'];
            }
            $this->bracket_form_computation[$b_count]['total_td'] = $bracket->sum('td_total') / 2;
            $this->bracket_form_computation[$b_count]['penalty'] = $bracket->sum('pen_total') / 2;
            $this->bracket_form_computation[$b_count]['subtotal'] = ($bracket->sum('td_total') + $bracket->sum('pen_total')) / 2;
            $b_count++;
        }
        // dd($this->bracket_form_computation);
    }

    private function computation2($data){
        $collect = collect($data);
        $this->payOption2($collect);
    }

    ## IF NEXT PAYMENT HAS A QUARTER
    public function payOption(){

        $this->pay_option =! $this->pay_option;
        if ($this->pay_option) {
            $this->tempTaxDues = $this->paymentOption2;
        } else {
            $this->tempTaxDues = $this->paymentOption1;
        }
        $this->payment_set($this->tempTaxDues);

    }

    ## SET COMPUTATION TO PAYMENT
    public function payment_set($request)
    {
        // dd('Payment is set');
        // dump($this->account_data);
        $taxDue = collect($request)->where('status', '!=', 0);
        $this->computation_bracket($taxDue);
        if (is_null($request) && empty($request)) {
            $this->dispatchBrowserEvent('swalNoPayment');
        } else {
        $total_amount_due = 0;
        $total_tc_basic = 0;
        $total_tc_sef = 0;
        $total_tc_penalty = 0;
        $temp_basic_penalty = 0;
            foreach ($taxDue as $key => $value) {
                if ($value['status'] == 2) {
                    $total_tc_basic = $total_tc_basic + $value['td_basic'];
                    $total_tc_sef = $total_tc_sef + $value['td_sef'];
                    $total_tc_penalty = $total_tc_penalty + $value['pen_total'];
                    $temp_basic_penalty = $temp_basic_penalty + ($value['temp_basic_penalty']*2);
                    $total_amount_due = $total_amount_due + $value['amount_due'];
                }
            }
            // $this->ai_total_amount_due = (round($total_amount_due/2,2)*2);
            $this->ai_total_amount_due = round($total_amount_due,2);
            if (count($taxDue) > 0) {
                $payment_first_label = '';
                $payment_last_label = '';
                if ($taxDue->first()['quarter_value'] == 0.35) {
                    $payment_quarter_first = 0.25;
                    $payment_first_label = $taxDue->first()['from'].' Q1';
                } else {
                    $payment_quarter_first = $taxDue->first()['quarter_value'];
                    $payment_first_label = $taxDue->first()['label'];
                }

                if ($taxDue->last()['quarter_value'] == 0.7) {
                    $payment_quarter_last = 1.0;
                    $payment_last_label = $taxDue->last()['to'].' Q4';
                } else {
                    $payment_quarter_last = $taxDue->last()['quarter_value'];
                    $payment_last_label = $taxDue->last()['label'];
                }
                $this->all_data = [
                    'bracket_computation' => $this->bracket_form_computation,
                    'prev_trn' => $this->account_data->rtdp_or_no,
                    'prev_date' => $this->account_data->rtdp_payment_date,
                    'prev_for' => $this->getPrevPaymentRecord($this->account_data),
                    'province' => 'QUEZON',
                    'city' => 'LOPEZ',
                    'amount' => $this->ai_total_amount_due,
                    'for' => $payment_first_label.'-'.$payment_last_label,
                    'owner_name' => $this->account_data->ro_name,
                    'location' => (ListBarangay::where('index',$this->account_data->lp_brgy)->first())->name,
                    'tdn' => $this->account_data->rpt_pin,
                    'rpt_account_id' => $this->account_data->id,
                    'pr_year_first' => $taxDue->first()['from'],
                    'pr_quarter_first' => $this->convertQuarter($payment_quarter_first),
                    'pr_year_last' => $taxDue->last()['to'],
                    'pr_quarter_last' => $this->convertQuarter($payment_quarter_last),
                    'pr_year_no' => $taxDue->last()['to'] - $taxDue->first()['from'] + 1,
                    'pr_tc_basic' => $total_tc_basic,
                    'pr_tc_sef' => $total_tc_sef,
                    'pr_tc_penalty' => $total_tc_penalty,
                    'pr_amount_due' => $this->ai_total_amount_due,
                ];
            }
        }
    }

    ## PRIVATE FUNCTION: AN OPTION TO REMOVE PENALTY
    public function removePenalty()
    {
        $this->cbt =! $this->cbt;
        $taxDue = $this->tempTaxDues;
        $newTaxDue = [];
            foreach ($taxDue as $key => $value) {
                if ($value['status'] == 2) {
                    if ($this->cbt == true) {
                        $value['amount_due'] = ($value['td_total']);
                        $value['temp_basic_penalty'] = ($value['td_total']);
                    } else {
                        $value['amount_due'] = $value['td_total']+$value['pen_total'];
                        $value['temp_basic_penalty'] = $value['td_total']+$value['pen_total'];
                    }
                }
                $newTaxDue[$key] = $value;
            }
        // dd($newTaxDue);
        $this->payment_set($newTaxDue);
    }

    ## MARKED CHECK THE SELECTED LIST
    public function checkList($id)
    {
        $taxDue = $this->tempTaxDues;
        $newTaxDue = [];
        foreach ($taxDue as $key => $value) {
            if ($value['count'] <= $id) {
                $value['status'] = 2;
            }
            $newTaxDue[$key] = $value;
        }
        $this->payment_due_temp = $newTaxDue;
        $this->tempTaxDues = $this->payment_due_temp;
        $this->emitSelf('refreshComponent');
        $this->payment_set($this->tempTaxDues);
    }

    ## UNMARKED CHECK THE SELECTED LIST
    public function uncheckList($id)
    {
        $taxDue = $this->tempTaxDues;
        $collect = collect($taxDue);
        $is35 = ($collect->where('count',$id)->first())['quarter_value'];
        $newTaxDue = [];
        if ($is35 == 0.35) {
            foreach ($taxDue as $key => $value) {
                if($value['count'] == $id){
                    $value['status'] = 0;
                }
                $newTaxDue[$key] = $value;
            }
        } else {
            foreach ($taxDue as $key => $value) {
                if($value['count'] >= $id){
                    $value['status'] = 0;
                }
                $newTaxDue[$key] = $value;
            }
        }
        // dd($newTaxDue);
        $this->payment_due_temp = $newTaxDue;
        $this->emitSelf('refreshComponent');
        $this->tempTaxDues = $this->payment_due_temp;
        $this->payment_set($this->tempTaxDues);
    }

    public function open_payment()
    {

        // dd($this->bracket_form_computation);
        $this->emit('openPayment', $this->all_data);
    }

    ## CHANGING DATE OPTION
    public function date_set()
    {
        (empty($this->search_input)) ?
            $this->dispatchBrowserEvent('swalSearchFieldEmpty') :
            $this->month_selected = strtolower(date("F", strtotime($this->input_date)));
            $this->search_record();
    }


     // Set quarterly
    //  private function getQuarterSet()
    //  {
    //      $selectQuarter = date("m", strtotime($this->input_date));
    //      $month = strtolower(date("F", strtotime($this->input_date)));

    //      dd(ceil(($month/3)));// to get quater

    //      if ($selectQuarter <= 3) {
    //          $quarter_selected = RptQuarter1::get();
    //      } elseif ($selectQuarter >= 4 && $selectQuarter <= 6) {
    //          $quarter_selected = RptQuarter2::get();
    //      } elseif ($selectQuarter >= 7 && $selectQuarter <= 9) {
    //          $quarter_selected = RptQuarter3::get();
    //      } else {
    //          $quarter_selected = RptQuarter4::get();
    //      }
    //      return [
    //          'quarter' => $quarter_selected,
    //          'month' => $month
    //      ];
    //  }


      ## REGULAR ASSESSED VALUE LOOP
      private function regularAvLoop($unpaidQuarter){
        $quarterArray = ($unpaidQuarter) ? $unpaidQuarter : [];
        $counter = ($quarterArray) ? count($quarterArray) : 0;
        $month = date("m", strtotime($this->input_date));
        // $quarter = round(ceil(($month/3)));

        $countDiff =  $this->avYearOld - $this->nextPaymentYear;
        $payYear = $this->nextPaymentYear;

        for ($i=0; $i < $countDiff; $i++) {
            $a_value = $this->account_data->assessed_values
                ->where('av_year_from','<=',$payYear)
                ->where('av_year_to','>=',$payYear)->first();
            $penalty = RptPercentage::select('base')
                ->where('from','<=',$payYear)
                ->where('to','>=',$payYear)->first();
            $num = ($this->lastPaymentQuarter > 0 && $this->lastPaymentQuarter < 1)
                ? ((12*$this->lastPaymentQuarter)/3)+1 : 1;
            for ($x = $num; $x <= 4; $x++) {
                $quarterArray[$counter]['count'] = $counter;
                $quarterArray[$counter]['type'] = 'Q'.$payYear;
                $quarterArray[$counter]['from'] = $payYear;
                $quarterArray[$counter]['to'] = $payYear;
                $quarterArray[$counter]['quarter_value'] = 0.25 * $x;
                $quarterArray[$counter]['quarter_label'] = 'Quarter '.$x;
                $quarterArray[$counter]['label'] = $quarterArray[$counter]['from'].' Q'.$x;
                $quarterArray[$counter]['year_no'] = 'Q'.$x;
                $quarterArray[$counter]['percentage'] = (($penalty->base >= 72) ? 0.72 : (($penalty->base+($month * 2)-2)/100));
                $quarterArray[$counter]['value'] = $a_value->av_value;
                $quarterArray[$counter]['td_basic'] = ($a_value->av_value * 0.25) * 0.01;
                $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
                $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] * 2;
                $quarterArray[$counter]['pen_basic'] = $quarterArray[$counter]['td_basic']  * $quarterArray[$counter]['percentage'];
                $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
                $quarterArray[$counter]['pen_total'] =$quarterArray[$counter]['pen_basic'] * 2;
                $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_basic'])*2;
                $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
                $quarterArray[$counter]['status'] = 2;
                $counter++;
            }
            $payYear++;
            $this->lastPaymentQuarter = 0;
            $this->nextPaymentQuarter = 0;
        }
        return $quarterArray;
     }
     // 35% INCREASE
     private function oldAvLoop35($unpaid){
        $quarterArray = ($unpaid) ? $unpaid : [];
        $counter = ($quarterArray) ? count($quarterArray) : 0;
        $month = date("m", strtotime($this->input_date));
        $quarter = round(ceil(($month/3)));
        $penalty = RptPercentage::select('base')->where('from','<=',($this->avYearOld - 1))
        ->where('to','>=',($this->avYearOld - 1))->first();

        for ($x = 1; $x <= 1; $x++) {
            $quarterArray[$counter]['count'] = $counter;
            $quarterArray[$counter]['type'] = 'INC35';
            $quarterArray[$counter]['from'] = $this->avYearOld;
            $quarterArray[$counter]['to'] = $this->avYearOld;
            $quarterArray[$counter]['quarter_value'] = 0.35;
            $quarterArray[$counter]['quarter_label'] = '35% INC';
            $quarterArray[$counter]['label'] = $quarterArray[$counter]['quarter_label'];
            $quarterArray[$counter]['year_no'] = 1;
            $quarterArray[$counter]['percentage'] = ($this->baseAvOld->base+($month * 2)-2)/100;;
            $quarterArray[$counter]['value'] = ($this->assessedValueNew->av_value - $this->assessedValueOld->av_value)* 0.35;
            $quarterArray[$counter]['td_basic'] = $quarterArray[$counter]['value'] * 0.01;
            $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
            $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['td_sef'];
            $quarterArray[$counter]['pen_basic'] = $quarterArray[$counter]['td_basic']  * $quarterArray[$counter]['percentage'];
            $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['pen_total'] =$quarterArray[$counter]['pen_basic'] + $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_basic'])*2;
            $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
            $quarterArray[$counter]['status'] = 2;
            $counter++;
        }
        return $quarterArray;

     }
      ## OLD ASSESSED VALUE LOOP
      private function oldAvLoop($unpaid){
        $quarterArray = ($unpaid) ? $unpaid : [];
        $counter = ($quarterArray) ? count($quarterArray) : 0;
        $month = date("m", strtotime($this->input_date));
        $quarter = round(ceil(($month/3)));

        $num = ($this->lastPaymentQuarter > 0 && $this->lastPaymentQuarter < 1) ? ((12*$this->lastPaymentQuarter)/3)+1 : 1;

        for ($x = $num; $x <= 4; $x++) {
            $quarterArray[$counter]['count'] = $counter;
            $quarterArray[$counter]['type'] = 'Q'.$this->avYearOld;
            $quarterArray[$counter]['from'] = $this->avYearOld;
            $quarterArray[$counter]['to'] = $this->avYearOld;
            $quarterArray[$counter]['quarter_value'] = 0.25 * $x;
            $quarterArray[$counter]['quarter_label'] = 'Quarter '.($x-1);
            $quarterArray[$counter]['label'] = $quarterArray[$counter]['from'].' Q'.$x;
            $quarterArray[$counter]['year_no'] = 'Q'.($x);
            $quarterArray[$counter]['percentage'] = ($this->baseAvOld->base+($month * 2)-2)/100;
            $quarterArray[$counter]['value'] = $this->assessedValueOld->av_value * 0.25;
            $quarterArray[$counter]['td_basic'] = $quarterArray[$counter]['value'] * 0.01;
            $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
            $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['td_sef'];
            $quarterArray[$counter]['pen_basic'] = $quarterArray[$counter]['td_basic']  * $quarterArray[$counter]['percentage'];
            $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['pen_total'] =$quarterArray[$counter]['pen_basic'] + $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_basic'])*2;
            $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
            // $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['td_total'] + $quarterArray[$counter]['pen_total'];
            $quarterArray[$counter]['status'] = 2;
            $counter++;
        }
        $this->lastPaymentQuarter = 0;
        $this->nextPaymentQuarter = 0;
        return $quarterArray;
     }
      ## OLD ASSESSED VALUE LOOP
      private function oldAvLoop70($unpaid){
        $quarterArray = ($unpaid) ? $unpaid : [];
        $counter = ($quarterArray) ? count($quarterArray) : 0;
        $month = date("m", strtotime($this->input_date));

        for ($x = 1; $x <= 1; $x++) {
            $quarterArray[$counter]['count'] = $counter;
            $quarterArray[$counter]['type'] = 'INC70';
            $quarterArray[$counter]['from'] = $this->avYearOld;
            $quarterArray[$counter]['to'] = $this->avYearOld;
            $quarterArray[$counter]['quarter_value'] = 0.70;
            $quarterArray[$counter]['quarter_label'] = '70% INC';
            $quarterArray[$counter]['label'] = $quarterArray[$counter]['quarter_label'];
            $quarterArray[$counter]['year_no'] = 1;
            $quarterArray[$counter]['percentage'] = ($this->baseAvOld->base+($month * 2)-2)/100;
            $quarterArray[$counter]['value'] = ($this->assessedValueNew->av_value - $this->assessedValueOld->av_value)* 0.70;
            $quarterArray[$counter]['td_basic'] = $quarterArray[$counter]['value'] * 0.01;
            $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
            $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['td_sef'];
            $quarterArray[$counter]['pen_basic'] = $quarterArray[$counter]['td_basic']  * $quarterArray[$counter]['percentage'];
            $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['pen_total'] =$quarterArray[$counter]['pen_basic'] + $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_basic'])*2;
            $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
            // $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['td_total'] + $quarterArray[$counter]['pen_total'];
            $quarterArray[$counter]['status'] = 2;
            $counter++;
        }
        return $quarterArray;
     }


     ## NEW ASSESSED VALUE LOOP
     private function newAvLoop($oldAv){

        // dd($oldAv);
        $quarterArray = (($oldAv) ? $oldAv : []);
        $counter = (($oldAv) ? count($oldAv) : 0);
        // $counter = (is_null($oldAv) ? );
        $month = date("m", strtotime($this->input_date));
        $quarter = round(ceil(($month/3)));

        $num = ($this->lastPaymentQuarter > 0 && $this->lastPaymentQuarter < 1) ? ((12*$this->lastPaymentQuarter)/3)+1 : 1;

        for ($x = $num; $x <= 4; $x++) {
            $quarterArray[$counter]['count'] = $counter;
            $quarterArray[$counter]['type'] = 'Q'.$x.'('.$this->avYearNew.')';
            $quarterArray[$counter]['from'] = $this->avYearNew;
            $quarterArray[$counter]['to'] = $this->avYearNew;
            $quarterArray[$counter]['quarter_value'] = 0.25*$x;
            $quarterArray[$counter]['quarter_label'] = 'Quarter '.$x;
            $quarterArray[$counter]['label'] = $quarterArray[$counter]['from'].' Q'.$x;
            $quarterArray[$counter]['year_no'] = 'Q'.$x;
            $quarterArray[$counter]['percentage'] = ($x < $quarter ? ($this->baseAvOld->base+($month * 2)-2)/100 : $this->baseAvNew->base/100);
            $quarterArray[$counter]['value'] = $this->assessedValueNew->av_value * 0.25;
            $quarterArray[$counter]['td_basic'] = $quarterArray[$counter]['value'] * 0.01;
            $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
            $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['td_sef'];
            $quarterArray[$counter]['pen_basic'] = ($quarterArray[$counter]['td_basic'] * $quarterArray[$counter]['percentage']) * ($x < $quarter ? 1 : -1);
            $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['pen_total'] =($quarterArray[$counter]['pen_basic'] +  $quarterArray[$counter]['pen_sef']);
            $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_basic'])*2;
            $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
            // $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['td_total'] + $quarterArray[$counter]['pen_total'];
            $quarterArray[$counter]['status'] = 2;
            $counter++;
        }

        return $quarterArray;
     }


    //  Search component
    public function searchRecordEvent($input, $option){
        $this->rptAccountSearch = RptAccount::select('id','rpt_pin','rpt_arp_no','rpt_td_no','ro_name','ro_address','rpt_kind','rpt_class','rtdp_payment_covered_year','rtdp_status')
            ->where($option, 'like', '%' . $input . '%')->limit(10)->get();
    }

    public function payOption2($data)
    {
        $someArray = [];
        if (!is_null($data) || !empty($data)) {
            $count = 0;
            foreach ($data->groupBy('type') as $key => $value) {
                $someArray[$count]['count'] = $count;
                $someArray[$count]['from'] = $value->first()['from'];
                $someArray[$count]['to'] = $value->first()['to'];
                // $someArray[$count]['quarter_value'] = $value->sum('quarter_value');
                if ($value->first()['from'] == $this->avYearOld) {
                    if ($value->first()['type'] == 'INC35' || $value->first()['type'] == 'INC70') {
                        $someArray[$count]['quarter_label'] =  $value->first()['quarter_label'];
                        $someArray[$count]['quarter_value'] = $value->first()['quarter_value'];
                    } else {
                        $someArray[$count]['quarter_label'] =  $value->first()['from'].' OLD AV';
                        $someArray[$count]['quarter_value'] = 1;
                    }
                } elseif($value->first()['from'] == $this->avYearNew) {
                    // dump($value);
                    $someArray[$count]['quarter_label'] = $value->first()['label'];
                    $someArray[$count]['quarter_value'] = $value->first()['quarter_value'];
                } elseif($value->first()['from'] < $this->avYearOld) {

                    if ($value->first()['from'] == $this->nextPaymentYear && $value->first()['quarter_value'] >= 0.25 && $value->first()['quarter_value'] < 1) {
                        $someArray[$count]['quarter_label'] = $value->first()['label'].' - '.$value->last()['year_no'];
                        $someArray[$count]['quarter_value'] = $value->first()['quarter_value'];
                    } else {
                        $someArray[$count]['quarter_label'] = $value->first()['from'];
                        $someArray[$count]['quarter_value'] = 1;
                    }
                }

                $someArray[$count]['label'] = $someArray[$count]['quarter_label'];
                $someArray[$count]['year_no'] = 1;
                $someArray[$count]['percentage'] = $value->first()['percentage'];
                $someArray[$count]['value'] = $value->first()['value'];
                $someArray[$count]['td_basic'] = $value->sum('td_basic');
                $someArray[$count]['td_sef'] = $value->sum('td_sef');
                $someArray[$count]['td_total'] = $value->sum('td_total');
                $someArray[$count]['pen_basic'] = $value->sum('pen_basic');
                $someArray[$count]['pen_sef'] = $value->sum('pen_sef');
                $someArray[$count]['pen_total'] = $value->sum('pen_total');
                $someArray[$count]['temp_basic_penalty'] = round($value->sum('temp_basic_penalty'),2);
                $someArray[$count]['amount_due'] = $value->sum('amount_due');
                $someArray[$count]['status'] = 2;
                $count++;
            }
        }
        $this->computation_bracket($someArray);
        $this->paymentOption1 = $someArray;
    }

    ## GET QUARTER VALUE
    public function getPrevPaymentRecord($acc){
        $payment_date = $acc['rtdp_payment_covered_fr'].' '.$this->convertQuarter($acc['rtdp_payment_quarter_fr'])
            .'-'.$acc['rtdp_payment_covered_to'].' '.$this->convertQuarter($acc['rtdp_payment_quarter_to']);
        return $payment_date;
    }

    ## CONVERT QUARTER VALUE
    public function convertQuarter($value)
    {
        switch ($value) {
            case 0.25: return 'Q1';
            case 0.50: return 'Q2';
            case 0.75: return 'Q3';
            default: return 'Q4'; break;
        }
    }

}

