<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class Users extends Component
{
    protected $listeners = [
        'usersRefresh' => '$refresh',
    ];

    public function mount()
    {
        $this->emitSelf('userRefresh');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.settings.users');
    }
}
