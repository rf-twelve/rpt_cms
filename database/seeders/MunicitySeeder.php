<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('list_municities')->insert([
            'code' => '060407000',
            'name' => 'Kalibo',
            'is_active' => 1,
        ]);
    }
}
