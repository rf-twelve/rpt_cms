<?php

namespace App\Http\Livewire\Settings\Table;

use App\Models\RptQuarter3;
use Livewire\Component;

class Quarter3 extends Component
{
    public $editedQ3index = null;
    public $quarter3_values = [];

    public function render()
    {
        return view('livewire.settings.table.quarter3', [
            'quarter3_tables' => $this->quarter3_values,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->quarter3_values = RptQuarter3::get()->toArray();
    }

    public function editQ3Value($index)
    {
        $this->editedQ3index = $index;
    }

    public function saveQ3Value($id, $index)
    {
        $quarter = $this->validate();
        // $assessed_value = RptAssessedValue::where('id', $av_index)
        //     ->select('id', 'av_year_from', 'av_year_to', 'av_value')->get()->toArray() ?? NULL;
        if (!is_null($quarter)) {
            $quarter_data = RptQuarter3::find($id);
            if ($quarter_data) {
                $quarter_data->update($quarter['quarter3_values'][$index]);
            }
        }
        $this->editedQ3index = null;
        $this->dispatchBrowserEvent('swalUpdate');
    }

    protected $rules = [
        'quarter3_values.*.bracket_code' => ['required'],
        'quarter3_values.*.year_from' => ['required', 'numeric'],
        'quarter3_values.*.year_to' => ['required', 'numeric'],
        'quarter3_values.*.label' => ['required'],
        'quarter3_values.*.july' => ['required', 'numeric'],
        'quarter3_values.*.august' => ['required', 'numeric'],
        'quarter3_values.*.september' => ['required', 'numeric'],
    ];
    protected $validationAttributes = [
        'quarter3_values.*.bracket_code' => 'bracket',
        'quarter3_values.*.year_from' => 'year_from',
        'quarter3_values.*.year_to' => 'year_to',
        'quarter3_values.*.label' => 'label',
        'quarter3_values.*.july' => 'july',
        'quarter3_values.*.august' => 'august',
        'quarter3_values.*.september' => 'september',
    ];
}
