<?php


namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = User::find(Auth::user()->id);

        // dump($user->hasPermission('access-dashboard'));
        // dump($user->hasRole('web-developer')); // will return true
        // dump($user->hasRole('project-manager'));// will return false
        // dump($user->hasPermission('create-tasks'));// will return true
        // dump($user->hasPermissionTo('manage-users'));
        // dump($user->hasPermissionThroughRole('manage-users'));
        // dump($user->deletePermissions('manage-users'));
        // dd($user->can('manage-users'));
        // dd(auth()->user());
        // dump($user->givePermissionsTo('manage-users'));
        return view('livewire.dashboard');
    }
}
