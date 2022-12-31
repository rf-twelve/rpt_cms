<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_people')->insert([
            'identifier_id' => 'JUANDELACRUZJR1990-01-01',
            'designation' => 'Candidate',
            'category' => 'Governor',
            'first_name' => 'Juan',
            'middle_name' => 'Dela',
            'last_name' => 'Cruz',
            'suffix' => 'Jr',
            'birthdate' => '1990-01-01',
            'sex' => 'M',
            'civil_status' => 'Single',
            'nationality' => 'Filipino',
            'contact_no' => '090123456789',
            'leaderist_id' => 'N/A',
            'is_active' => 1,
            'encoder_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tbl_people')->insert([
            'identifier_id' => 'JOSEDELACRUZJR1990-01-01',
            'designation' => 'Candidate',
            'category' => 'SB Member',
            'first_name' => 'Jose',
            'middle_name' => 'Dela',
            'last_name' => 'Cruz',
            'suffix' => 'Jr',
            'birthdate' => '1990-01-01',
            'sex' => 'M',
            'civil_status' => 'Single',
            'nationality' => 'Filipino',
            'contact_no' => '090123456789',
            'leaderist_id' => 'N/A',
            'is_active' => 1,
            'encoder_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tbl_people')->insert([
            'identifier_id' => 'PEDRODELACRUZSR1990-01-01',
            'designation' => 'Leaderist',
            'category' => 'N/A',
            'first_name' => 'Pedro',
            'middle_name' => 'Dela',
            'last_name' => 'Cruz',
            'suffix' => 'Sr',
            'birthdate' => '1990-01-01',
            'sex' => 'M',
            'civil_status' => 'Single',
            'nationality' => 'Filipino',
            'contact_no' => '090123456789',
            'leaderist_id' => 'N/A',
            'is_active' => 1,
            'encoder_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('tbl_people')->insert([
            'identifier_id' => 'MARIADELACRUZ1990-01-01',
            'designation' => 'Member',
            'category' => 'N/A',
            'first_name' => 'Maria',
            'middle_name' => 'Dela',
            'last_name' => 'Cruz',
            'suffix' => '',
            'birthdate' => '1990-01-01',
            'sex' => 'F',
            'civil_status' => 'Single',
            'nationality' => 'Filipino',
            'contact_no' => '090123456789',
            'leaderist_id' => 2,
            'is_active' => 1,
            'encoder_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
