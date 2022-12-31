<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RptAccountableForm extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getAllAFWithSelectedUser() {
        return RptAccountableForm::query()
        ->with(['user' => function ($query) {
            $query->select('id', 'firstname', 'lastname');
        }])
        ->get()->toArray();
    }

}
