<?php

namespace App\Http\Livewire\RealPropertyTax\Collection;

use App\Http\Livewire\Traits\WithPaymentComputation;
use App\Http\Livewire\Traits\WithPercentage;
use App\Models\RptAccount;
use App\Models\RptPercentage;
use App\Models\ListBarangay;
use App\Models\RptBracket;
use Livewire\Component;

class Accounts extends Component
{
    use WithPercentage, WithPaymentComputation;
    ## SEARCH VARIABLE
    public $search_option, $search_input, $input_date, $month_selected;
    ## TYPES OF COMPUTION RESULT
    public $compute_type_a = []; // #COMPUTE BY QUARTER RESULT
    public $compute_type_b = []; // #COMPUTE BY BRACKET RESULT
    public $compute_type_c = []; // #COMPUTE BY YEAR RESULT
    public $compute_type_d = []; // #COMPUTE BY NO PENALTY RESULT
    ## ACCOUNT VARIABLE
    public $account_data;
    public $foundRecords;
    // public $cbt_year = ;
    public $tempTaxDues = [];


    ## RPT ACCOUNT, ASSESSED VALUE, PAYMENT RECORD
    public $lastPaymentYear, $lastPaymentQuarter,$nextPaymentYear, $nextPaymentQuarter, $UnpaidAmount;
    public $account_av_data, $account_av_no_zero_value = null, $account_pr_data=null, $account_td_data=null, $all_data=[ ];
    public $ai_total_amount_due = 0;

    ## NEW AV YEAR, OLD AV YEAR
    ## percentage => array
    ## avYearNew => 2023
    ## baseAvNew => 0.00
    ## avYearOld => 2022
    ## baseAvOld => 0.02

    ## ASSESSED VALUE
    public $assessedValueOld;
    public $assessedValueNew;
    public $paymentOption1 = [];
    public $paymentOption2 = [];
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
    public $resultSelection;
    public $cbt = false;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'verifyRecord' => 'verifyRecordEvent',
        'accountPaymentRefresh' => 'accountPaymentRefreshEvent',
        ];

    public function render()
    {
        return view('livewire.real-property-tax.collection.accounts', [
            'assessed_values' => !is_null($this->account_data) && !empty($this->account_data) ? $this->account_data->assessed_values->where('av_value', '!=', 0)->sortBy('av_year_from') : [],
            // 'payment_records' => !is_null($this->account_data) && !empty($this->account_data) ? $this->account_data->payment_records : [],
            'payment_dues' => !is_null($this->tempTaxDues) && !empty($this->tempTaxDues) ? $this->tempTaxDues: [],
            'amount_due' => $this->ai_total_amount_due,
            'payment_button' => is_null($this->tempTaxDues) && empty($this->tempTaxDues) ? 'disabled' : '',
        ]);
    }

    public function accountPaymentRefreshEvent()
    {
        $this->verify_record($this->account_data->id);
    }


    ## VERIFYING ACCOUNTS FOR COMPUTATION
    public function verify_record($id)
    {
        $this->viewSearchList = 0;
        $account = RptAccount::with('assessed_values')
            ->with('payment_records')->find($id);

            // dd($account);
        $this->account_data = $account;
        ## CHECKING PENALTY PERCENTAGE
        if($account->rtdp_status != 1){
            $this->dispatchBrowserEvent('swalAccountNotVerified');
        }else{
            if (is_null($account->rtdp_payment_covered_to) || empty($account->rtdp_payment_covered_to)) {
                $this->dispatchBrowserEvent('swalPaymentYearNotFound');
            }else{
                  ## Check for new av if exist
                if ($this->checkNewAV($account->assessed_values)) {
                    // $this->settingVariables();
                    $this->viewAccountInfo = 1;
                    $this->viewAssessedValues = 1;
                    $this->viewPaymentRecords = 1;
                    $this->viewTaxDue = 1;
                    $next_payment = $this->getNextPaymentYear($account->rtdp_payment_covered_to,$account->rtdp_payment_quarter_to);
                    ## COMPUTE AND STORE RESULT TO COMPUTE_TYPE_A
                    $this->compute_type_a = $this->startCompute($id,$next_payment,$this->month_selected) ?? [];
                } else {
                    $this->dispatchBrowserEvent('swalNewAssessedValueNotFound');
                }
            }
        }
        // dd($this->compute_type_a);
        $this->tempTaxDues = $this->compute_type_a;
        $this->payment_set($this->tempTaxDues);
        $this->viewTaxDue = 1;


        // if (count($this->compute_type_a) > 0) {
        //     ## COMPUTE FOR COMPUTE_TYPE_B
        //     $this->compute_type_b = $this->computeGroupByYear($this->compute_type_a);
        //     ## COMPUTE FOR COMPUTE_TYPE_C
        //     $this->compute_type_c = $this->computeWithOutPenalty($this->compute_type_a);
        //     $this->tempTaxDues = $this->compute_type_b;
        //     $this->payment_set($this->compute_type_b);

        // }else{
        //     $this->viewTaxDue = 1;
        // }
    }

    ## COMPUTATION BASE ON THE BRACKET
    private function computation_bracket($data){
        $is_type = collect($data)->first()['type'] ?? 0;
        $new_data = ($is_type == 0) ? collect($data) : collect($this->computeGroupByYear($data));
        $percent_val = $this->getPercentageValue($this->month_selected);
        $old_av_year = $percent_val->where('desc','oldav')->first();
        $new_av_year = $old_av_year->from + 1;
        $newComputation = [];
        $c = 0;
        // $brackets = RptBracket::get();

        foreach($this->account_data['assessed_values'] as $av){
            $get_value = $new_data->where('from','>=',$av['av_year_from'])
                        ->where('to','<=',$av['av_year_to']);
            foreach ($get_value as $key => $value) {
                if($value['from'] == $new_av_year && $value['to'] == $new_av_year){
                    switch ($value['quarter_value']) {
                        case 0.25:$bracket_name = $new_av_year." Q1";break;
                        case 0.50:$bracket_name = $new_av_year." Q2";break;
                        case 0.75:$bracket_name = $new_av_year." Q3";break;
                        default:$bracket_name = $new_av_year." Q4";break;
                    }
                }else{
                    switch ($value['quarter_value']) {
                        case 0.35:$bracket_name = "35% INC";break;
                        case 0.7:$bracket_name = "70% INC";break;
                        default:$bracket_name = ($av['av_year_from'] == $av['av_year_to'])
                            ? $av['av_year_from'] : $av['av_year_from'].'-'.$av['av_year_to'];
                        ;break;
                    }
                }
                $newComputation[$c]['bracket'] = $bracket_name;
                $newComputation[$c]['year']=$value['from'];
                // $newComputation[$c]['quarter']=$value['quarter_value'];
                $newComputation[$c]['av']=$value['value'];
                $newComputation[$c]['td_total']= $value['td_total'];
                $newComputation[$c]['pen_total']= ($value['cbt_year'] == true) ? 0 : $value['pen_total'];
                $c++;
            }

        }

        ## CREATE A COLLECTION AND GROUP BY BRACKET
        $newCollection = (collect($newComputation))->groupBy('bracket');
        $b_count = 0;
        $bracket_form_computation = [];
        ## RECONSTRUCT COMPUTATION FOR RECEIPT DATA
        foreach($newCollection as $key => $bracket){
            $bracket_form_computation[$b_count]['av'] = $bracket->first()['av'];
            $bracket_form_computation[$b_count]['td'] = $bracket->first()['td_total'] / 2;
            $bracket_form_computation[$b_count]['year_no'] = $bracket->last()['year'] - $bracket->first()['year'] + 1;
            if ($bracket->first()['year'] == $new_av_year) {
                $bracket_form_computation[$b_count]['label'] = $bracket->first()['bracket'];
            } else {
                $bracket_form_computation[$b_count]['label'] = ($bracket->first()['year'] == $bracket->last()['year']) ?
                    $bracket->first()['year'] : $bracket->first()['year'].'-'.$bracket->last()['year'];
            }
            $bracket_form_computation[$b_count]['total_td'] = $bracket->sum('td_total');
            $bracket_form_computation[$b_count]['penalty'] = $bracket->sum('pen_total');
            $bracket_form_computation[$b_count]['subtotal'] = ($bracket->sum('td_total') + $bracket->sum('pen_total'));
            $b_count++;
        }
        return $bracket_form_computation;
    }

    ## IF NEXT PAYMENT HAS A QUARTER
    public function switchComputeResult(){

        $this->resultSelection =! $this->resultSelection;
        if ($this->resultSelection) {
            $this->tempTaxDues = $this->compute_type_a;
        } else {
            $this->tempTaxDues = $this->compute_type_b;
        }
    $this->payment_set($this->tempTaxDues);
    }

    ## SET COMPUTATION TO PAYMENT
    public function payment_set($request)
    {

        $taxDue = collect($request)->where('status', true);
        // dd($taxDue);
        // $new_bracket = $this->computation_bracket($taxDue);
        // dd($taxDue);
        if(count($taxDue) > 0) {
        ## GETTING FINAL RESULT
        $total_basic = 0;
        $total_penalty = 0;
        $total_amount_due = 0;
        foreach ($taxDue as $key => $value) {
            $total_basic = $total_basic + $value['tax_due'];
            $total_penalty = $total_penalty + ($value['cbt'] ? 0 : $value['penalty']);
            $total_amount_due = $total_amount_due + $value['tax_due']
                    + ($value['cbt'] ? 0 : $value['penalty']);
        }

        $for_from = $taxDue->first()['from'].($taxDue->first()['q_from']);
        $for_to = $taxDue->first()['to'];
        $this->all_data = [
            'bracket_computation' => $taxDue,
            'prev_trn' => $this->account_data->rtdp_or_no,
            'prev_date' => $this->account_data->rtdp_payment_date,
            'prev_for' => $this->getPrevPaymentRecord($this->account_data),
            'province' => 'QUEZON',
            'city' => 'LOPEZ',
            'amount' => $total_amount_due * 2,
            'for' => $taxDue->first()['from'].'-'.$taxDue->last()['to'],
            'owner_name' => $this->account_data->ro_name,
            'location' => (ListBarangay::where('index',$this->account_data->lp_brgy)->first())->name ?? 'Unknown',
            'tdn' => $this->account_data->rpt_pin,
            'rpt_account_id' => $this->account_data->id,
            'pr_year_first' => $taxDue->first()['from'],
            'pr_quarter_first' => $taxDue->first()['q_from'],
            'pr_year_last' => $taxDue->last()['to'],
            'pr_quarter_last' => $taxDue->first()['q_to'],
            'pr_year_no' => $taxDue->last()['to'] - $taxDue->first()['from'] + 1,
            'pr_tc_basic' => $total_basic,
            'pr_tc_sef' => $total_basic,
            'pr_tc_penalty' => $total_penalty,
            'pr_amount_due' => $total_amount_due * 2,
        ];
        }
    }

    ## PRIVATE FUNCTION: AN OPTION TO REMOVE PENALTY
    public function removePenalty()
    {
        $this->cbt =! $this->cbt;
        $taxDue = $this->tempTaxDues;
        $newTaxDue = [];
            foreach ($taxDue as $key => $value) {
                if ($value['status']) {
                    $value['cbt'] = $this->cbt;
                    if ($value['cbt']) {
                        $value['penalty_temp'] = 0;
                        $value['total'] = $value['tax_due'];
                      } else {
                        $value['penalty_temp'] = $value['penalty'];
                        $value['total'] = $value['tax_due'] + $value['penalty'];
                      }
                }
                $newTaxDue[$key] = $value;
            }
        $this->emitSelf('refreshComponent');
        $this->tempTaxDues = $newTaxDue;
        $this->payment_set($this->tempTaxDues);
    }

    ## UNMARKED CHECK THE SELECTED LIST
    public function toggleList($id)
    {
        $taxDue = $this->tempTaxDues;
        $collect = collect($taxDue);
        $get_label = ($collect->where('index',$id)->first())['label'];
        $newTaxDue = [];

        foreach ($taxDue as $key => $value) {
            if($value['index'] == $id){
                $value['status'] = !$value['status'];
            }
            $newTaxDue[$key] = $value;
        }
        $this->emitSelf('refreshComponent');
        $this->tempTaxDues = $newTaxDue;
        $this->payment_set($this->tempTaxDues);
    }

      ## TOGGLE CBR PER YEAR
      public function toggleCbt($id)
      {
          $taxDue = $this->tempTaxDues;
          $newTaxDue = [];
          foreach ($taxDue as $key => $value) {
              if ($value['index'] == $id) {
                  $value['cbt'] = !$value['cbt'];
              }
              if ($value['cbt']) {
                $value['penalty_temp'] = 0;
                $value['total'] = $value['tax_due'];
              } else {
                $value['penalty_temp'] = $value['penalty'];
                $value['total'] = $value['tax_due'] + $value['penalty'];
              }

              $newTaxDue[$key] = $value;
          }
        //   dd($newTaxDue);
          $this->payment_due_temp = $newTaxDue;
          $this->emitSelf('refreshComponent');
          $this->tempTaxDues = $this->payment_due_temp;
          $this->payment_set($this->tempTaxDues);
      }

    public function open_payment()
    {
        // dd($this->all_data);
        $this->emit('openPayment', $this->all_data);
    }


    ############## FINALIZED CODE
    ##############
    ## COMPUTE AND GROUP BY BRACKET
    public function computeGroupByYear($quarter_array)
    {
        $compute_quarter = collect($quarter_array);
        $percent_val = $this->getPercentageValue($this->month_selected);
        $old_av_year = $percent_val->where('desc','oldav')->first();
        $group_by_year = [];
        if (!is_null($compute_quarter) || !empty($compute_quarter)) {
            $count = 0;
            foreach ($compute_quarter->groupBy('type') as $key => $value) {
                $group_by_year[$count]['count'] = $count;
                $group_by_year[$count]['from'] = $value->first()['from'];
                $group_by_year[$count]['to'] = $value->first()['to'];
                // $group_by_year[$count]['quarter_value'] = $value->sum('quarter_value');
                if ($value->first()['from'] == $old_av_year->from) {
                    if ($value->first()['type'] == 'INC35' || $value->first()['type'] == 'INC70') {
                        $group_by_year[$count]['quarter_label'] =  $value->first()['quarter_label'];
                        $group_by_year[$count]['quarter_value'] = $value->first()['quarter_value'];
                    } else {
                        $group_by_year[$count]['quarter_label'] =  $value->first()['from'].' OLD AV';
                        $group_by_year[$count]['quarter_value'] = 1;
                    }
                } elseif($value->first()['from'] == ($old_av_year->from + 1)) {
                    // dump($value);
                    $group_by_year[$count]['quarter_label'] = $value->first()['label'];
                    $group_by_year[$count]['quarter_value'] = $value->first()['quarter_value'];
                } elseif($value->first()['from'] < $old_av_year->from) {

                    if ($value->first()['from'] == $this->nextPaymentYear && $value->first()['quarter_value'] >= 0.25 && $value->first()['quarter_value'] < 1) {
                        $group_by_year[$count]['quarter_label'] = $value->first()['label'].' - '.$value->last()['year_no'];
                        $group_by_year[$count]['quarter_value'] = $value->first()['quarter_value'];
                    } else {
                        $group_by_year[$count]['quarter_label'] = $value->first()['from'];
                        $group_by_year[$count]['quarter_value'] = 1;
                    }
                }

                $group_by_year[$count]['label'] = $group_by_year[$count]['quarter_label'];
                $group_by_year[$count]['year_no'] = 1;
                $group_by_year[$count]['percentage'] = $value->first()['percentage'];
                $group_by_year[$count]['value'] = $value->first()['value'];
                $group_by_year[$count]['td_basic'] = $value->sum('td_basic');
                $group_by_year[$count]['td_sef'] = $value->sum('td_sef');
                $group_by_year[$count]['td_total'] = $value->sum('td_total');
                $group_by_year[$count]['pen_basic'] = $value->sum('pen_basic');
                $group_by_year[$count]['pen_sef'] = $value->sum('pen_sef');
                $group_by_year[$count]['pen_total'] = $value->sum('pen_total');
                $group_by_year[$count]['temp_basic_penalty'] = round($value->sum('temp_basic_penalty'),2);
                $group_by_year[$count]['amount_due'] = $value->sum('amount_due');
                $group_by_year[$count]['status'] = 2;
                $group_by_year[$count]['cbt_year'] = 0;
                $count++;
            }
        }
        return $group_by_year ?? [];

        ## STORE DATA TO GROUP BY YEAR
        // $this->compute_type_c = $group_by_year;
        // $this->computation_bracket($group_by_year);
        // $this->paymentOption1 = $group_by_year;
    }

    ## COMPUTE REMOVE PENALTY
    public function computeWithOutPenalty($array)
    {

    }

    ## INITIALIZE OLD AV YEAR/NEW AV YEAR/SEARCH INPUT/SEARCH OPTION/MONTH SELECTED
    public function mount()
    {
        $this->resultSelection = false;
        $this->input_date = date('Y-m-d');
        $this->month_selected = strtolower(date("F", strtotime($this->input_date)));
        $this->search_input = '';
        $this->search_option = 'rpt_pin';
        $this->displayClose();
    }

    ## TO CLOSE ALL GROUP DISPLAY
    public function displayClose(){
        $this->viewSearchList = 0;
        $this->viewSearchFieldEmpty = 0;
        $this->viewAccountInfo = 0;
        $this->viewAssessedValues = 0;
        $this->viewPaymentRecords = 0;
        $this->viewTaxDue = 0;
        $this->viewPaymentUpdated = 0;
    }

    ## SEARCH ACCOUNT BY PIN, TD OR ARP
    public function searchRecord()
    {
        if (empty($this->search_input) || is_null($this->search_input)) {
            $this->dispatchBrowserEvent('swalSearchFieldEmpty');
            $this->viewSearchFieldEmpty = 1;
            $this->viewSearchList = 0;
        } else {
            $this->resultSelection = false;
            $this->foundRecords = RptAccount::select('id','rpt_pin','rpt_arp_no','rpt_td_no','ro_name','ro_address','rpt_kind','rpt_class','rtdp_payment_covered_year','rtdp_status')
            ->where($this->search_option, 'like', '%' . $this->search_input . '%')->limit(10)->get();
            $this->displayClose();
            $this->viewSearchList = 1;
        }
    }

    ## CHANGING DATE OPTION
    public function setDate()
    {
        (empty($this->search_input)) ?
            $this->dispatchBrowserEvent('swalSearchFieldEmpty') :
            $this->month_selected = strtolower(date("F", strtotime($this->input_date)));
            $this->searchRecord();
    }

    ## GET QUARTER VALUE
    public function getPrevPaymentRecord($acc){
        $payment_date = $acc['rtdp_payment_covered_fr'].' '.$this->convertQuarter($acc['rtdp_payment_quarter_fr'])
            .'-'.$acc['rtdp_payment_covered_to'].' '.$this->convertQuarter($acc['rtdp_payment_quarter_to']);
        return $payment_date;
    }






}

