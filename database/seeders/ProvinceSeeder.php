<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('list_provinces')->insert([
            'region_id' => 1,
            'code' => '060400000',
            'name' => 'Aklan',
            'is_active' => 1,
        ]);
    }
}
