<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\Settings\Address\Barangay;
use App\Models\ListBarangay;
use App\Models\RptAccount;
use Livewire\Component;

class RptDelinquencies extends Component
{
    public $delinquent_month_year = [];

    public function mount($selected_date)
    {
        $year = date('Y',strtotime($selected_date));
        $month = date('m',strtotime($selected_date));
        $this->delinquent_month_year = ['month'=>$month,'year'=>$year];
    }
    public function print($id)
    {

        $dataArray = array(
            'id' => $id,
            'form' => 'gas_consumption',
            'db' => 'vms_gas_consumptions',
            'model' => 'VmsGasConsumption',
            'relation_table' => '',
        );

        $query = http_build_query(array('aParam' => $dataArray));

        return redirect()->route('PDF', $query);

    }

    public function render()
    {
        $data = RptAccount::compute_tax_due($this->delinquent_month_year);
        // dd($taxDute);
        $delinquent_per_brgy = [];
        $count = 0;
        $collected = collect($data['taxdue'])->groupBy('brgy')->sortBy('brgy');
        foreach ($collected as $key => $value) {
            $delinquent_per_brgy[$count]['brgy'] = $key;
            $delinquent_per_brgy[$count]['av'] = $value->sum('av');
            $delinquent_per_brgy[$count]['td_basic'] = $value->sum('td_basic');
            $delinquent_per_brgy[$count]['td_sef'] = $value->sum('td_sef');
            $delinquent_per_brgy[$count]['penalty_basic'] = $value->sum('penalty_basic');
            $delinquent_per_brgy[$count]['total'] = $value->sum('td_total') + $value->sum('penalty_total');
            $count++;
        }

        $newCollected = collect($delinquent_per_brgy)->sortBy('brgy');
        // dd($delinquent_per_brgy);
        // $collected = RptAccount::groupBy('lp_brgy')
        // // ->orderBy('lp_brgy','asc')
        // ->selectRaw('sum(rtdp_tc_basic) as total_basic, lp_brgy')
        // ->get(); //this return collection

        // $collectedBrgy = ListBarangay::select('index','name')->get();

        return view('livewire.reports.rpt-delinquencies',[
            'rptAccounts' => $newCollected,
            'grandTotal' => $data['total_taxdue'],
        ]);
    }
}
