<?php

namespace App\Http\Livewire\Settings\Users;

use App\Models\Role;
use Livewire\Component;

class Roles extends Component
{
    public $editedRoleIndex = null;
    public $roleArray = [];

    protected $rules = [
        'roleArray.*.id' => ['nullable'],
        'roleArray.*.name' => ['required'],
        'roleArray.*.slug' => ['required'],
    ];
    public function mount()
    {
        $this->roleArray = Role::all()->toArray();
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editRole($index)
    {
        $this->editedRoleIndex = $index;
    }
    public function addRole()
    {
        $this->roleArray[] = [
            'id' => '',
            'name' => 'Sample Format',
            'slug' => 'sample-format',
        ];
    }
    public function saveRole()
    {
        $vdata = $this->validate();
        foreach ($vdata['roleArray'] as $key => $value) {

            if (!is_null($value['id']) && !empty($value['id'])) {
                $editedValue = Role::find($value['id']);
                $editedValue->update($value);
            } else {
                Role::create($value);
            }
        }
        $this->dispatchBrowserEvent('usersRolesClose');
        $this->emitUp('usersRefresh');
        $this->dispatchBrowserEvent('swalUpdate');
    }

    public function removeRole($index)
    {
        $sellectedData = Role::find($this->roleArray[$index]['id']);
        if (!is_null($sellectedData)) {
            $sellectedData->delete();
        }
        unset($this->roleArray[$index]);
        $this->roleArray = array_values($this->roleArray);
    }
    public function render()
    {
        return view('livewire.settings.users.roles');
    }
}
