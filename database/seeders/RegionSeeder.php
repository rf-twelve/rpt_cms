<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('list_regions')->insert([
            'code' => '060000000',
            'name' => 'REGION VI (Western Visayas)',
            'is_active' => 1,
        ]);
    }
}
