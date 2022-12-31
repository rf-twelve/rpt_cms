<?php

namespace App\Http\Livewire\Settings\Table;

use App\Models\RptQuarter1;
use Livewire\Component;

class Quarter1 extends Component
{
    public $editedQ1index = null;
    public $quarter1_values = [];

    public function render()
    {
        return view('livewire.settings.table.quarter1', [
            'quarter1_tables' => $this->quarter1_values,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->quarter1_values = RptQuarter1::get()->toArray();
    }

    public function editQ1Value($q1_index)
    {
        $this->editedQ1index = $q1_index;
    }

    public function saveQ1Value($id, $index)
    {
        $quarter1 = $this->validate();
        // $assessed_value = RptAssessedValue::where('id', $av_index)
        //     ->select('id', 'av_year_from', 'av_year_to', 'av_value')->get()->toArray() ?? NULL;
        if (!is_null($quarter1)) {
            $quarter_data = RptQuarter1::find($id);
            if ($quarter_data) {
                $quarter_data->update($quarter1['quarter1_values'][$index]);
            }
        }
        $this->editedQ1index = null;
        $this->dispatchBrowserEvent('swalUpdate');
    }

    protected $rules = [
        'quarter1_values.*.bracket_code' => ['required'],
        'quarter1_values.*.year_from' => ['required', 'numeric'],
        'quarter1_values.*.year_to' => ['required', 'numeric'],
        'quarter1_values.*.label' => ['required'],
        'quarter1_values.*.january' => ['required', 'numeric'],
        'quarter1_values.*.february' => ['required', 'numeric'],
        'quarter1_values.*.march' => ['required', 'numeric'],

    ];
    protected $validationAttributes = [
        'quarter1_values.*.bracket_code' => 'bracket',
        'quarter1_values.*.year_from' => 'year_from',
        'quarter1_values.*.year_to' => 'year_to',
        'quarter1_values.*.label' => 'label',
        'quarter1_values.*.january' => 'january',
        'quarter1_values.*.february' => 'february',
        'quarter1_values.*.march' => 'march',
    ];
}
