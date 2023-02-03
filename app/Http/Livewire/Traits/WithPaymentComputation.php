<?php

namespace App\Http\Livewire\Traits;

use App\Models\RptAssessedValue;
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
        $percentages = $this->getPercentageValue($month);
        $year_old_av = ($percentages->where('desc','oldav')->first())->from;

        $var_array = [
            'next_pay_year' => $next_payment['pay_year'],
            'next_pay_quarter' => $next_payment['pay_quarter'],
            'old_av_year' => $year_old_av,
            'new_av_year' => $year_old_av + 1,
            'assessed_values' => $avs,
            'percentages' => $percentages->where('to','>=',$next_payment['pay_year'])->toArray(),
        ];
        // dd($this->nextPaymentYear);
        $unpaid = [];

        ## Catching advance payment
        if ($var_array['next_pay_year'] > $var_array['new_av_year']) {
            $this->dispatchBrowserEvent('swalPaymentIsUpdated');
        ## Catching new av payment
        } elseif ($var_array['next_pay_year'] == $var_array['new_av_year']) {
            return $this->newAvCompute($unpaid, $var_array);
        ## Catching old av payment
        } elseif($var_array['next_pay_year'] == $var_array['old_av_year']) {
            ## Check first if last payment has a quarter between 0.25 and 0.75
            $oldAv35 = $this->oldAv35($unpaid, $var_array);
            $oldAv = $this->oldAvCompute($oldAv35, $var_array);
            $oldAv70 = $this->oldAv70($oldAv, $var_array);
            $var_array['next_pay_quarter'] = 0.25; //reset pay quarter
            $result = $this->newAvCompute($oldAv70, $var_array);
            // dd($result);
            return $result;
        ## Catching regular payment(below old av)
        } elseif($var_array['next_pay_year'] < $var_array['old_av_year'])  {
            // dd('regular av');
            $regular = $this->regularCompute($unpaid,$var_array);
            $var_array['next_pay_quarter'] = 0.25; //reset pay quarter
            $oldAv35 = $this->oldAv35($regular, $var_array);
            $oldAv = $this->oldAvCompute($oldAv35, $var_array);
            $oldAv70 = $this->oldAv70($oldAv, $var_array);
            $result = $this->newAvCompute($oldAv70, $var_array);
            // dd($result);
            return $result;
        }else{
            $this->dispatchBrowserEvent('swalPaymentIsUpdated');
        }
    }

    ## Regular computation below old av
    public function regularCompute($unpaid, $var_array)
    {
        // $last_pay_quarter = $var_array['next_pay_quarter'] - 0.25;

        // $num = ($last_pay_quarter >= 0.25 && $last_pay_quarter <= 0.75) ? ((12*$last_pay_quarter)/3)+1 : 1;

        // $quarterArray = $unpaid ?? [];
        // $counter = count($quarterArray) ?? 0;
        $last_pay_quarter = $var_array['next_pay_quarter'] - 0.25;
        $collected_p = collect($var_array['percentages']);
        $collected_av = collect($var_array['assessed_values']);
        $payYear = $var_array['next_pay_year'];
        $counter = 0;
        $countDiff =  $var_array['old_av_year'] - $var_array['next_pay_year'];

        for ($i=0; $i < $countDiff; $i++) {
            $a_value = $collected_av->where('av_from','<=',$payYear)
                    ->where('av_to','>=',$payYear)->first();
            $percentages = $collected_p
                    ->where('from','<=',$payYear)
                    ->where('to','>=',$payYear)->first();

            $num = ($last_pay_quarter >= 0.25 && $last_pay_quarter <= 0.75)
                    ? ((12*$last_pay_quarter)/3)+1 : 1;

            for ($x = $num; $x <= 4; $x++) {
                $quarterArray[$counter]['count'] = $counter;
                $quarterArray[$counter]['type'] = 'Q'.$payYear;
                $quarterArray[$counter]['from'] = $payYear;
                $quarterArray[$counter]['to'] = $payYear;
                $quarterArray[$counter]['quarter_value'] = 0.25 * $x;
                $quarterArray[$counter]['quarter_label'] = 'Quarter '.$x;
                $quarterArray[$counter]['label'] = $quarterArray[$counter]['from'].' Q'.$x;
                $quarterArray[$counter]['year_no'] = 'Q'.$x;
                $quarterArray[$counter]['percentage'] = $percentages['value'];
                $quarterArray[$counter]['value'] = $a_value['value'];
                $quarterArray[$counter]['td_basic'] = ($a_value['value'] * 0.25) * 0.01;
                $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
                $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] * 2;
                $quarterArray[$counter]['pen_basic'] = $quarterArray[$counter]['td_basic'] * $quarterArray[$counter]['percentage'];
                $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
                $quarterArray[$counter]['pen_total'] =$quarterArray[$counter]['pen_basic'] * 2;
                $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_basic'])*2;
                $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
                $quarterArray[$counter]['status'] = 2;
                $counter++;
            }
            $payYear++;
            $last_pay_quarter = 0;
        }
        return $quarterArray;
    }

    ## OLD AV 35% COMPUTATION
    private function oldAv35($unpaid, $var_array){
        // dd($var_array);
        $percentages = collect($var_array['percentages'])->where('desc','oldav')->first();
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
            $quarterArray[$counter]['td_basic'] = $quarterArray[$counter]['value'] * 0.01;
            $quarterArray[$counter]['td_sef'] = $quarterArray[$counter]['td_basic'];
            $quarterArray[$counter]['td_total'] =$quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['td_sef'];
            $quarterArray[$counter]['pen_basic'] = $quarterArray[$counter]['td_basic'] * $quarterArray[$counter]['percentage'];
            $quarterArray[$counter]['pen_sef'] = $quarterArray[$counter]['pen_basic'];
            $quarterArray[$counter]['pen_total'] =$quarterArray[$counter]['pen_basic'] + $quarterArray[$counter]['pen_sef'];
            $quarterArray[$counter]['temp_basic_penalty'] = ($quarterArray[$counter]['td_basic'] + $quarterArray[$counter]['pen_sef'])*2;
            $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['temp_basic_penalty'];
            // $quarterArray[$counter]['amount_due'] = $quarterArray[$counter]['td_total'] + $quarterArray[$counter]['pen_total'];
            $quarterArray[$counter]['status'] = 2;
            $counter++;
        }
        // dd($quarterArray);
        return $quarterArray;
     }
     ## OLD AV 70% COMPUTATION
    private function oldAv70($unpaid, $var_array){
        $percentages = collect($var_array['percentages'])->where('desc','oldav')->first();
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
