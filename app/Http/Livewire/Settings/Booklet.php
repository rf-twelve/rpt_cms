<?php

namespace App\Http\Livewire\Settings;

use App\Models\RptAccountableForm;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;

class Booklet extends Component
{
    public $showAddValue = false;
    public $editedIndex = null;
    public $bookletsData = [];
    public $addNewData = [
            'form_name' => '',
            'begin_qty' => '',
            'begin_serial_from' => '',
            'begin_serial_to' => '',
            'issued_qty' => '',
            'issued_serial_from' => '',
            'issued_serial_to' => '',
            'end_qty' => '',
            'end_serial_from' => '',
            'end_serial_to' => '',
            'user_id' => '',
            ];
    public function render()
    {
        return view('livewire.settings.booklet', [
            'booklets' => $this->bookletsData,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editValue($index)
    {
        $this->editedIndex = $index;
    }

    public function rules() { return [
        'bookletsData.'.$this->editedIndex.'.form_name' => ['required'],
        'bookletsData.'.$this->editedIndex.'.begin_qty' => ['required','numeric'],
        'bookletsData.'.$this->editedIndex.'.begin_serial_from' => ['required','numeric'],
        'bookletsData.'.$this->editedIndex.'.begin_serial_to' => ['required','numeric'],
        'bookletsData.'.$this->editedIndex.'.issued_qty' => ['sometimes', 'numeric'],
        'bookletsData.'.$this->editedIndex.'.issued_serial_from' => ['sometimes', 'numeric'],
        'bookletsData.'.$this->editedIndex.'.issued_serial_to' => ['sometimes', 'numeric'],
        'bookletsData.'.$this->editedIndex.'.end_qty' => ['sometimes', 'numeric'],
        'bookletsData.'.$this->editedIndex.'.end_serial_from' => ['sometimes', 'numeric'],
        'bookletsData.'.$this->editedIndex.'.end_serial_to' => ['sometimes', 'numeric'],
        'bookletsData.'.$this->editedIndex.'.user_id' => ['required'],
    ]; }

    public function addValue()
    {
        $this->showAddValue = true;
    }

    public function saveValue($id, $index)
    {
        $validatedData = $this->validate();
        $foundRecord = RptAccountableForm::findOrFail($id);

        if ($validatedData) {
            $foundRecord->update($validatedData['bookletsData'][$index]);
        }
        $this->editedIndex = null;
        $this->dispatchBrowserEvent('swalUpdate');
    }

    public function saveNew()
    {
        $validatedData = $this->validate([
            'addNewData.form_name' => ['required'],
            'addNewData.begin_qty' => ['required','numeric'],
            'addNewData.begin_serial_from' => ['required','numeric'],
            'addNewData.begin_serial_to' => ['required','numeric'],
            'addNewData.issued_qty' => ['sometimes', 'numeric'],
            'addNewData.issued_serial_from' => ['sometimes', 'numeric'],
            'addNewData.issued_serial_to' => ['sometimes', 'numeric'],
            'addNewData.end_qty' => ['sometimes', 'numeric'],
            'addNewData.end_serial_from' => ['sometimes', 'numeric'],
            'addNewData.end_serial_to' => ['sometimes', 'numeric'],
            'addNewData.user_id' => ['required'],
        ]);
        $validatedData['addNewData']['end_qty'] = empty($validatedData['addNewData']['end_qty'])
            ? $validatedData['addNewData']['begin_qty'] : $validatedData['addNewData']['end_qty'];
        $validatedData['addNewData']['end_serial_from'] = empty($validatedData['addNewData']['end_serial_from'])
            ? $validatedData['addNewData']['begin_serial_from'] : $validatedData['addNewData']['end_serial_from'];
        $validatedData['addNewData']['end_serial_to'] = empty($validatedData['addNewData']['end_serial_to'])
            ? $validatedData['addNewData']['begin_serial_to'] : $validatedData['addNewData']['end_serial_to'];

        dd($validatedData['addNewData']);
        RptAccountableForm::create($validatedData['addNewData']);

        $this->showAddValue = false;

        $this->mount();

        $this->dispatchBrowserEvent('swalSuccess');
    }

    public function mount()
    {
        $this->bookletsData = RptAccountableForm::get()->toArray();
    }

}
