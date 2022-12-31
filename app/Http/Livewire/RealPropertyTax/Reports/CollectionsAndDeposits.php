<?php

namespace App\Http\Livewire\RealPropertyTax\Reports;

use App\Http\Livewire\Traits\WithAccountableForm;
use App\Http\Livewire\Traits\WithCollectionAndDeposit;
use App\Http\Livewire\Traits\WithPaymentRecord;
use App\Models\RptAccountableForm;
use App\Models\RptPaymentRecord;
use Livewire\Component;

class CollectionsAndDeposits extends Component
{
    use WithPaymentRecord, WithAccountableForm, WithCollectionAndDeposit;

    public $accountableFormData = [];
    public $accountableData = [];
    public $grandTotal;
    public $paymentRecordData = [];
    public $showTable = true;
    public $showForm = false;
    public $selectedID;
    public $selectedData;
    public $verifier = [
        'name' => 'KAREN BERSAMINA',
        'designation' => 'Acting Cashier|Treasurer',
    ];


    public function mount(){
        // $accountableFormData = $this->getAccoutableForm();
        $this->paymentRecordData = $this->getAllPaymentRecord();
        // dd($this->paymentRecordData);
    }
    public function setForm($id){
        $this->showTable = false;
        $this->showForm = true;
        $this->selectedID = $id;

        $data = $this->setCollectionAndDeposit($id);
        $this->selectedData = $data['selectedData'];
        $this->accountableFormData = $data['accountableFormData'];
        $this->accountableData = $data['accountableData'];
        $this->grandTotal = $data['grandTotal'];
    }

    public function unsetForm(){
        $this->showTable = true;
        $this->showForm = false;
        $this->reset(['accountableData','grandTotal']);
    }
    public function print()
    {
        $dataArray = array(
            'pr_id' => $this->selectedID,
            'verifier_name' => $this->verifier['name'],
            'verifier_designation' => $this->verifier['designation'],
            'form' => 'collection_deposit_report',
            'data' => 'data',
        );

        $query = http_build_query(array('aParam' => $dataArray));

        return redirect()->route('PDF', $query);
    }

    public function render()
    {

        return view('livewire.real-property-tax.reports.collections-and-deposits',[
            'paymentRecords' => $this->paymentRecordData,
        ]);
    }
}
