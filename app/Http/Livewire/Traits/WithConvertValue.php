<?php

namespace App\Http\Livewire\Traits;

trait WithConvertValue
{
    public function convertQuarter($value)
    {
        switch ($value) {
            case 0.25: return 'Q1';
            case 0.50: return 'Q2';
            case 0.75: return 'Q3';
            default: return 'Q4'; break;
        }
    }


}
