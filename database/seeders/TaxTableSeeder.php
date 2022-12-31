<?php

namespace Database\Seeders;

use App\Http\Livewire\Settings\TaxTable;
use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{

    public function run()
    {
        TaxTable::insert([
            'bracket' => 'bracket_01',
            'label' => '1957-1966',
            'year_fr' => '',
            'year_to' => '',
            'year_no' => '',
            'january' => '',
            'february' => '',
            'march' => '',
            'april' => '',
            'may' => '',
            'june' => '',
            'july' => '',
            'august' => '',
            'september' => '',
            'october' => '',
            'november' => '',
            'december' => '',
            'is_active' => 1,
        ]);
    }
}
