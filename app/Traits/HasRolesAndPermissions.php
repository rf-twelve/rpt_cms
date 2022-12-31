<?php
namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait HasRolesAndPermissions
{

    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'permission_user');
    }

    // (... $roles ) Three dots means data is an array{
    public function hasRole(... $roles ) {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission)->count();
    }


    protected function hasPermissionTo($permission)
    {
    return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission as $role){
            if($this->roles->contains($role)) {
                return true;
            }

        }
        return false;
    }

    // Get all slug in Permission table
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug',$permissions)->get();
    }

    public function givePermissionsTo(... $permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
            return $this;
        }
        // dd($permissions);
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function deletePermissions(... $permissions )
{
    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;
}
}
