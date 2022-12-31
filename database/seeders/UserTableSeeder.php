<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'sample@sample.com',
            'email_verified_at' => now(),
            'username' => 'admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'password_copy' => 'password',
            'roles' => 'admin',
            'birthdate' => '2021-01-01',
            'address' => 'Kalibo',
            'contact' => '123456789',
            'photo' => '',
            'active' => '1',
            'remember_token' => Str::random(10),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Gerneric',
            'lastname' => 'User',
            'email' => 'sample@sample.com',
            'email_verified_at' => now(),
            'username' => 'user',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'password_copy' => 'password',
            'roles' => 'user',
            'birthdate' => '2021-01-01',
            'address' => 'Kalibo',
            'contact' => '123456789',
            'photo' => '',
            'active' => '1',
            'remember_token' => Str::random(10),
        ]);
    }
}
