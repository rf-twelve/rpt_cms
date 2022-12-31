<?php

namespace App\Http\Livewire\Settings\Table;

use App\Models\RptFormulaTable;
use App\Models\RptPercentage;
use Carbon\Carbon;
use Livewire\Component;

class Formula extends Component
{
    public $editedFormulaIndex = null;
    public $formula_values = [];
    public $newAvYear;
    public $oldAvYear;

    public function render()
    {
        return view('livewire.settings.table.formula', [
            'formula_tables' => $this->formula_values,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->newAvYear = date("Y", strtotime(Carbon::now()));
        $this->oldAvYear = $this->newAvYear - 1;
        $this->formula_values = RptPercentage::get()->toArray();
    }

    public function editFormula($formula_index)
    {
        $this->editedFormulaIndex = $formula_index;
    }

    public function saveFormulaValue($id, $index)
    {
        $formula = $this->validate();
        // $assessed_value = RptAssessedValue::where('id', $av_index)
        //     ->select('id', 'av_year_from', 'av_year_to', 'av_value')->get()->toArray() ?? NULL;
        if (!is_null($formula)) {
            $quarter_data = RptFormulaTable::find($id);
            if ($quarter_data) {
                $quarter_data->update($formula['formula_values'][$index]);
            }
        }
        $this->editedFormulaIndex = null;
        $this->dispatchBrowserEvent('swalUpdate');
    }

    protected $rules = [
        'formula_values.*.from' => ['required', 'numeric'],
        'formula_values.*.to' => ['required', 'numeric'],
        'formula_values.*.count' => ['required'],
        'formula_values.*.base' => ['required', 'numeric'],
        'formula_values.*.value' => ['required', 'numeric'],

    ];
    protected $validationAttributes = [
        'formula_values.*.from' => 'From(year)',
        'formula_values.*.to' => 'To(year)',
        'formula_values.*.count' => 'Number of year',
        'formula_values.*.base' => ['required', 'numeric'],
        'formula_values.*.value' => ['required', 'numeric'],
    ];
}
