<?php

namespace App\Http\Livewire\Settings;

use App\Models\RptBooklet;
use Livewire\Component;

class Booklet extends Component
{
    public $showAddValue = false;
    public $editedIndex = null;
    public $booklets_data = [];
    public $new_data = [
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
            'booklets' => $this->booklets_data,
        ]);
    }

    // public function updatednew_data.''.Form(){
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
        'booklets_data.'.$this->editedIndex.'.form' => ['required'],
        'booklets_data.'.$this->editedIndex.'.begin_qty' => ['required','numeric'],
        'booklets_data.'.$this->editedIndex.'.begin_serial_fr' => ['required','numeric'],
        'booklets_data.'.$this->editedIndex.'.begin_serial_to' => ['required','numeric'],
        'booklets_data.'.$this->editedIndex.'.issued_qty' => ['sometimes', 'numeric'],
        'booklets_data.'.$this->editedIndex.'.issued_serial_fr' => ['sometimes', 'numeric'],
        'booklets_data.'.$this->editedIndex.'.issued_serial_to' => ['sometimes', 'numeric'],
        'booklets_data.'.$this->editedIndex.'.end_qty' => ['sometimes', 'numeric'],
        'booklets_data.'.$this->editedIndex.'.end_serial_fr' => ['sometimes', 'numeric'],
        'booklets_data.'.$this->editedIndex.'.end_serial_to' => ['sometimes', 'numeric'],
        'booklets_data.'.$this->editedIndex.'.user_id' => ['required'],
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
            $foundRecord->update($validatedData['booklets_data'][$index]);
        }
        $this->editedIndex = null;
        $this->dispatchBrowserEvent('swalUpdate');
    }

    public function saveNew()
    {
        $validatedData = $this->validate([
            'new_data.form' => ['required'],
            'new_data.begin_qty' => ['required','numeric'],
            'new_data.begin_serial_fr' => ['required','numeric'],
            'new_data.begin_serial_to' => ['required','numeric'],
            'new_data.issued_qty' => ['sometimes', 'numeric'],
            'new_data.issued_serial_fr' => ['sometimes', 'numeric'],
            'new_data.issued_serial_to' => ['sometimes', 'numeric'],
            'new_data.end_qty' => ['sometimes', 'numeric'],
            'new_data.end_serial_fr' => ['sometimes', 'numeric'],
            'new_data.end_serial_to' => ['sometimes', 'numeric'],
            'new_data.user_id' => ['required'],
        ]);
        $validatedData['new_data']['end_qty'] = empty($validatedData['new_data']['end_qty'])
            ? $validatedData['new_data']['begin_qty'] : $validatedData['new_data']['end_qty'];
        $validatedData['new_data']['end_serial_fr'] = empty($validatedData['new_data']['end_serial_fr'])
            ? $validatedData['new_data']['begin_serial_fr'] : $validatedData['new_data']['end_serial_fr'];
        $validatedData['new_data']['end_serial_to'] = empty($validatedData['new_data']['end_serial_to'])
            ? $validatedData['new_data']['begin_serial_to'] : $validatedData['new_data']['end_serial_to'];

        RptBooklet::create($validatedData['new_data']);

        $this->showAddValue = false;

        $this->mount();

        $this->dispatchBrowserEvent('swalSuccess');
    }

    public function mount()
    {
        $this->booklets_data = RptBooklet::with('users')->get()->toArray();
    }

}
