<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([BarangaySeeder::class]);
        // $this->call([
        //     UserTableSeeder::class,
        //     AssessedValueLabel::class
        //     // // AddressSeeder::class,
        //     // // BarangaySeeder::class,
        //     // MunicitySeeder::class,
        //     // ProvinceSeeder::class,
        //     // RegionSeeder::class,
        //     // CategorySeeder::class,
        // ]);

        // $this->call([MunicitySeeder::class]);
        // $this->call([ProvinceSeeder::class]);
        // $this->call([RegionSeeder::class]);
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
    }
}
