<?php

namespace App\Http\Livewire\Settings;

use App\Models\RptPercentage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Taxtables extends Component
{
    public $editedFormulaIndex = null;
    public $formula_values = [];
    public $newValues = [
        'from' => '',
        'to' => '',
        'count' => '',
        'desc' => '',
        'january' => '',
        'february' => '',
        'march' => '',
        'april' => '',
        'may' => '',
        'june' => '',
        'july' => '',
        'august' => '',
        'september' => '',
        'october' => '',
        'november' => '',
        'december' => '',
    ];
    // public $newAvYear;
    // public $oldAvYear;

    public function render()
    {
        return view('livewire.settings.taxtables',[
            'formula_tables' => $this->formula_values,
        ]);
    }

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        // $this->newAvYear = date("Y", strtotime(Carbon::now()));
        // $this->oldAvYear = $this->newAvYear - 1;
        $this->formula_values = RptPercentage::get()->toArray();
    }

    public function editFormula($formula_index)
    {
        $this->editedFormulaIndex = $formula_index;
    }

    public function saveNew()
    {
        $valid = $this->validate([
            'newValues.from' => ['required'],
            'newValues.to' => ['required'],
            'newValues.count' => ['required'],
            'newValues.desc' => ['required'],
            'newValues.january' => ['required'],
            'newValues.february' => ['required'],
            'newValues.march' => ['required'],
            'newValues.april' => ['required'],
            'newValues.may' => ['required'],
            'newValues.june' => ['required'],
            'newValues.july' => ['required'],
            'newValues.august' => ['required'],
            'newValues.september' => ['required'],
            'newValues.october' => ['required'],
            'newValues.november' => ['required'],
            'newValues.december' => ['required'],
        ]);
        RptPercentage::create($valid['newValues']);
        $this->dispatchBrowserEvent('swalSuccess');
        $this->redirectRoute('settings_taxtables');
    }

    public function saveFormulaValue($id, $index)
    {

        $validated = $this->validate();
        // dd($validated);
        RptPercentage::find($id)
            ->update($validated['formula_values'][$index]);
        $this->formula_values = RptPercentage::get()->toArray();
        $this->editedFormulaIndex = null;
        $this->dispatchBrowserEvent('swalUpdate');
    }

    protected $rules = [
        'formula_values.*.from' => ['required'],
        'formula_values.*.to' => ['required'],
        'formula_values.*.count' => ['required'],
        'formula_values.*.desc' => ['required'],
        'formula_values.*.january' => ['required'],
        'formula_values.*.february' => ['required'],
        'formula_values.*.march' => ['required'],
        'formula_values.*.april' => ['required'],
        'formula_values.*.may' => ['required'],
        'formula_values.*.june' => ['required'],
        'formula_values.*.july' => ['required'],
        'formula_values.*.august' => ['required'],
        'formula_values.*.september' => ['required'],
        'formula_values.*.october' => ['required'],
        'formula_values.*.november' => ['required'],
        'formula_values.*.december' => ['required'],
    ];
    protected $validationAttributes = [
        'formula_values.*.from' => 'From(year)',
        'formula_values.*.to' => 'To(year)',
        'formula_values.*.count' => 'Number of year',
    ];
}

