<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = new Role();
        $manager->name = 'Admin User';
        $manager->slug = 'admin-user';
        $manager->save();

        $developer = new Role();
        $developer->name = 'Generic User';
        $developer->slug = 'generic-user';
        $developer->save();

        $developer = new Role();
        $developer->name = 'Guest User';
        $developer->slug = 'guest-user';
        $developer->save();
    }
}
