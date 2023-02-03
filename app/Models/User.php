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

    protected $guarded = [];

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
    public function trans_records()
    {
        return $this->hasMany(RptPaymentRecord::class,'pay_teller');
    }

    public function issued_receipts()
    {
        return $this->hasMany(RptIssuedReceipt::class,'user_id');
    }

    public function getUserFullnameAttributes(){
        $user = User::find($this->id);
        return $user->firstname.' '.$user->lastname;
    }

    public function findUserByID(){
        return (User::find($this->id))->firstname;
    }

    public function getAllUserAttributes(){
        return User::get();
    }

}
