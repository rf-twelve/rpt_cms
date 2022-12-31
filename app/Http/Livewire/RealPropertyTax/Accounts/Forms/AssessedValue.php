<?php

namespace App\Http\Livewire\RealPropertyTax\Accounts\Forms;

use App\Models\RptAssessedValue;
use Livewire\Component;

class AssessedValue extends Component
{
    public $editedAVindex = null;
    public $assessedValues = [];
    public $rpt_account_id = null;
    public $rpt_pin = null;
    public $update_on = false;
    public $year_today;
    protected $listeners = [
        'assessedValueRefresh' => '$refresh',
        'addAssessedValue' => 'addAssessedValueEvent',
    ];

    protected $rules = [
        'assessedValues.*.id' => ['nullable'],
        'assessedValues.*.av_pin' => ['nullable'],
        'assessedValues.*.av_year_from' => ['required', 'numeric'],
        'assessedValues.*.av_year_to' => ['required', 'numeric'],
        'assessedValues.*.av_value' => ['required', 'numeric'],
        'assessedValues.*.rpt_account_id' => ['nullable'],
    ];
    protected $validationAttributes = [
        'assessedValues.*.av_year_from' => 'From(year)',
        'assessedValues.*.av_year_to' => 'To(year)',
        'assessedValues.*.av_value' => 'Assessed Value',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function addAssessedValueEvent($data)
    {
        // $this->rpt_account_id = $account['id'];
        $this->assessedValues = $data;
        $this->dispatchBrowserEvent('assessedValueOpen');
    }

    public function editAssessedValue($av_index)
    {
        $this->editedAVindex = $av_index;
    }

    public function saveAssessedValue()
    {
        $assessed_value = $this->validate();
        foreach ($assessed_value['assessedValues'] as $key => $value) {

            if (!is_null($value['id']) && !empty($value['id'])) {
                $editedAV = RptAssessedValue::find($value['id']);
                $editedAV->update($value);
            } else {
                RptAssessedValue::create($value);
            }
        }
        // dd('sss');
        // $this->editedAVindex = null;
        $this->dispatchBrowserEvent('assessedValueClose');
        $this->emitUp('refreshLedger');
        $this->dispatchBrowserEvent('swalUpdate');
    }

    // public function saveAssessedValue($av_id, $av_index)
    // {
    //     $assessed_value = $this->validate();
        // $assessed_value = RptAssessedValue::where('id', $av_index)
        //     ->select('id', 'av_year_from', 'av_year_to', 'av_value')->get()->toArray() ?? NULL;
        // dd();

    //     if (!is_null($assessed_value)) {
    //         $editedAV = RptAssessedValue::find($av_id);
    //         if ($editedAV) {
    //             $editedAV->update($assessed_value['assessedValues'][$av_index]);
    //         }
    //     }
    //     $this->editedAVindex = null;
    //     $this->emitUp('refreshLedger');
    //     $this->dispatchBrowserEvent('swalUpdate');
    // }

    public function render()
    {
        return view('livewire.real-property-tax.accounts.forms.assessed-value', [
            'bracket_year' => $this->assessedValues,
        ]);
    }

    public function mount()
    {
        $this->year_today = date('Y');
    }

    public function addAssessedValue()
    {
        $this->assessedValues[] = [
            'id' => '',
            'av_pin' => $this->rpt_pin,
            'av_year_from' => $this->year_today,
            'av_year_to' => $this->year_today,
            'av_value' => 0,
            'rpt_account_id' => $this->rpt_account_id,
        ];
    }
    public function removeAssessedValue($index)
    {
        $find = RptAssessedValue::find($this->assessedValues[$index]['id']);
        if (!is_null($find)) {
            RptAssessedValue::find($this->assessedValues[$index]['id'])->delete();
        }
        unset($this->assessedValues[$index]);
        $this->assessedValues = array_values($this->assessedValues);
    }
}
