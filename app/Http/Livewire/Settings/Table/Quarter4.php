<?php

namespace App\Http\Livewire\Settings\Table;

use App\Models\RptQuarter4;
use Livewire\Component;

class Quarter4 extends Component
{
    public $editedQ4index = null;
    public $quarter4_values = [];

    public function render()
    {
        return view('livewire.settings.table.quarter4', [
            'quarter4_tables' => $this->quarter4_values,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->quarter4_values = RptQuarter4::get()->toArray();
    }

    public function editQ4Value($index)
    {
        $this->editedQ4index = $index;
    }

    public function saveQ4Value($id, $index)
    {
        $quarter = $this->validate();
        // dd($quarter['quarter4_values'][$index]);

        // $assessed_value = RptAssessedValue::where('id', $av_index)
        //     ->select('id', 'av_year_from', 'av_year_to', 'av_value')->get()->toArray() ?? NULL;
        if (!is_null($quarter)) {
            $quarter_data = RptQuarter4::find($id);
            // dd($quarter_data);

            if ($quarter_data) {
                $quarter_data->update($quarter['quarter4_values'][$index]);
            }
        }
        $this->editedQ4index = null;
        $this->dispatchBrowserEvent('swalUpdate');
    }

    protected $rules = [
        'quarter4_values.*.bracket_code' => ['required'],
        'quarter4_values.*.year_from' => ['required', 'numeric'],
        'quarter4_values.*.year_to' => ['required', 'numeric'],
        'quarter4_values.*.label' => ['required'],
        'quarter4_values.*.october' => ['required', 'numeric'],
        'quarter4_values.*.november' => ['required', 'numeric'],
        'quarter4_values.*.december' => ['required', 'numeric'],

    ];
    protected $validationAttributes = [
        'quarter4_values.*.bracket_code' => 'bracket',
        'quarter4_values.*.year_from' => 'year_from',
        'quarter4_values.*.year_to' => 'year_to',
        'quarter4_values.*.label' => 'label',
        'quarter4_values.*.october' => 'october',
        'quarter4_values.*.november' => 'november',
        'quarter4_values.*.december' => 'december',
    ];
}
