<?php

namespace App\Http\Livewire\RealPropertyTax\Accounts;

use App\Models\RptAccount;
use App\Models\RptAccountAV;
use App\Models\RptAccountAVLabel;
use App\Models\RptAssessedValue;
use App\Models\RptPaymentRecord;
use App\Models\RptQuarter1;
use App\Models\RptTable;
use Illuminate\Support\Arr;
use Livewire\Component;

class LedgerEntry extends Component
{
    public $selectedData = null;
    public $selectedPin = null;
    public $account_id;

    protected $listeners = [
        'refreshLedger' => '$refresh',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($selectedID)
    {
        $this->selectedData = RptAccount::with('assessed_values','payment_records')->findOrFail($selectedID);
        // dd($this->selectedData->assessed_values);
        $this->account_id = $selectedID;
        $this->selectedPin = $this->selectedData->rpt_pin;
    }

    public function viewAccount($id)
    {
        $data = RptAccount::findOrFail($id);
        $type = 'edit';
        $this->emit('viewAccount', $data, $type);
        $this->emitSelf('refreshParent');
    }

    public function addAssessedValue()
    {
        $this->emit('addAssessedValue', $this->selectedData->assessed_values);
    }

    public function addPaymentRecord()
    {
        $this->emit('addPaymentRecord', $this->account_id);
    }

    public function editPaymentRecord($id)
    {
        $this->emit('editPaymentRecord', $id);
    }

    public function render()
    {
        // dd($this->selectedData);
        return view('livewire.real-property-tax.accounts.ledger-entry', [
            'assessed_value' => $this->selectedData->assessed_values->where('av_value','>',0)->sortByDesc('av_year_from'),
            'payment_record' => $this->selectedData->payment_records,
        ]);
    }

    public function deleteSingleRecord($id)
    {
        $record = RptPaymentRecord::findOrFail($id);
        $record->delete();
        $this->emitSelf('refreshLedger');
        $this->dispatchBrowserEvent('swalDelete');
    }

}
