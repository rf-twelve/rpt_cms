<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Sidebar Navigation
        Gate::define('access-dashboard', function (User $user) {
            return $user->hasPermission('access-dashboard') == 'access-dashboard';
        });
        Gate::define('access-assessor', function (User $user) {
            return $user->hasPermission('access-assessor') == 'access-assessor';
        });
        Gate::define('access-rpt', function (User $user) {
            return $user->hasPermission('access-rpt') == 'access-rpt';
        });
        Gate::define('access-settings', function (User $user) {
            return $user->hasPermission('access-settings') == 'access-settings';
        });
        Gate::define('access-reports', function (User $user) {
            return $user->hasPermission('access-reports') == 'access-reports';
        });

        // Sidebar Sub Navigation
        Gate::define('manage-assessment_roll', function (User $user) {
            return $user->hasPermission('manage-assessment_roll') == 'manage-assessment_roll';
        });
        Gate::define('manage-account_verification', function (User $user) {
            return $user->hasPermission('manage-account_verification') == 'manage-account_verification';
        });
        Gate::define('manage-collection', function (User $user) {
            return $user->hasPermission('manage-collection') == 'manage-collection';
        });
        Gate::define('manage-address', function (User $user) {
            return $user->hasPermission('manage-address') == 'manage-address';
        });
        Gate::define('manage-booklet', function (User $user) {
            return $user->hasPermission('manage-booklet') == 'manage-booklet';
        });
        Gate::define('manage-tax_table', function (User $user) {
            return $user->hasPermission('manage-tax_table') == 'manage-tax_table';
        });
        Gate::define('manage-forms', function (User $user) {
            return $user->hasPermission('manage-forms') == 'manage-forms';
        });
        Gate::define('manage-user', function (User $user) {
            return $user->hasPermission('manage-user') == 'manage-user';
        });

    }
}
