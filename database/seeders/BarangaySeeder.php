<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('list_barangays')->insert([
            'code' => '60407001',
            'name' => 'Andagaw',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407002',
            'name' => 'Bachaw Norte',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407003',
            'name' => 'Bachaw Sur',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407004',
            'name' => 'Briones',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407005',
            'name' => 'Buswang New',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407006',
            'name' => 'Buswang Old',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407007',
            'name' => 'Caano',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407008',
            'name' => 'Estancia',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407009',
            'name' => 'Linabuan Norte',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407010',
            'name' => 'Mabilo',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407011',
            'name' => 'Mobo',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407012',
            'name' => 'Nalook',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407013',
            'name' => 'Poblacion',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407014',
            'name' => 'Pook',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407015',
            'name' => 'Tigayon',
            'is_active' => 1,
        ]);
        DB::table('list_barangays')->insert([
            'code' => '60407016',
            'name' => 'Tinigaw',
            'is_active' => 1,
        ]);
    }
}
