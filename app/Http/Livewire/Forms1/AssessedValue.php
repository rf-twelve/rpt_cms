<?php

namespace App\Http\Livewire\Forms;

use Livewire\Component;

class AssessedValue extends Component
{
    public $assessedValue;
    protected $listeners = [
        'refreshForm' => '$refresh',
        'addAssessedValue' => 'addAssessedValueEvent',
        // 'viewRecord' => 'viewRecordEvent'
    ];

    public function addAssessedValueEvent($data)
    {
        $this->updateOn = true;
        $this->assessedValue = $data;
        $this->dispatchBrowserEvent('assessedValueOpen');
        $this->emitSelf('refreshForm');
    }

    public function render()
    {
        return view('livewire.forms.assessed-value');
    }
}
