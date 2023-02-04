<?php

namespace App\Http\Livewire\Settings\Users;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Userlist extends Component
{
    public $uid, $firstname, $lastname, $username, $password, $roles, $permissions;
    protected $listeners = [
        'usersRefresh' => '$refresh',
        'editRecord' => 'editRecordEvent',
    ];

    protected $rules = [
        'uid' => 'nullable',
        'firstname' => 'required',
        'lastname' => 'required',
        'username' => 'required',
        'password' => 'required',
        'roles' => 'required',
        'permissions' => 'required',
    ];


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function saveRecord()
    {
        $vData = $this->validate();
        dd($vData);
        $roleData = role::findOrFail($vData['roles']);
        $PermissionData = Permission::findOrFail($vData['permissions']);

        if (empty($vData['uid'])) {
            $vData['id'] = $vData['uid'];
            $vData['password'] = Hash::make($this->password);
            $vData['password_copy'] = $this->password;
            $vData['active'] = 1;
            $userData = User::create($vData);
            $userData->roles()->attach($roleData);
            $userData->permissions()->attach($PermissionData);
        } else {
            $data = User::findOrFail($vData['uid']);
            $data->update([
                'firstname' => $vData['firstname'],
                'lastname' => $vData['lastname'],
                'username' => $vData['username'],
                'password' => Hash::make($vData['password']),
                'password_copy' => $vData['password'],
                'active' => 1,
            ]);
            $data->roles()->sync($roleData);
            $data->permissions()->sync($PermissionData);
        }
        $this->taxtable_fields = false;
        $this->emit('usersRefresh');
        $this->dispatchBrowserEvent('usersListClose');
        $this->dispatchBrowserEvent('swalSuccess');
    }

    public function editRecordEvent($id)
    {
        $this->dispatchBrowserEvent('usersListOpen');
        $this->setFields($id);
    }

    public function setFields($id)
    {
        $permissionsArray = [];
        $data = User::findOrFail($id);
        $num = 0;
        if($data->permissions){
            foreach($data->permissions as $item){
            $permissionsArray[$num] = $item->id;
            $num++;
            }
        }
        // dd($permissionsArray);

        $this->uid = $data->id;
        $this->firstname = $data->firstname;
        $this->lastname = $data->lastname;
        $this->username = $data->username;
        $this->password = $data->password_copy;
        $this->roles = count($data->roles) ? $data->roles[0]->id : null;
        $this->permissions = $permissionsArray;
        $this->active = $data->active;
    }

    public function closeRecord()
    {
        $this->reset();
        $this->dispatchBrowserEvent('usersListClose');
    }

    public function render()
    {
        return view('livewire.settings.users.userlist',[
            'rolesArray' => Role::all()->toArray(),
            'permissionsArray' => Permission::all()->toArray(),
        ]);
    }
}
