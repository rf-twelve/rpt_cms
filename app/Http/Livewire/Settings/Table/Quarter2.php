<?php

namespace App\Http\Livewire\Settings\Table;

use App\Models\RptQuarter2;
use Livewire\Component;

class Quarter2 extends Component
{
    public $editedQ2index = null;
    public $quarter2_values = [];

    public function render()
    {
        return view('livewire.settings.table.quarter2', [
            'quarter2_tables' => $this->quarter2_values,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->quarter2_values = RptQuarter2::get()->toArray();
    }

    public function editQ2Value($index)
    {
        $this->editedQ2index = $index;
    }

    public function saveQ2Value($id, $index)
    {
        $quarter = $this->validate();
        // $assessed_value = RptAssessedValue::where('id', $av_index)
        //     ->select('id', 'av_year_from', 'av_year_to', 'av_value')->get()->toArray() ?? NULL;
        if (!is_null($quarter)) {
            $quarter_data = RptQuarter2::find($id);
            if ($quarter_data) {
                $quarter_data->update($quarter['quarter2_values'][$index]);
            }
        }
        $this->editedQ2index = null;
        $this->dispatchBrowserEvent('swalUpdate');
    }

    protected $rules = [
        'quarter2_values.*.bracket_code' => ['required'],
        'quarter2_values.*.year_from' => ['required', 'numeric'],
        'quarter2_values.*.year_to' => ['required', 'numeric'],
        'quarter2_values.*.label' => ['required'],
        'quarter2_values.*.april' => ['required', 'numeric'],
        'quarter2_values.*.may' => ['required', 'numeric'],
        'quarter2_values.*.june' => ['required', 'numeric'],
    ];
    protected $validationAttributes = [
        'quarter2_values.*.bracket_code' => 'bracket',
        'quarter2_values.*.year_from' => 'year_from',
        'quarter2_values.*.year_to' => 'year_to',
        'quarter2_values.*.label' => 'label',
        'quarter2_values.*.april' => 'april',
        'quarter2_values.*.may' => 'may',
        'quarter2_values.*.june' => 'june',
    ];
}
