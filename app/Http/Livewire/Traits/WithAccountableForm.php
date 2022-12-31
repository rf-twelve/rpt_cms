<?php

namespace App\Http\Livewire\Traits;

use App\Models\RptAccountableForm;

trait WithAccountableForm
{
    // Get all payment record with user and accountable form
    public function getAccoutableForm($user_id){
        return RptAccountableForm::query()
            ->with(['user' => function ($query) {
                $query->select('id', 'firstname', 'lastname');
            }])
            ->where('user_id',$user_id)
            ->get()->toArray();
    }
}
