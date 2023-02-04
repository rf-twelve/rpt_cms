<?php

namespace App\Http\Livewire\Settings\Form;
use Illuminate\Support\Facades\Validator;
use App\Models\ListForm;
use Livewire\Component;

class FormType extends Component
{
    public $data_index = null;
    public $data_values = [];
    public $input_fields;
    public $name;
    public $is_active;
    public $upload_fields = false;
    protected $rules = [
        'data_values.*.name' => ['required'],
        'data_values.*.is_active' => ['required']
    ];

    public function render()
    {
        return view('livewire.settings.form.form-type', [
            'data_tables' => $this->data_values,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->data_values = ListForm::get()->toArray();
    }

    public function newRecord()
    {
        $this->name = '';
        $this->is_active= '';
        $this->input_fields = !$this->input_fields;
    }

    public function editRecord($index)
    {
        $this->data_index = $index;
    }

    public function deleteSingleRecord($id)
    {
        $record = ListForm::findOrFail($id);
        $record->delete();
        $this->data_index = null;
        $this->mount();
        $this->dispatchBrowserEvent('swalDelete');
    }

    public function saveRecord()
    {
        Validator::make(
            ['is_active' => $this->is_active],
            ['is_active' => 'required'],
            ['required' => 'The :attribute field is required'],
        )->validate();

        Validator::make(
            ['name' => $this->name],
            ['name' => 'required'],
            ['required' => 'The :attribute field is required'],
        )->validate();

        ListForm::create([
            'name'  => $this->name,
            'is_active' => $this->is_active,
        ]);
        $this->input_fields = false;
        $this->mount();
        $this->dispatchBrowserEvent('swalSuccess');
    }

    public function updateRecord($id, $index)
    {
        $data_validated = $this->validate();
        if (!is_null($data_validated)) {
            $record = ListForm::find($id);
            if ($record) {
                $record->update([
                    'name' => strtoupper($data_validated['data_values'][$index]['name']),
                    'is_active' => $data_validated['data_values'][$index]['is_active'],
                ]);
            }
        }
        $this->data_index = null;
        $this->mount();
        $this->dispatchBrowserEvent('swalUpdate');
    }

}
