<?php

namespace App\Http\Livewire\Settings\Users;

use App\Models\Permission;
use Livewire\Component;

class Permissions extends Component
{
    public $editedPermissionIndex = null;
    public $permissionArray = [];

    protected $rules = [
        'permissionArray.*.id' => ['nullable'],
        'permissionArray.*.name' => ['required'],
        'permissionArray.*.slug' => ['required'],
    ];
    public function mount()
    {
        $this->permissionArray = Permission::all()->toArray();
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function editPermission($index)
    {
        $this->editedPermissionIndex = $index;
    }
    public function addPermission()
    {
        $this->permissionArray[] = [
            'id' => '',
            'name' => 'Sample Format',
            'slug' => 'sample-format',
        ];
    }
    public function savePermission()
    {
        $vdata = $this->validate();
        foreach ($vdata['permissionArray'] as $key => $value) {

            if (!is_null($value['id']) && !empty($value['id'])) {
                $editedValue = Permission::find($value['id']);
                $editedValue->update($value);
            } else {
                Permission::create($value);
            }
        }
        $this->dispatchBrowserEvent('usersPermissionsClose');
        $this->emitUp('usersRefresh');
        $this->dispatchBrowserEvent('swalUpdate');
    }

    public function removePermission($index)
    {
        $sellectedData = Permission::find($this->permissionArray[$index]['id']);
        if (!is_null($sellectedData)) {
            $sellectedData->delete();
        }
        unset($this->permissionArray[$index]);
        $this->permissionArray = array_values($this->permissionArray);
    }

    public function render()
    {
        return view('livewire.settings.users.permissions');
    }
}
