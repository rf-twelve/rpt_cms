<?php

namespace Database\Seeders;

use App\Models\ListCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ListCategory::insert(['name' => 'Governor', 'is_active' => 1]);
        ListCategory::insert(['name' => 'Vice Governor', 'is_active' => 1,]);
        ListCategory::insert(['name' => 'SP Member', 'is_active' => 1,]);
        ListCategory::insert(['name' => 'Mayor', 'is_active' => 1,]);
        ListCategory::insert(['name' => 'Vice Mayor', 'is_active' => 1,]);
        ListCategory::insert(['name' => 'SB Member', 'is_active' => 1,]);
    }
}
