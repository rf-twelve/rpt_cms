<?php

namespace App\Http\Livewire\Settings;

use App\Models\RptBooklet;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;

class Booklet extends Component
{
    public $showAddValue = false;
    public $editedIndex = null;
    public $bookletsData = [];
    public $addNewData = [
            'form' => '',
            'begin_qty' => '',
            'begin_serial_fr' => '',
            'begin_serial_to' => '',
            'issued_qty' => '',
            'issued_serial_fr' => '',
            'issued_serial_to' => '',
            'end_qty' => '',
            'end_serial_fr' => '',
            'end_serial_to' => '',
            'user_id' => '',
            ];
    public function render()
    {
        return view('livewire.settings.booklet', [
            'booklets' => $this->bookletsData,
        ]);
    }

    // public function updatedAddNewData.''.Form(){
    //     dd('ss');
    // }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editValue($index)
    {
        $this->editedIndex = $index;
    }

    public function rules() { return [
        'bookletsData.'.$this->editedIndex.'.form' => ['required'],
        'bookletsData.'.$this->editedIndex.'.begin_qty' => ['required','numeric'],
        'bookletsData.'.$this->editedIndex.'.begin_serial_fr' => ['required','numeric'],
        'bookletsData.'.$this->editedIndex.'.begin_serial_to' => ['required','numeric'],
        'bookletsData.'.$this->editedIndex.'.issued_qty' => ['sometimes', 'numeric'],
        'bookletsData.'.$this->editedIndex.'.issued_serial_fr' => ['sometimes', 'numeric'],
        'bookletsData.'.$this->editedIndex.'.issued_serial_to' => ['sometimes', 'numeric'],
        'bookletsData.'.$this->editedIndex.'.end_qty' => ['sometimes', 'numeric'],
        'bookletsData.'.$this->editedIndex.'.end_serial_fr' => ['sometimes', 'numeric'],
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
        $foundRecord = RptBooklet::findOrFail($id);

        if ($validatedData) {
            $foundRecord->update($validatedData['bookletsData'][$index]);
        }
        $this->editedIndex = null;
        $this->dispatchBrowserEvent('swalUpdate');
    }

    public function saveNew()
    {
        $validatedData = $this->validate([
            'addNewData.form' => ['required'],
            'addNewData.begin_qty' => ['required','numeric'],
            'addNewData.begin_serial_fr' => ['required','numeric'],
            'addNewData.begin_serial_to' => ['required','numeric'],
            'addNewData.issued_qty' => ['sometimes', 'numeric'],
            'addNewData.issued_serial_fr' => ['sometimes', 'numeric'],
            'addNewData.issued_serial_to' => ['sometimes', 'numeric'],
            'addNewData.end_qty' => ['sometimes', 'numeric'],
            'addNewData.end_serial_fr' => ['sometimes', 'numeric'],
            'addNewData.end_serial_to' => ['sometimes', 'numeric'],
            'addNewData.user_id' => ['required'],
        ]);
        $validatedData['addNewData']['end_qty'] = empty($validatedData['addNewData']['end_qty'])
            ? $validatedData['addNewData']['begin_qty'] : $validatedData['addNewData']['end_qty'];
        $validatedData['addNewData']['end_serial_fr'] = empty($validatedData['addNewData']['end_serial_fr'])
            ? $validatedData['addNewData']['begin_serial_fr'] : $validatedData['addNewData']['end_serial_fr'];
        $validatedData['addNewData']['end_serial_to'] = empty($validatedData['addNewData']['end_serial_to'])
            ? $validatedData['addNewData']['begin_serial_to'] : $validatedData['addNewData']['end_serial_to'];

        RptBooklet::create($validatedData['addNewData']);

        $this->showAddValue = false;

        $this->mount();

        $this->dispatchBrowserEvent('swalSuccess');
    }

    public function mount()
    {
        $this->bookletsData = RptBooklet::with('users')->get()->toArray();
    }

}
