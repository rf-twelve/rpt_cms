<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $manageUser = new Permission();
        $manageUser->name = 'Access Dashboard';
        $manageUser->slug = 'access-dashboard';
        $manageUser->save();

        $manageUser = new Permission();
        $manageUser->name = 'Access Assessor';
        $manageUser->slug = 'access-assessor';
        $manageUser->save();

        $manageUser = new Permission();
        $manageUser->name = 'Access Real property Tax';
        $manageUser->slug = 'access-rpt';
        $manageUser->save();

        $manageUser = new Permission();
        $manageUser->name = 'Access Settings';
        $manageUser->slug = 'access-settings';
        $manageUser->save();

        $manageUser = new Permission();
        $manageUser->name = 'Access Reports';
        $manageUser->slug = 'access-reports';
        $manageUser->save();

        $manageUser = new Permission();
        $manageUser->name = 'Manage Assesstment Roll';
        $manageUser->slug = 'manage-assesstment_roll';
        $manageUser->save();

        $manageUser = new Permission();
        $manageUser->name = 'Manage Account Verification';
        $manageUser->slug = 'manage-account_verification';
        $manageUser->save();

        $manageUser = new Permission();
        $manageUser->name = 'Manage Collection';
        $manageUser->slug = 'manage-collection';
        $manageUser->save();

        $manageUser = new Permission();
        $manageUser->name = 'Manage Address';
        $manageUser->slug = 'manage-address';
        $manageUser->save();

        $manageUser = new Permission();
        $manageUser->name = 'Manage Tax Table';
        $manageUser->slug = 'manage-tax_table';
        $manageUser->save();

        $manageUser = new Permission();
        $manageUser->name = 'Manage User';
        $manageUser->slug = 'manage-user';
        $manageUser->save();

    }
}
