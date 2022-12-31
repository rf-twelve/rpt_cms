<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssessedValueLabel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $data = [
            [
                'bracket' => 'bracket_01', 'year_from' => '1957', 'year_to' => '1966', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_02', 'year_from' => '1967', 'year_to' => '1973', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_03', 'year_from' => '1974', 'year_to' => '1979', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_04', 'year_from' => '1980', 'year_to' => '1984', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_055', 'year_from' => '1985', 'year_to' => '1993', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_06', 'year_from' => '1994', 'year_to' => '1996', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_07', 'year_from' => '1997', 'year_to' => '2002', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_08', 'year_from' => '2003', 'year_to' => '2018', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_09', 'year_from' => '2019', 'year_to' => '2019', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_10', 'year_from' => '2020', 'year_to' => '2020', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_11', 'year_from' => '2021', 'year_to' => '2021', 'is_active' => '1',
            ],
            [
                'bracket' => 'bracket_12', 'year_from' => '2022', 'year_to' => '2022', 'is_active' => '1',
            ],
        ];
        DB::table('rpt_account_a_v_labels')->insert($data);
    }
}
