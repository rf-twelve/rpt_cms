<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('slug','admin-user')->first();
        $user = Role::where('slug', 'generic-user')->first();
        $guest = Role::where('slug', 'guest-user')->first();
        $dashboard = Permission::where('slug','access-dashboard')->first();

        $user1 = new User();
        $user1->firstname = 'Rosel';
        $user1->lastname = 'Francisco';
        $user1->username = 'admin';
        $user1->email = 'admin@gmail.com';
        $user1->password = bcrypt('password');
        $user1->save();
        $user1->roles()->attach($admin);
        $user1->permissions()->attach($dashboard);


        $user2 = new User();
        $user2->firstname = 'Victor';
        $user2->lastname = 'Wood';
        $user2->username = 'user';
        $user2->email = 'vic@gmail.com';
        $user2->password = bcrypt('password');
        $user2->save();
        $user2->roles()->attach($user);
        $user2->permissions()->attach($dashboard);

        $user3 = new User();
        $user3->firstname = 'John';
        $user3->lastname = 'Doe';
        $user3->username = 'guest';
        $user3->email = 'john@gmail.com';
        $user3->password = bcrypt('password');
        $user3->save();
        $user3->roles()->attach($guest);
        $user3->permissions()->attach($dashboard);
    }
}
