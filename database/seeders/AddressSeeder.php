<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_addresses')->insert([
            'person_id' => 1,
            'house_number' => 1,
            'street_name' => 1,
            'barangay_id' => 1,
            'municity_id' => 1,
            'province_id' => 1,
            'region_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
