<?php

namespace App\Http\Livewire\Settings\Users;


use App\Models\RptTable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Accounts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $taxtable_fields = false;
    public $updateOn = false;
    public $temp_id = null;
    public $search;
    public $firstname, $lastname, $username, $password, $email, $roles, $birthdate, $address, $contact, $photo, $active;

    protected $listeners = [
        'usersRefresh' => '$refresh',
    ];

    protected $rules = [
        'firstname' => 'required',
        'lastname' => 'required',
        'username' => 'required',
        'password' => 'required',
        'email' => 'nullable',
        'roles' => 'nullable',
        'birthdate' => 'nullable',
        'address' => 'nullable',
        'contact' => 'nullable',
        'photo' => 'nullable',
        'active' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function newRecord()
    {
        $this->reset();
        $this->dispatchBrowserEvent('usersListOpen');
    }
    public function openRoles()
    {
        $this->reset();
        $this->dispatchBrowserEvent('usersRolesOpen');
    }
    public function openPermissions()
    {
        $this->reset();
        $this->dispatchBrowserEvent('usersPermissionsOpen');
    }

    public function editRecord($id)
    {
        $this->emit('editRecord', $id);
    }

    public function saveRecord()
    {
        $vData = $this->validate();

        if (empty($this->temp_id)) {
            $vData['password'] = Hash::make($this->password);
            $vData['password_copy'] = $this->password;
            User::create($vData);
        } else {
            $data = User::findOrFail($this->temp_id);
            $data->update([
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'username' => $this->username,
                'password' => Hash::make($this->password),
                'password_copy' => $this->password,
                'email' => $this->email,
                'birthdate' => $this->birthdate,
                'address' => $this->address,
                'contact' => $this->contact,
                'photo' => $this->photo,
                'active' => $this->active,
            ]);
        }
        $this->taxtable_fields = false;
        $this->dispatchBrowserEvent('swalSuccess');
    }

    public function deleteSingleRecord($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        $this->dispatchBrowserEvent('swalDelete');
    }

    public function render()
    {
        return view(
            'livewire.settings.users.accounts',
            [
                'usertables' => User::where(function ($query) {
                    $query->where('firstname', 'like', '%' . $this->search . '%')
                        ->orWhere('lastname', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%');
                })->orderBy('id', 'asc')->paginate(10)
            ]
        );
    }
}
