<?php

namespace App\Http\Livewire\RealPropertyTax\Collection;

use App\Models\RptAccount;
use App\Models\RptAssessedValue;
use App\Models\RptFormulaTable;
use App\Models\RptPaymentRecord;
use App\Models\RptQuarter1;
use App\Models\RptQuarter2;
use App\Models\RptQuarter3;
use App\Models\RptQuarter4;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Accounts234 extends Component
{
    public $input_pin = '015-06-030-02-013', $input_td = null, $rpt_account_exist = false, $show_av = false, $payment_status = null, $account_id = null;
    // public $input_pin = null, $input_td = null, $rpt_account_exist = false, $show_av = false, $payment_status = null, $account_id = null;
    public $input_date, $year_today, $assessed_value_last = 0;
    public $ai_kind, $ai_class, $ai_owner, $ai_address, $ai_assessed_value, $ai_total_amount_due = 0;
    public $payment_teller, $payment_date, $payment_or, $payment_amount_due, $payment_directory, $payment_remarks, $payment_paid = 0, $payment_balance = 0, $payment_cash = 0, $payment_change = 0, $payment_quarter = 4;
    public $account_info = "";
    public $payment_record_table = [];
    public $payment_due_table = [];
    public $payment_due_temp = [];
    public $count_value = '';
    public $month_today;
    public $array_temp = [1, 2, 3];

    public $rpt_account_arr = [];
    public $rpt_av_arr = [];
    public $rpt_pr_arr = [];

    public $display_av = false;
    public $display_pr = false;
    public $display_search_notif = false;
    public $display_tax_due = true;
    public $display_amount_due = false;
    public $display_updated_payment_notif = false;

    // Search variable
    public $search_option, $search_input;
    // RPT ACCOUNT, ASSESSED VALUE, PAYMENT RECORD
    public $account_data, $account_av_data, $account_av_no_zero_value = null, $account_pr_data, $account_td_data, $all_data;
    // NEW AV YEAR, OLD AV YEAR
    public $year_av_new, $year_av_old, $month_selected, $value_av_new, $value_av_old, $value_av_old_1;

    protected $listeners = ['accountPaymentRefresh' => 'accountPaymentRefreshEvent'];

    public function accountPaymentRefreshEvent()
    {
        $this->search_record();
    }

    public function mount()
    {
        $this->search_input = '';
        $this->account_td_data = null;
        $this->search_option = 'rpt_pin';
        $this->input_date = date('Y-m-d');
        $this->month_selected = strtolower(date("F", strtotime($this->input_date)));
        $this->year_av_new = date("Y", strtotime($this->input_date));
        $this->year_av_old = $this->year_av_new - 1;
        // $this->year_today = date('Y');
        $user = auth()->user(); //getting the current logged in user
        // dd($user); // and so on
    }

    public function open_payment()
    {
        $this->emit('openPayment', $this->all_data);
    }

    // Find RPT Account
    public function search_record()
    {
        $this->display_av = false;
        $this->display_pr = false;
        if (empty($this->search_input)) {
            return $this->dispatchBrowserEvent('swalSearchFieldEmpty');
        } else {
            $this->account_data = RptAccount::where($this->search_option, $this->search_input)->first();
            if (is_null($this->account_data)) {
                $this->dispatchBrowserEvent('swalRecordNotFound');
            } elseif (is_null($this->account_data->rtdp_payment_covered_to) || empty($this->account_data->rtdp_payment_covered_to)) {
                $this->dispatchBrowserEvent('swalPaymentYearNotFound');
            } else {
                $all_account_av_data = RptAssessedValue::where('av_pin', $this->account_data->rpt_pin)
                    ->orderBy('av_year_from', 'asc')->get();
                // Remove AV records with zero value
                $this->account_av_no_zero_value = $all_account_av_data->where('av_value', '!=', 0);
                $this->account_av_data = $all_account_av_data;
                if (count($this->account_av_data) <= 0) {
                    return $this->dispatchBrowserEvent('swalAssessedValueNotFound');
                } else {
                    $this->display_av = true;
                    $this->account_pr_data = RptPaymentRecord::where('pr_rpt_pin', $this->account_data->rpt_pin)
                        ->orderBy('pr_year_from', 'asc')->get();
                    $this->compute_tax_due($this->account_av_data, $this->account_pr_data);
                }
            }
        }
    }

    private function compute_tax_due($av_data, $pr_data)
    {
        if (count($pr_data) > 0) {
            $this->display_pr = true;
        }
        if ($this->account_data->rtdp_payment_covered_to) {
            $payment_year = $this->account_data->rtdp_payment_covered_to;
            $payment_quarter = $this->account_data->rtdp_payment_quarter_to;
            if ($payment_year > $this->year_av_new) {
                $this->account_td_data = null;
                $this->display_updated_payment_notif = true;
            } else {
                if ($payment_quarter == 1 || $payment_quarter == 0) {
                    $next_pay_year = $payment_year + 1;
                    $this->account_td_data = $this->getUnpaidData($av_data, $next_pay_year, $payment_quarter);
                } else {
                    $next_pay_year = $payment_year;
                    $this->account_td_data = $this->getUnpaidData($av_data, $next_pay_year, $payment_quarter);
                }
            }
        } else {
            $this->dispatchBrowserEvent('swalPaymentYearNotFound');
            // if (count($pr_data) > 0) {
            //     // dump
            //     if ($pr_data->last()->pr_year_to >= $this->year_av_new) {
            //         // dd('ok');
            //         $this->account_td_data = null;
            //         $this->display_updated_payment_notif = true;
            //     } else {
            //         $next_pay_year = $pr_data->last()->pr_year_to + 1;
            //         $this->account_td_data = $this->getUnpaidData($av_data, $next_pay_year);
            //     }
            // } else {
            //     $next_pay_year = $av_data->where('av_value', '!=', 0)->first()->av_year_from;
            //     $this->account_td_data = $this->getUnpaidData($av_data, $next_pay_year);
            // }
        }
    }

    private function getUnpaidData($av_data, $next_pay_year, $payment_quarter)
    {
        // dd($next_pay_year);
        if ($next_pay_year > $this->year_av_new) {
            // dd('advance payment option');
        } else {
            return $this->computeTaxDue($av_data, $next_pay_year, $payment_quarter);
        }
    }
    // OLD AV COMPUTATION
    private function computeTaxDue($assessed_value, $pay_year, $pay_quarter)
    {
        // dd($pay_year);

        $av_filtered = $assessed_value->where('av_value', '!=', 0);

        // GET OLD AV & NEW AV
        foreach ($av_filtered as $key => $value) {
            if ($value->av_year_from == $this->year_av_old && $value->av_year_to == $this->year_av_old) {
                $this->value_av_old = $value->av_value;
            }
            if ($value->av_year_from == $this->year_av_new && $value->av_year_to == $this->year_av_new) {
                $this->value_av_new = $value->av_value;
            }
        }
        // Set data to Quarterset
        $this->payment_due_temp = $this->quarterSet($pay_year, $av_filtered, $pay_quarter);

        // Set data to Payment_set
        $this->payment_set($this->payment_due_temp);
        return $this->payment_due_temp;
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

    public function listed($id)
    {
        $payment_due_temp = $this->account_td_data;
        foreach ($payment_due_temp as $key => $value) {
            if ($value['count'] == $id) {
                data_set($payment_due_temp[$id], 'status', 1);
            }
        }
        // dd($payment_due_temp);
        $this->payment_due_temp = $payment_due_temp;
        $this->account_td_data = $this->payment_due_temp;
        $this->payment_set($payment_due_temp);
    }

    public function unlisted($id)
    {
        $payment_due_temp = $this->account_td_data;
        foreach ($payment_due_temp as $key => $value) {
            if ($value['count'] == $id) {
                data_set($payment_due_temp[$id], 'td_basic', 0);
                data_set($payment_due_temp[$id], 'td_sef', 0);
                data_set($payment_due_temp[$id], 'td_total', 0);
                data_set($payment_due_temp[$id], 'pen_basic', 0);
                data_set($payment_due_temp[$id], 'pen_sef', 0);
                data_set($payment_due_temp[$id], 'pen_total', 0);
                data_set($payment_due_temp[$id], 'amount_due', 0);
                data_set($payment_due_temp[$id], 'status', 0);
            }
        }
        $this->payment_due_temp = $payment_due_temp;
        $this->account_td_data = $this->payment_due_temp;
        $this->payment_set($payment_due_temp);
    }

    public function date_set()
    {
        if (empty($this->search_input)) {
            $this->dispatchBrowserEvent('swalSearchFieldEmpty');
        } else {
            $this->month_selected = strtolower(date("F", strtotime($this->input_date)));
            $this->search_record();
        }
    }

    public function payment_set($tax_due)
    {
        $collected = collect($tax_due)->where('status', '!=', 0);
        $total_amount_due = 0;
        $total_tc_basic = 0;
        $total_tc_sef = 0;
        $total_tc_penalty = 0;
        foreach ($collected as $key => $value) {
            if ($value['status'] == 2) {
                $total_tc_basic = $total_tc_basic + $value['td_basic'];
                $total_tc_sef = $total_tc_sef + $value['td_sef'];
                $total_tc_penalty = $total_tc_penalty + $value['pen_total'];
                $total_amount_due = $total_amount_due + $value['amount_due'];
            }
        }

        $this->ai_total_amount_due = $total_amount_due;
        // $this->all_data = $collected->toArray();
        $this->all_data = [
            'pr_account' => $this->account_data,
            'pr_year_first' => $collected->first()['from'],
            'pr_quarter_first' => $collected->first()['quarter_value'],
            'pr_year_last' => $collected->last()['to'],
            'pr_quarter_last' => $collected->last()['quarter_value'],
            'pr_covered_year' =>  $collected->first()['from'] . ' ' . $collected->first()['quarter_label'] . '-' . $collected->last()['to'] . ' ' . $collected->last()['quarter_label'],
            'pr_year_no' => $collected->last()['to'] - $collected->first()['from'] + 1,
            'pr_tc_basic' => $total_tc_basic,
            'pr_tc_sef' => $total_tc_sef,
            'pr_tc_penalty' => $total_tc_penalty,
            'pr_amount_due' => $total_amount_due
        ];
    }


    private function quarterSet($pay_year, $av_filtered, $pay_quarter)
    {
        // dd($pay_year);
        // Initiate variable to zero value
        $num = 0;
        // To get values on formula table
        $formula_table = RptFormulaTable::get();
        // To get quater of the month
        $quarter_data = $this->getQuarterSet();
        //To get next pay quarter
        $pay_quarter_new = 1 - $pay_quarter;
        // To get av of next pay year
        $pay_year_av = $av_filtered->where('av_year_from', '<=', $pay_year)->where('av_year_to', '>=', $pay_year)->first();

        switch ($pay_quarter_new) {
            case 0.25:
                $q_from = "Q4";
                break;
            case 0.50:
                $q_from = "Q3-Q4";
                break;
            case 0.75:
                $q_from = "Q2-Q4";
                break;
            default:
                $q_from = "";
                break;
        }
        // dump('new year AV: ' . $this->year_av_new);
        // dump('YEAR: ' . $pay_year);
        // dump('QUARTER: ' . $q_from);
        // dump('AV: ' . ($pay_year_av->av_value * $pay_quarter_new));
        // dd($av_filtered->toArray());

        if ($pay_year <= $this->year_av_new) {
            if (!empty($q_from) && $pay_year != $this->year_av_new) {
                $get_value = $formula_table
                    ->where('year_from', '<=', $pay_year)
                    ->where('year_to', '>=', $pay_year)
                    ->first();
                // dd($get_value);
                $unpaid_year_data[$num]['count'] = $num;
                $unpaid_year_data[$num]['from'] = $pay_year;
                $unpaid_year_data[$num]['to'] = $pay_year;
                $unpaid_year_data[$num]['quarter_value'] = $pay_quarter_new;
                $unpaid_year_data[$num]['quarter_label'] = $q_from;
                $unpaid_year_data[$num]['label'] = $pay_year . ' ' . $q_from;
                $unpaid_year_data[$num]['year_no'] =  1;
                $unpaid_year_data[$num]['percentage'] =  ($get_value[$this->month_selected] / 100);
                $unpaid_year_data[$num]['value'] = $pay_year_av->av_value * $pay_quarter_new;
                $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['pen_total'] + $unpaid_year_data[$num]['td_total'];
                $unpaid_year_data[$num]['status'] = 2;
                $pay_year = $unpaid_year_data[$num]['to'] + 1;
            }
            foreach ($av_filtered as $key => $value) {
                if ($value->av_year_from >= $pay_year && $value->av_year_to < $this->year_av_old) {
                    $get_value = $formula_table
                        ->where('year_from', '<=', $value->av_year_from)
                        ->where('year_to', '>=', $value->av_year_to)
                        ->first();
                    $unpaid_year_data[$num]['count'] = $num;
                    $unpaid_year_data[$num]['from'] = $pay_year;
                    $unpaid_year_data[$num]['to'] = $value->av_year_to;
                    if ($unpaid_year_data[$num]['from'] == $unpaid_year_data[$num]['to']) {
                        $unpaid_year_data[$num]['quarter_value'] = 1;
                        $unpaid_year_data[$num]['quarter_label'] = 'Q4';
                        $unpaid_year_data[$num]['label'] = $unpaid_year_data[$num]['from'];
                    } else {
                        $unpaid_year_data[$num]['quarter_value'] = 1;
                        $unpaid_year_data[$num]['quarter_label'] = 'Q4';
                        $unpaid_year_data[$num]['label'] = $unpaid_year_data[$num]['from'] . '-' . $unpaid_year_data[$num]['to'];
                    }
                    $unpaid_year_data[$num]['year_no'] =  $value->av_year_to - $pay_year + 1;
                    $unpaid_year_data[$num]['percentage'] =  ($get_value[$this->month_selected] / 100);
                    $unpaid_year_data[$num]['value'] = $value->av_value * $unpaid_year_data[$num]['year_no'];
                    $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                    $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                    $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                    $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                    $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                    $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                    $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['pen_total'] + $unpaid_year_data[$num]['td_total'];
                    $unpaid_year_data[$num]['status'] = 2;
                    $pay_year = $unpaid_year_data[$num]['to'] + 1;
                } elseif ($value->av_value == 0) {
                    return $this->dispatchBrowserEvent('swalUnpaidYearNoValue');
                } else {
                }
                $num++;
            }
            // dump($this->year_av_new);

            foreach ($quarter_data['quarter_selected'] as $key => $value) {
                if ($pay_year < $this->year_av_new) {
                    $pay_year = $value->year_from;
                }
                // dump($value);
                $unpaid_year_data[$num]['count'] = $num;
                $unpaid_year_data[$num]['from'] = $value->year_from;
                $unpaid_year_data[$num]['to'] = $value->year_to;
                $unpaid_year_data[$num]['year_no'] =  $value->year_to - $value->year_from + 1;

                if ($pay_year < $this->year_av_new) {
                    if ($value->bracket_code == 'inc_35') {

                        $unpaid_year_data[$num]['quarter_value'] = 1;
                        $unpaid_year_data[$num]['quarter_label'] = '';
                        $unpaid_year_data[$num]['label'] = $value->label;
                        $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                        $unpaid_year_data[$num]['value'] = (($this->value_av_new - $this->value_av_old) * 0.35) * $unpaid_year_data[$num]['year_no'];
                        $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                        $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                        $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] + $unpaid_year_data[$num]['pen_total'];
                    }
                    if ($value->bracket_code == 'tax_due') {

                        $unpaid_year_data[$num]['quarter_value'] = 1;
                        $unpaid_year_data[$num]['quarter_label'] = 'Q4';
                        $unpaid_year_data[$num]['label'] = $value->label . ' ' . $unpaid_year_data[$num]['from'];
                        $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                        $unpaid_year_data[$num]['value'] = $this->value_av_old;
                        $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                        $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                        $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] + $unpaid_year_data[$num]['pen_total'];
                    }
                    if ($value->bracket_code == 'inc_70') {

                        $unpaid_year_data[$num]['quarter_value'] = 1;
                        $unpaid_year_data[$num]['quarter_label'] = '';
                        $unpaid_year_data[$num]['label'] = $value->label;
                        $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                        $unpaid_year_data[$num]['value'] = (($this->value_av_new - $this->value_av_old) * 0.70) * $unpaid_year_data[$num]['year_no'];
                        $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                        $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                        $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] + $unpaid_year_data[$num]['pen_total'];
                    }
                }
                if ($pay_year == $this->year_av_new) {
                    // if ($value->bracket_code == 'q1') {

                    //     $unpaid_year_data[$num]['quarter_value'] = 0.25;
                    //     $unpaid_year_data[$num]['quarter_label'] = 'Q1';
                    //     $unpaid_year_data[$num]['label'] = $value->label;
                    //     $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                    //     $unpaid_year_data[$num]['value'] = $this->value_av_new * 0.25;
                    //     $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                    //     $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                    //     $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                    //     $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                    //     $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                    //     $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                    //     $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] + $unpaid_year_data[$num]['pen_total'];
                    // }
                    // if ($value->bracket_code == 'q2') {

                    //     $unpaid_year_data[$num]['quarter_value'] = 0.25;
                    //     $unpaid_year_data[$num]['quarter_label'] = 'Q2';
                    //     $unpaid_year_data[$num]['label'] = $value->label;
                    //     $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                    //     $unpaid_year_data[$num]['value'] = $this->value_av_new * 0.25;
                    //     $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                    //     $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                    //     $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                    //     $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                    //     $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                    //     $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                    //     $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] + $unpaid_year_data[$num]['pen_total'];
                    // }
                    // if ($value->bracket_code == 'q3') {

                    //     $unpaid_year_data[$num]['quarter_value'] = 0.25;
                    //     $unpaid_year_data[$num]['quarter_label'] = 'Q3';
                    //     $unpaid_year_data[$num]['label'] = $value->label;
                    //     $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                    //     $unpaid_year_data[$num]['value'] = $this->value_av_new * 0.25;
                    //     $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                    //     $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                    //     $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                    //     $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                    //     $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                    //     $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                    //     $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] + $unpaid_year_data[$num]['pen_total'];
                    // }
                    // if ($value->bracket_code == 'q4') {

                    //     $unpaid_year_data[$num]['quarter_value'] = 0.25;
                    //     $unpaid_year_data[$num]['quarter_label'] = 'Q4';
                    //     $unpaid_year_data[$num]['label'] = $value->label;
                    //     $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                    //     $unpaid_year_data[$num]['value'] = $this->value_av_new * 0.25;
                    //     $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                    //     $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                    //     $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                    //     $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                    //     $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                    //     $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                    //     $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] + $unpaid_year_data[$num]['pen_total'];
                    // }

                    if ($value->bracket_code == 'new_av') {
                        $unpaid_year_data[$num]['quarter_value'] = 1;
                        $unpaid_year_data[$num]['quarter_label'] = 'Q4';
                        $unpaid_year_data[$num]['label'] = $value->label  . ' ' . $unpaid_year_data[$num]['from'];
                        $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                        $unpaid_year_data[$num]['value'] = $this->value_av_new;
                        $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                        $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['pen_basic'] = ($unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage']);
                        $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] - $unpaid_year_data[$num]['pen_total'];
                    }
                    if ($value->bracket_code == 'q1') {

                        $unpaid_year_data[$num]['quarter_value'] = 0.25;
                        $unpaid_year_data[$num]['quarter_label'] = 'Q1';
                        $unpaid_year_data[$num]['label'] = $value->label;
                        $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                        $unpaid_year_data[$num]['value'] = $this->value_av_new * 0.25;
                        $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                        $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                        $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] + $unpaid_year_data[$num]['pen_total'];
                    }
                    if ($value->bracket_code == 'q1_q2') {
                        $unpaid_year_data[$num]['quarter_value'] = 0.50;
                        $unpaid_year_data[$num]['quarter_label'] = 'Q2';
                        $unpaid_year_data[$num]['label'] = $value->label;
                        $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                        $unpaid_year_data[$num]['value'] = $this->value_av_new * 0.50;
                        $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                        $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                        $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] + $unpaid_year_data[$num]['pen_total'];
                    }
                    if ($value->bracket_code == 'q1_q3') {
                        $unpaid_year_data[$num]['quarter_value'] = 0.75;
                        $unpaid_year_data[$num]['quarter_label'] = 'Q3';
                        $unpaid_year_data[$num]['label'] = $$value->label;
                        $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                        $unpaid_year_data[$num]['value'] = $this->value_av_new * 0.75;
                        $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                        $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                        $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] + $unpaid_year_data[$num]['pen_total'];
                    }
                    if ($value->bracket_code == 'q2_q4') {

                        $unpaid_year_data[$num]['quarter_value'] = 1;
                        $unpaid_year_data[$num]['quarter_label'] = 'Q4';
                        $unpaid_year_data[$num]['label'] = $value->label;
                        $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                        $unpaid_year_data[$num]['value'] = $this->value_av_new * 0.75;
                        $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                        $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                        $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] - $unpaid_year_data[$num]['pen_total'];
                    }
                    if ($value->bracket_code == 'q3_q4') {
                        // dump('ok');
                        $unpaid_year_data[$num]['quarter_value'] = 1;
                        $unpaid_year_data[$num]['quarter_label'] = 'Q4';
                        $unpaid_year_data[$num]['label'] = $value->label;
                        $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                        $unpaid_year_data[$num]['value'] = $this->value_av_new * 0.50;
                        $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                        $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                        $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] - $unpaid_year_data[$num]['pen_total'];
                    }
                    if ($value->bracket_code == 'q4') {

                        $unpaid_year_data[$num]['quarter_value'] = 1;
                        $unpaid_year_data[$num]['quarter_label'] = 'Q4';
                        $unpaid_year_data[$num]['label'] = $value->label;
                        $unpaid_year_data[$num]['percentage'] = ($value[$this->month_selected] / 100);
                        $unpaid_year_data[$num]['value'] = $this->value_av_new * 0.25;;
                        $unpaid_year_data[$num]['td_basic'] =  $unpaid_year_data[$num]['value'] * 0.01;
                        $unpaid_year_data[$num]['td_sef'] =  $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['td_total'] =  $unpaid_year_data[$num]['td_sef'] + $unpaid_year_data[$num]['td_basic'];
                        $unpaid_year_data[$num]['pen_basic'] =  $unpaid_year_data[$num]['td_basic'] * $unpaid_year_data[$num]['percentage'];
                        $unpaid_year_data[$num]['pen_sef'] =  $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['pen_total'] =  $unpaid_year_data[$num]['pen_sef'] + $unpaid_year_data[$num]['pen_basic'];
                        $unpaid_year_data[$num]['amount_due'] =  $unpaid_year_data[$num]['td_total'] - $unpaid_year_data[$num]['pen_total'];
                    }
                }
                $unpaid_year_data[$num]['status'] = 2;
                $num++;
                // dump($value->bracket_code);
                // dump( $unpaid_year_data);
                // dump($pay_year);
            }
        }
        // dd($unpaid_year_data);

        $filtered_data = collect($unpaid_year_data)->where('value', '!=', 0);
        return $filtered_data->toArray();
    }

    public function render()
    {


        return view('livewire.real-property-tax.collection.accounts', [
            'rptAccountSearch' => RptAccount::where($this->search_option, 'like', '%' . $this->search_input . '%')->limit(20)->get(),
            'assessed_values' => $this->account_av_no_zero_value,
            'payment_records' => $this->account_pr_data,
            'payment_dues' => $this->account_td_data,
            'amount_due' => $this->ai_total_amount_due,
        ]);
    }
}
