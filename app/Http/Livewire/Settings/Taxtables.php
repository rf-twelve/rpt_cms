<?php

namespace App\Http\Livewire\Settings;

use App\Models\RptBracket;
use App\Models\RptPercentage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Taxtables extends Component
{
    public $editedFormulaIndex = null;
    public $formula_values = [];
    public $newValues = [
        'year_from' => '',
        'year_to' => '',
        'label' => '',
        'year_no' => '',
        'av_percent' => '',
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
        $this->formula_values = RptBracket::get()->toArray();
    }

    public function editFormula($formula_index)
    {
        $this->editedFormulaIndex = $formula_index;
    }

    public function saveNew()
    {
        $valid = $this->validate([
            'newValues.year_from' => ['required'],
            'newValues.year_to' => ['required'],
            'newValues.label' => ['required'],
            'newValues.year_no' => ['required'],
            'newValues.av_percent' => ['required'],
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
        RptBracket::create($valid['newValues']);
        $this->dispatchBrowserEvent('swalSuccess');
        $this->redirectRoute('settings_taxtables');
    }

    public function saveFormulaValue($id, $index)
    {

        $validated = $this->validate();
        // dd($validated);
        RptBracket::find($id)
            ->update($validated['formula_values'][$index]);
        $this->formula_values = RptBracket::get()->toArray();
        $this->editedFormulaIndex = null;
        $this->dispatchBrowserEvent('swalUpdate');
    }

    protected $rules = [
        'formula_values.*.year_from' => ['required'],
        'formula_values.*.year_to' => ['required'],
        'formula_values.*.label' => ['required'],
        'formula_values.*.year_no' => ['required'],
        'formula_values.*.av_percent' => ['required'],
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
        'formula_values.*.year_from' => 'From(year)',
        'formula_values.*.year_to' => 'To(year)',
    ];
}

