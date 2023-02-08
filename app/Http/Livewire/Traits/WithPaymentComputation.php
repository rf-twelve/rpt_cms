<?php

namespace App\Http\Livewire\Traits;

use App\Models\RptAssessedValue;
use App\Models\RptBracket;
use App\Models\RptPercentage;
use Illuminate\Support\Arr;

trait WithPaymentComputation
{
    use WithConvertValue;
    ## GET NEEDED DATA
        ## 1.Last payment(year,quarter)
        public function getNextPaymentYear($year,$quarter){
            if($quarter >= 0.25 && $quarter <= 0.75){
                return ['pay_year'=>$year, 'pay_quarter'=>$quarter+0.25];
            }else{
                return ['pay_year'=>$year+1, 'pay_quarter'=>0.25];
            }
        }
        ## 2.Assessed values(year_from,year_to,av)
        public function getAssessedValuesFromNextPayment($id,$payment)
        {
            ## Find assessed value by account id
            $av = RptAssessedValue::select('av_year_from','av_year_to','av_value')
                ->where('rpt_account_id',$id)
                ->where('av_year_to','>=', $payment['pay_year'])
                ->get()->toArray();

            ## Create array for final computation
            $dataArray = [];
            foreach($av as $index => $item){
                $dataArray[$index]['label'] = $this->getLabelname($item['av_year_from'], $item['av_year_to'],$payment);
                $dataArray[$index]['av_from'] = $item['av_year_from'];
                $dataArray[$index]['av_to'] = $item['av_year_to'];
                $dataArray[$index]['value'] = $item['av_value'];
            }
            return $dataArray;
        }
        ## 3.Percentage(year,value)
        Public function getPercentageValue($month){
            return RptPercentage::select('from','to','desc',$month.' as value')->get();
        }

    ## To check for new av value
    private function checkNewAV($assessedValue){
        $newAvyear = (RptPercentage::select('year')->where('desc','oldav')->first())->year + 1;
        return $assessedValue->where('av_year_from',$newAvyear)->where('av_year_to',$newAvyear)->count();
    }

    ## To get name for label
    ## $a|av_year_from, $b|av_year_to', $c|payment['pay_year]
    private function getLabelname($a, $b, $c){
        ## Assume that year a & b are not equal
        if($c['pay_year'] >= $a && $c['pay_year'] <= $b){
            if($c['pay_quarter'] >= 0.25 && $c['pay_quarter'] <= 0.75){
                return $c['pay_year'].' '.$this->convertQuarter($c['pay_quarter']).'-'.$b.' '.$this->convertQuarter(1);;
            }else{ return $a.'-'.$b; }
        }else{
            if($a == $b) { return $a; }
        }

    }

    ## Param acount_id and next_payment[year,quarter]
    private function startCompute($id,$next_payment,$month)
    {
        $avs = $this->getAssessedValuesFromNextPayment($id,$next_payment);
        $brackets = RptBracket::query()
                ->select(
                    'year_from as from',
                    'year_to as to',
                    'year_no',
                    'label',
                    $month.' as value',
                    'av_percent',

                )->get();
        $year_old_av = ($brackets->where('label','Tax due 2021')->first())->from;

        $var_array = [
            'next_pay_year' => $next_payment['pay_year'],
            'next_pay_quarter' => $next_payment['pay_quarter'],
            'old_av_year' => $year_old_av,
            'new_av_year' => $year_old_av + 1,
            'assessed_values' => $avs,
            'brackets' => $brackets->where('to','>=',$next_payment['pay_year'])->toArray(),
        ];
        if ($next_payment['pay_year'] > $brackets->last()->from) {
            $this->dispatchBrowserEvent('swalPaymentIsUpdated');
        } else {
            return $this->regularCompute($var_array);
        }


    }

    ## Regular computation below old av
    public function regularCompute($var_array)
    {
        $last_pay_quarter = $var_array['next_pay_quarter'] - 0.25;
        $brackets_coll = collect($var_array['brackets']);
        $av_coll = collect($var_array['assessed_values']);
        $payYear = $var_array['next_pay_year'];
        $payQuarter = $var_array['next_pay_quarter'];
        $count = 0;
        // $countDiff =  $var_array['old_av_year'] - $var_array['next_pay_year'];

        foreach ($var_array['brackets'] as $key => $bracket) {
            $check_inc = ($bracket['label'] == '35% of increase'
                || $bracket['label'] == '70% of increase') ? true : false;
            $av_found = $av_coll->where('av_from','>=',$bracket['from'])
                ->where('av_to','<=',$bracket['to'])->first();
            if ($check_inc == true){
                $av_new = $av_coll->where('av_from','>=',$bracket['from']+1)
                ->where('av_to','<=',$bracket['to']+1)->first();
                $av_value = (($av_new['value'] - $av_found['value'])*0.01)*$bracket['av_percent'];
            }else{
                $av_value = $av_found['value'] * 0.01;
            }

            $quarterArray[$key]['index'] = $key;
            $quarterArray[$key]['label'] = $bracket['year_no']<=1 ? $bracket['label'] : $bracket['label'].'('.$bracket['year_no'].')';
            $quarterArray[$key]['from'] = $payYear;
            $quarterArray[$key]['to'] = $bracket['to'];
            $quarterArray[$key]['q_from'] = $payQuarter;
            $quarterArray[$key]['q_to'] = 1;
            $quarterArray[$key]['year_no'] = $bracket['to'] - $payYear + 1;
            $quarterArray[$key]['av'] = $av_value;
            $quarterArray[$key]['tax_due'] = $quarterArray[$key]['av'] *  $quarterArray[$key]['year_no'];
            $quarterArray[$key]['penalty'] = round(($quarterArray[$key]['tax_due'] * $bracket['value']),2);
            $quarterArray[$key]['penalty_temp'] = $quarterArray[$key]['penalty'];
            $quarterArray[$key]['total'] = ($quarterArray[$key]['tax_due'] + $quarterArray[$key]['penalty'] );
            $quarterArray[$key]['status'] = true;
            $quarterArray[$key]['cbt'] = false;

            if ($bracket['label'] == '35% of increase' || $bracket['label'] == 'Tax due 2021') {
                $payYear = $bracket['to'];
            }else{
                $payYear = $bracket['to']+1;
            }
            $payQuarter = 0.25;
        }
        return $quarterArray;
    }

    ## OLD AV 35% COMPUTATION
    private function oldAv35($unpaid, $var_array){
        // dd($var_array);
        $percentages = collect($var_array['percentages'])->where('desc','inc35')->first();
        $col_av = collect($var_array['assessed_values']);
        $new_av = $col_av->where('av_from',$var_array['new_av_year'])
                ->where('av_to',$var_array['new_av_year'])->first();
        $old_av = $col_av->where('av_from',$var_array['old_av_year'])
                ->where('av_to',$var_array['old_av_year'])->first();
        $quarterArray = ($unpaid) ? $unpaid : [];
        $counter = ($quarterArray) ? count($quarterArray) : 0;
            $quarterArray[$counter]['count'] = $counter;
            $quarterArray[$counter]['type'] = 'INC35';
            $quarterArray[$counter]['from'] = $var_array['old_av_year'];
            $quarterArray[$counter]['to'] = $var_array['old_av_year'];
            $quarterArray[$counter]['quarter_value'] = 0.35;
            $quarterArray[$counter]['quarter_label'] = '35% INC';
            $quarterArray[$counter]['label'] = $quarterArray[$counter]['quarter_label'];
            $quarterArray[$counter]['year_no'] = 1;
            $quarterArray[$counter]['percentage'] = $percentages['value'];
            $quarterArray[$counter]['value'] = ($new_av['value'] - $old_av['value'])* 0.35;
            $quarterArray[$counter]['td_basic'] = $quarterArray[$counter]['value'] * 0.01;
            $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
            $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['td_sef'];
            $quarterArray[$counter]['pen_basic'] = $quarterArray[$counter]['td_basic'] * $quarterArray[$counter]['percentage'];
            $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['pen_total'] =$quarterArray[$counter]['pen_basic'] + $quarterArray[$counter]['pen_sef'];
            $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_basic'])*2;
            $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
            $quarterArray[$counter]['status'] = 2;
            $quarterArray[$counter]['cbt_year'] = 0;
        return $quarterArray;
     }
     ## OLD AV COMPUTATION
     private function oldAvCompute($unpaid, $var_array){
        // dd($var_array);
        $percentages = collect($var_array['percentages'])->where('desc','oldav')->first();
        $old_av = collect($var_array['assessed_values'])->where('av_from',$var_array['old_av_year'])
                ->where('av_to',$var_array['old_av_year'])->first();
        $quarterArray = ($unpaid) ? $unpaid : [];
        $counter = ($quarterArray) ? count($quarterArray) : 0;

        // $last_pay_quarter = $var_array['next_pay_quarter'] - 0.25;
        $last_pay_quarter = $var_array['next_pay_quarter'] - 0.25;

        $num = ($last_pay_quarter >= 0.25 && $last_pay_quarter <= 0.75)
                ? ((12*$last_pay_quarter)/3)+1 : 1;

        for ($x = $num; $x <= 4; $x++) {
            $quarterArray[$counter]['count'] = $counter;
            $quarterArray[$counter]['type'] = 'Q'.$var_array['old_av_year'];
            $quarterArray[$counter]['from'] = $var_array['old_av_year'];
            $quarterArray[$counter]['to'] = $var_array['old_av_year'];
            $quarterArray[$counter]['quarter_value'] = 0.25 * $x;
            $quarterArray[$counter]['quarter_label'] = 'Quarter '.$x;
            $quarterArray[$counter]['label'] = $quarterArray[$counter]['from'].' Q'.$x;
            $quarterArray[$counter]['year_no'] = 'Q'.($x);
            $quarterArray[$counter]['percentage'] = $percentages['value'];
            $quarterArray[$counter]['value'] = $old_av['value'] * 0.25;
            $quarterArray[$counter]['td_basic'] = round($quarterArray[$counter]['value'] * 0.01,2);
            $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
            $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['td_sef'];
            $quarterArray[$counter]['pen_basic'] = $quarterArray[$counter]['td_basic'] * $quarterArray[$counter]['percentage'];
            $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['pen_total'] =$quarterArray[$counter]['pen_basic'] + $quarterArray[$counter]['pen_sef'];
            $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_sef'])*2;
            $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
            // $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['td_total'] + $quarterArray[$counter]['pen_total'];
            $quarterArray[$counter]['status'] = 2;
            $quarterArray[$counter]['cbt_year'] = 0;
            $counter++;
        }
        // dd($quarterArray);
        return $quarterArray;
     }
     ## OLD AV 70% COMPUTATION
    private function oldAv70($unpaid, $var_array){
        $percentages = collect($var_array['percentages'])->where('desc','inc70')->first();
        $col_av = collect($var_array['assessed_values']);
        $new_av = $col_av->where('av_from',$var_array['new_av_year'])
                ->where('av_to',$var_array['new_av_year'])->first();
        $old_av = $col_av->where('av_from',$var_array['old_av_year'])
                ->where('av_to',$var_array['old_av_year'])->first();
        $quarterArray = ($unpaid) ? $unpaid : [];
        $counter = ($quarterArray) ? count($quarterArray) : 0;

            $quarterArray[$counter]['count'] = $counter;
            $quarterArray[$counter]['type'] = 'INC70';
            $quarterArray[$counter]['from'] = $var_array['old_av_year'];
            $quarterArray[$counter]['to'] = $var_array['old_av_year'];
            $quarterArray[$counter]['quarter_value'] = 0.70;
            $quarterArray[$counter]['quarter_label'] = '70% INC';
            $quarterArray[$counter]['label'] = $quarterArray[$counter]['quarter_label'];
            $quarterArray[$counter]['year_no'] = 1;
            $quarterArray[$counter]['percentage'] = $percentages['value'];
            $quarterArray[$counter]['value'] = ($new_av['value'] - $old_av['value'])* 0.70;
            $quarterArray[$counter]['td_basic'] = $quarterArray[$counter]['value'] * 0.01;
            $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
            $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['td_sef'];
            $quarterArray[$counter]['pen_basic'] = $quarterArray[$counter]['td_basic'] * $quarterArray[$counter]['percentage'];
            $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['pen_total'] =$quarterArray[$counter]['pen_basic'] + $quarterArray[$counter]['pen_sef'];
            $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_basic'])*2;
            $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
            $quarterArray[$counter]['status'] = 2;
            $quarterArray[$counter]['cbt_year'] = 0;
        return $quarterArray;
     }

     ## NEW ASSESSED VALUE LOOP
     private function newAvCompute($unpaid, $var_array){
        // dd($var_array);
        $percentages = collect($var_array['percentages'])->where('desc','quarter');
        $new_av = collect($var_array['assessed_values'])->where('av_from',$var_array['new_av_year'])
                ->where('av_to',$var_array['new_av_year'])->first();
        $quarterArray = ($unpaid) ? $unpaid : [];
        $counter = count($quarterArray) ?? 0;

        $last_pay_quarter =$var_array['next_pay_quarter'] - 0.25;

        $num = ($last_pay_quarter >= 0.25 && $last_pay_quarter <= 0.75)
                ? ((12*$last_pay_quarter)/3)+1 : 1;

        for ($x = $num; $x <= 4; $x++) {
            $quarterArray[$counter]['count'] = $counter;
            $quarterArray[$counter]['type'] = 'Q'.$x.'('.$var_array['new_av_year'].')';
            $quarterArray[$counter]['from'] = $var_array['new_av_year'];
            $quarterArray[$counter]['to'] = $var_array['new_av_year'];
            $quarterArray[$counter]['quarter_value'] = 0.25*$x;
            $quarterArray[$counter]['quarter_label'] = 'Quarter '.$x;
            $quarterArray[$counter]['label'] = $quarterArray[$counter]['from'].' Q'.$x;
            $quarterArray[$counter]['year_no'] = 'Q'.$x;
            $quarterArray[$counter]['percentage'] = ($percentages->where('from','Q'.$x)->where('to','Q'.$x)->first())['value'] ?? 0;
            $quarterArray[$counter]['value'] = $new_av['value'] * 0.25;
            $quarterArray[$counter]['td_basic'] = $quarterArray[$counter]['value'] * 0.01;
            $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
            $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['td_sef'];
            $quarterArray[$counter]['pen_basic'] = ($quarterArray[$counter]['td_basic'] * $quarterArray[$counter]['percentage']);
            $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['pen_total'] =($quarterArray[$counter]['pen_basic'] +  $quarterArray[$counter]['pen_sef']);
            $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_basic'])*2;
            $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
            // $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['td_total'] + $quarterArray[$counter]['pen_total'];
            $quarterArray[$counter]['status'] = 2;
            $quarterArray[$counter]['cbt_year'] = 0;
            $counter++;
        }
        return $quarterArray;
     }


    ## OLD AV 35% COMPUTAION
    ## OLD AV COMPUTAION
    ## OLD AV 70% COMPUTAION
    ## QUARTERLY COMPUTAION
    // $unpaidQuarter = [];
    // $unpaid = $this->regularAvLoop($unpaidQuarter);
    // $oldAv35 = $this->oldAvLoop35($unpaid);
    // $oldAv = $this->oldAvLoop($oldAv35);
    // $oldAv70 = $this->oldAvLoop70($oldAv);
    // $result = $this->newAvLoop($oldAv70);

}
