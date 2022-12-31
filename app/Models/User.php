<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasRolesAndPermissions;

class User extends Authenticatable
{
    // use LaratrustUserTrait;
    // use HasPermissionsTrait;
    use HasFactory, Notifiable, HasRolesAndPermissions;

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'password',
        'password_copy',
        'email',
        'birthdate',
        'address',
        'contact',
        'photo',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function booklets()
    {
        return $this->hasMany(RptBooklet::class);
    }

    public function findUserByID($id){
        return (User::find($id))->firstname;
    }

    public function getAllUser(){
        return User::get();
    }

}
