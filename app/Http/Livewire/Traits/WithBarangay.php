<?php

namespace App\Http\Livewire\Traits;

use App\Models\ListBarangay;

trait WithBarangay
{
    public function getBarangayList(){
        return ListBarangay::select('name','index')->get();
    }

}
